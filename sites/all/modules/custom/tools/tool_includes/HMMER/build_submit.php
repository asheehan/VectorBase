<?
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	include_once($server_vars);
	include_once("Jobs.php");
	include_once("hmmer_errors.php");
	include("regex.php");
	$errors = array();

	// ERROR CHECKING

	if (!$_POST["get_hmmbuild"]){
		

		// Check to make sure we have input
		$have_input=1;
		if (($_FILES["input_file"]["error"])&&(strlen($_POST["input_sequence"])<5)){
			// Where's the input?
			array_push($errors,5);
			$have_input=0;
		}

		// Check to make sure our input sequence isn't bigger than 100k
		$TOO_BIG=0;
		if ((strlen($_POST["input_sequence"])>$MAX_INPUT_SIZE)||( $_FILES["input_file"]["size"] > $MAX_INPUT_SIZE)){
			// Input sequence too big
			array_push($errors,7);
			$TOO_BIG=1;
		}
	

		// Make sure user inputs are integers, 'default', or nothing
		if ( !(
			(RegexNumber($_POST["randomseqlength"]) || $_POST["randomseqlength"]=='default') && 
			(RegexNumber($_POST["randomseed"]) || $_POST["randomseed"]=='default') &&
			RegexNumber($_POST["randomseqlengthmean"]) && RegexNumber($_POST["sampledseqs"]) &&
			RegexNumber($_POST["randomseqlengthstddev"])
		   ))
			array_push($errors,14);


		// Try and move the input file (if provided) to a tmp location
		if ($_FILES["input_file"]["tmp_name"]){
			$upload_file = $TOOL_UPLOADS . md5($_SERVER['REQUEST_TIME']) . ".hmmbuild_input";
			if (move_uploaded_file($_FILES['input_file']['tmp_name'], $upload_file)) {
				$lines = file($upload_file);
				unlink($upload_file);
			} else {
				array_push($errors,8);
			}
		// If input comes in the text field, put it in an array just so it's like the file upload input
		} elseif (strlen($_POST["input_sequence"])>5){
			//$lines = split("\n",$_POST["input_sequence"]);
			$lines = $_POST["input_sequence"];
		} elseif ($have_input){
			// if we get here and have input, something is wrong.... 
			array_push($errors,10);
		}
		$input_sequence_data = $lines;
                //print_r($input_sequence_data);
                //exit;
	} else {
		// Check to see if they provided the job id if they're trying retrieve a job id
		if (!((int)($_POST["job_id"])) && (strlen($_POST["get_hmmbuild"])>0)){
			// No HMMBUILD Job ID!
			array_push($errors,6);
		}
	}
	
	// If we have errors, redirect to the input page with error codes attached to the url
	if (count($errors)){
		$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMBUILD/?error=1";
		foreach ($errors as $error_code){
			$error_rdir .= "&e" . $error_code . "=1";
		}
		header("Location: " . $error_rdir);
		exit();
	} else {
		// NO ERRORS

		// If the user is just asking for a job, just redirect them...
		$job_id="";
		if (((int)($_POST["job_id"])) && (strlen($_POST["get_hmmbuild"])>0)){
			$job_id = $_POST["job_id"];
		} else {
			// Create a new HMMBUILD JOB
			$input_sequence_data = str_replace(array("\r\n","\r"), "\n", $input_sequence_data);
			$hmmbuild_params_array = array("seqtype"=>$_POST["seqtype"],
							 "algorithm"=>$_POST["algorithm"],
							 "alignment"=>$_POST["alignment"],
							 "calibrate"=>$_POST["calibrate"],
							 "randomseqlength"=>$_POST["randomseqlength"],
							 "randomseed"=>$_POST["randomseed"],
							 "randomseqlengthmean"=>$_POST["randomseqlengthmean"],
							 "sampledseqs"=>$_POST["sampledseqs"],
							 "randomseqlengthstddev"=>$_POST["randomseqlengthstddev"],
							 "sequence"=>$input_sequence_data
							 );

			$new_job = new HMMBUILDJob($hmmbuild_params_array);
                        //print_r($new_job);
                        //exit;
			try {
     				$result = $new_job->submit();
				//print_r($result);
				//exit();
                        } catch (JobException $e) {
				$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMBUILD/?error=1&e0=" . urlencode($e->getMessage());
				header("Location: " . $error_rdir);
				print "Error! Please see the error message <a href=\"$error_rdir\">here</a>.";
				exit();
			}		
			//DAC $job_id = $result["id"];
                        $job_id = $result;  

    			if ($job_id == ""){
                        //print $job_id;
                        //exit;
    				$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMBUILD/?error=1&e11=1";
				header("Location: " . $error_rdir);
				exit();
    			}

			
                        //++rb  inserting job information into the database.
			
			if($_SESSION['logged_in']){
				$uid = $_SESSION['user_id'];
			} else {
				$uid = 'USERID_00000000001';
			}
			
			$jobuser_insert_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'user_id','" . $uid . "');";
			pg_query(DB::getJOB_DB(),$jobuser_insert_query);

			$jobtype_insert_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'job_type','HMMBUILD');";
			pg_query(DB::getJOB_DB(),$jobtype_insert_query);

			$ip_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'submitter_ip','" . $_SERVER["REMOTE_ADDR"] . "');";
			pg_query(DB::getJOB_DB(),$ip_query);

			$date_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'job_submit_date','" . date('Y\-m\-d G:i:s') . "');";
			pg_query(DB::getJOB_DB(),$date_query); 

			foreach($hmmbuild_params_array as $bpa_key => $bpa_value) {
				if($bpa_key == "databases"){
					foreach ($bpa_value as $database){
						$bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", 'target_database','". $database ."')";
						//print $bpa_query . "<br/>";
						pg_query(DB::getJOB_DB(), $bpa_query);
					}
				} else {
					$bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", '".$bpa_key."', '".$bpa_value."')";
					pg_query(DB::getJOB_DB(), $bpa_query);
					//print $bpa_query . "<br/>";
				}
				
			}
			// --rb
			
		}
	
		// Redirect to the job status page
		$status_rdr = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/HMMBUILD/?job_id=" . $job_id . "&page=status";
		header("Location: " . $status_rdr);				
		
	}
?>
