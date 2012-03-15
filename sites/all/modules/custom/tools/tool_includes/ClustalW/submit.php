<?
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	include_once($server_vars);
	include_once("Jobs.php");
	include_once("clustalw_errors.php");
	
	$errors = array();
//var_dump($_POST);
//exit();

//user has not entered numbers to look up a job id so user must be submitting
//if( is_nan($_POST["job_id"]) ) {

	// ERROR CHECKING
	if (!$_POST["get_clustalw"]){
		
		// Check to make sure we have input
		$have_input=1;
		if (($_FILES["input_file"]["error"])&&(strlen($_POST["input_sequence"])<5)){
			// Where's the input?
			array_push($errors,5);
			$have_input=0;
		}
		
		// Check to make sure our input sequence isn't bigger than 100k
		$TOO_BIG=0;
		
		// Get rid of stars...
		$_POST["input_sequence"] = preg_replace('/\*/','',$_POST["input_sequence"]);
		
		if ((strlen($_POST["input_sequence"])>$MAX_INPUT_SIZE)||( $_FILES["input_file"]["size"] > $MAX_INPUT_SIZE)){
			// Input sequence too big
			array_push($errors,7);
			$TOO_BIG=1;
		}
	
		// Try and move the input file (if provided) to a tmp location
		if ($_FILES["input_file"]["tmp_name"]){
			$upload_file = $TOOL_UPLOADS . md5($_SERVER['REQUEST_TIME']) . ".clustalw_input";
			if (move_uploaded_file($_FILES['input_file']['tmp_name'], $upload_file)) {
				$lines = file($upload_file);
				unlink($upload_file);
			} else {
				array_push($errors,8);
			}
		// If input comes in the text field, put it in an array just so it's like the file upload input
		} elseif (strlen($_POST["input_sequence"])>5){
			$lines = split("\n",$_POST["input_sequence"]);
		} elseif ($have_input){
			// if we get here and have input, something is wrong.... 
			array_push($errors,10);
		}
				
			
		// concat all lines into a single string and do some really lame error checking
		// Probably need a real fasta parser but I dunno about the biophp one..
		// This is lame error checking...
                // RB -> adding more extensive error checking

                for($lineI = 1; $lineI < sizeof($lines); $lineI++){
                  //if( preg_match('/[^A-Za-z]/', $lines[$lineI], $matches) == 1){
                  if (substr($lines[$lineI], 0, 1) != ">") {
                    $lines[$lineI] = preg_replace('/[ \n\r]/', '', $lines[$lineI]);
                    if( preg_match('/[^A-Za-z\s]/', $lines[$lineI], $matches) == 1){
                      array_push($errors,13);
                      break;
                    }
                  } else {
                    $lines[$lineI] = "\n" . $lines[$lineI];
                  }
                }
		$input_sequence_data = "";
		if (((substr($lines[0],0,1) != ">")||(!(preg_match('/^[A-z]/',$lines[1]))))&&($have_input)){
			array_push($errors,9);
		} else {
			if ((!$TOO_BIG)&&(count($lines)>0)){
				foreach ($lines as $line_num => $line){
					$input_sequence_data .= $line;	
				}
				if ((strlen($input_sequence_data)<5)&&($have_input)){
					array_push($errors,10);
				}
				if (substr_count($input_sequence_data,">")>100){
					array_push($errors,12);
				}
			}
		}
                //print_r($lines);
                //exit;
} else {
		// Check to see if they provided the job id if they're trying retrieve a job id
		if (!((int)($_POST["job_id"])) && (strlen($_POST["get_clustalw"])>0)){
			// No ClustalW Job ID!
			array_push($errors,6);
		}

		  // Check to see if job id exists and is Clustal job
		if (((int)($_POST["job_id"])) && (strlen($_POST["get_clustalw"])>0)){
		      $blast_job_status = Jobs::getStatus($_POST["job_id"], "clustal")->status();

			if($blast_job_status["error"]=="InvalidJobIdentifier"){
			    array_push($errors,15);
			}elseif(preg_match("#ClustalW_.{6}#",$blast_job_status["name"])==0){
			    array_push($errors,16);
			}
		  }

}
		
	// If we have errors, redirect to the input page with error codes attached to the url
	if (count($errors)){
		$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/ClustalW/?error=1";
		foreach ($errors as $error_code){
			$error_rdir .= "&e" . $error_code . "=1";
			if($error_code==15 || $error_code==16){
				$error_rdir.="&id=".$_POST["job_id"];
			}

		}
		header("Location: " . $error_rdir);
		exit();
	} else {
		// NO ERRORS
	
		// If the user is just asking for a job, just redirect them...
		$job_id="";
		if (((int)($_POST["job_id"])) && (strlen($_POST["get_clustalw"])>0)){
			$job_id = $_POST["job_id"];
		} else {
			// Create a new ClustalW JOB
			$input_sequence_data = str_replace(array("\r\n","\r"), "\n", $input_sequence_data);
			$clustalw_params_array = array("seqtype"=>$_POST["seqtype"],
							"alignment"=>$_POST["alignment"],
							"sequence"=>$input_sequence_data,
							"ktuple"=>$_POST["ktuple"],
							"wlength"=>$_POST["wlength"],
							"score"=>$_POST["score"],
							"tdiag"=>$_POST["tdiag"],
							"gpenalty"=>$_POST["gpenalty"],
							"matrix"=>$_POST["matrix"],
							"opengap"=>$_POST["opengap"],
							"endgap"=>$_POST["endgap"],
							"extgap"=>$_POST["extgap"],
							"sepgap"=>$_POST["sepgap"],
							"output"=>$_POST["output"],
							"order"=>$_POST["order"]
							);
			$new_job = new ClustalWJob($clustalw_params_array);
                        //print_r($new_job);
                        //exit;
			try {
     				$result = $new_job->submit();
				//print_r($result);
				//exit();
                        } catch (JobException $e) {
				$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/ClustalW/?error=1&e0=" . urlencode($e->getMessage());
				header("Location: " . $error_rdir);
				print "Error! Please see the error message <a href=\"$error_rdir\">here</a>.";
				exit();
			}		
			$job_id = $result;

    			if ($job_id == ""){
                        //print $job_id;
                        //exit;
    				$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/ClustalW/?error=1&e11=1";
				header("Location: " . $error_rdir);
				exit();
    			}

			//if job id isn't an int (error message returned) handle this			
			if ($job_id != "" && !(is_numeric($job_id))) {
    				$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/ClustalW/?error=1&e11=1";
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

			$jobtype_insert_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'program','ClustalW');";
			pg_query(DB::getJOB_DB(),$jobtype_insert_query);

			$ip_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'submitter_ip','" . $_SERVER["REMOTE_ADDR"] . "');";
			pg_query(DB::getJOB_DB(),$ip_query);

			$date_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'job_submit_date','" . date('Y\-m\-d G:i:s') . "');";
			pg_query(DB::getJOB_DB(),$date_query); 

			foreach($clustalw_params_array as $bpa_key => $bpa_value) {
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
		$status_rdr = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/ClustalW/?job_id=" . $job_id . "&page=status";
		header("Location: " . $status_rdr);				
		
	}
?>
