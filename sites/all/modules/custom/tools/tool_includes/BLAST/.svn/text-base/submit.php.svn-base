<?php
$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
include ($server_vars);
include_once("Jobs.php");
include("blast_errors.php");

// debug testing for Input.php
/*
echo "error";
var_dump($_POST);
exit();
//*/
//submitting a new job
if($_POST['job_id']=='Retrive BLAST Job ID' || $_POST['job_id']==''){

	// input.php replaced \n with Z-z-Z string because otherwise line breaks are lost when transfering sequence from input.php to submit.php with ajax,
	$input_sequence_data = preg_replace("#Z-z-Z#","\n",trim($_POST["input_sequence"]));

	//replace 's to html safe 's in fasta identifier lines so the sql insert doesn't break
	$input_sequence_data = preg_replace("#'#","&#39;",$input_sequence_data);

	//if there's an est search, the est blast dbs will need to be looked up
	if($_POST['detailed_est']){
		$sql = "select filename from blast_est";
		$dbResult = pg_query(DB::getUI_DB(),$sql);
		while ($row = pg_fetch_assoc($dbResult)){
			$_POST["blastdbs"][] = $row["filename"];
		}
	}else if($_POST['standard_est']){
		$sql = "select file_name from blast_databases where sequence_type='EST'";
		$dbResult = pg_query(DB::getUI_DB(),$sql);
		while ($row = pg_fetch_assoc($dbResult)){
			$_POST["blastdbs"][] = $row["file_name"];
		}
	}
	//remove any duplicates the previous est commands may have entered
	$_POST['blastdbs']=array_unique($_POST['blastdbs']);

	//submit search
	$blast = new BLASTJob($submitter,$_POST["program"],$input_sequence_data,$_POST["blastdbs"],$_POST["wordsize"],$_POST["evalue"],$_POST["scoringmatrix"],$_POST["dust"],$_POST["num_results"],$_POST["num_results"]);

	$result = $blast->submit();

	try { } catch (JobException $e) {
		$error_rdir = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/BLAST/?error=1&e0=" . urlencode($e->getMessage());
		header("Location: " . $error_rdir);
		print "Error! Please see the error message <a href=\"$error_rdir\">here</a>.";
		exit();
	}

	$job_id = $result;

	if($job_id==''){
		echo '<!-- error --> <div class="jobBox" style="margin-right:8px"><div class="errorText">Unable to get a job id, the cluster may be offline.</div></div>';
		exit();
	}

	$blast_params_array = array("program"=>$_POST["program"],
		"sequence"=>$input_sequence_data,
		"databases"=>$_POST["blastdbs"],
		"wordsize"=>$_POST["wordsize"],
		"numhits_oneline"=>$_POST["num_results"],
		"numhits_align"=>$_POST["num_results"],
		"evalue"=>$_POST["evalue"],
		"scoringmatrix"=>$_POST["scoringmatrix"],
		"masking"=>$_POST["dust"],
		"searchId"=>$blast->searchId);

	if($_SESSION['logged_in']) $uid = $_SESSION['user_id'];
	else $uid = 'Anonymous';

	//enter search information into job db
	$jobtype_insert_query = "insert into job_params (job_id, argument, value) values (". $job_id .", 'job_type','" . $_POST["program"]. "')";
	pg_query(DB::getJOB_DB(), $jobtype_insert_query);

	$jobuser_insert_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'user_id','" . $uid . "')";
	pg_query(DB::getJOB_DB(), $jobuser_insert_query);

	$ip_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'submitter_ip','" . $_SERVER["REMOTE_ADDR"] . "');";
	pg_query(DB::getJOB_DB(),$ip_query);

	$date_query = "insert into job_params (job_id,argument,value) values (" . $job_id . ",'job_submit_date','" . date('Y\-m\-d H:i:s') . "');";
	pg_query(DB::getJOB_DB(),$date_query);

	if($_POST['detailed_est']) pg_query(DB::getJOB_DB(), "insert into job_params (job_id,argument,value) values (" . $job_id . ",'detailed_est','true');");
	else pg_query(DB::getJOB_DB(), "insert into job_params (job_id,argument,value) values (" . $job_id . ",'detailed_est','false');");

	foreach($blast_params_array as $bpa_key => $bpa_value) {
		if($bpa_key == "databases"){
			foreach ($bpa_value as $database){   
				$bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", 'target_database','". $database ."')";
				pg_query(DB::getJOB_DB(), $bpa_query);
			}
		}else{
			$bpa_query = "insert into job_params (job_id, argument, value) values (".$job_id.", '".$bpa_key."', '".$bpa_value."')";
			pg_query(DB::getJOB_DB(), $bpa_query);
		}
	}

	//oh no! no id was returned. app server or xgrid is down
	if ($job_id == "") echo '<span class="errorText">No job id was returned! VectorBase is malfunctiong at the moment but should be fixed shortly.</span>';
	// id was correctly returned, display it for input.php 
	else echo $job_id;
}
// a job id was given for job retrival, lets jump to the status page
else{
	$status_rdr = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/BLAST/?job_id=".$_POST['job_id']."&page=status";
	header("Location: " . $status_rdr);
}
?>
