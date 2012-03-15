<?
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
sleep(4);

//this only needs a job_id variable passed to it
include_once("/Volumes/Web/vectorbase/includes/Jobs.php");
$jobId=$_GET['job_id'];

//try to get the job's status. alert user if there is no job with id they submitted
try {
	$status = Jobs::getStatus($jobId,"blast");
	$blastJobStatus = $status->status();		
} catch (JobException $e) {
	$error = 1;
	echo '<div class="jobBox" style="clear:both;">';
	echo '<h3><div class="errorText">';
	if ($e->getJobCode() == JobException::NO_JOB) echo 'We have no record for job '.$jobId;
	else echo $e->getMessage();
	echo '</div></h3></div>';
	exit();
}

if($blastJobStatus["status"]!="Finished"){
//actual blast search jobs are jobid -1
$searchStatus = Jobs::getStatus($jobId-1);
$searchJobStatus = $searchStatus->status();

	echo '<div class="jobBox" style="clear:both;">';

	//search jobs are pending. there must be other jobs ahead of ours
	if($searchJobStatus["status"]=='Pending'){
			unset($searchStatus);
			$pendingStatus["status"]="temp";
			$message="There are more than 10 jobs ahead of yours in the queue.";
			for($i=1; $i<11; $i++){
				$searchStatus = Jobs::getStatus($jobId-$i);
	 			$pendingStatus = $searchStatus->status();
				if($pendingStatus["status"]=="Running" || $pendingStatus["status"]==""){
					$message="There are $i jobs ahead of yours in the queue.";
					break;
				}
			}
	
		 	echo '
		 	<h3>Job '.$jobId.' is Pending. '.$message.'</h3>';
			sleep(4);
	//ught oh!
	}else if($searchJobStatus["status"]=='Failed' || $searchJobStatus["status"]=='Canceled'){
		echo '<h3>Job '.$jobId.' Failed!</h3>';
		echo '<!-- error -->';
	//search jobs are done, parser must be running
	}elseif($searchJobStatus["status"]=='Finished'){
		 echo '<h3>Job '.$jobId.' is Running: Parsing results</h3>';
	//jobs are running, display % done
	}elseif($searchJobStatus["status"]=='Running' || $searchJobStatus["status"]=='Prepared'){
		 echo '<h3>Job '.$jobId.' is Running: <meter min="0" max="100" value='.round($searchJobStatus["percentDone"]).' title="Job Completion" style="width:150px"></meter></h3>';

//		 <h3>Job '.$jobId.' is Running: '.round($searchJobStatus["percentDone"]).'% complete</h3>
//		<meter min="0" max="100" value='.round($searchJobStatus["percentDone"]).' title="Job Completion" style="width:100%"></meter>

	//something is wrong
	}else{
		 echo '<h3>Job '.$jobId.' status unknown. Emailing the <a href="mailto:webmaster@vectorbase.org">webmaster</a> with your job id might be a good idea</h3>';
		var_dump($searchJobStatus);
	}

	echo '</div>';

//parse job is done!
}else{

	$blast_programs["blastn"]="Nucleotide vs. Nucleotide";
	$blast_programs["tblastn"]="Peptide vs. Translated Nucleotide";
	$blast_programs["tblastx"]="Translated Nucleotide vs. Translated Nucleotide";
	$blast_programs["blastp"]="Peptide vs. Peptide";
	$blast_programs["blastx"]="Translated Nucleotide vs. Peptide";

	//this is probably the best spot to look up the parameters for the job and send them back to input.php
	$result=pg_query(DB::getJOB_DB(), "select * from job_params where job_id=$jobId");
	while ($row = pg_fetch_assoc($result)) {
		if($row['argument']=='target_database') $dbs[]=$row['value'];
		else $params .= $row['argument']."=".$row['value']."###";

		if($row['argument']=='program') $programDesc=$blast_programs[$row['value']];
	}

	//find # of est dbs searchable by blast
	$result=pg_query(DB::getUI_DB(), "select COUNT(*) from blast_databases where sequence_type='EST'");
	while ($row=pg_fetch_assoc($result)){
		$numOfESTs=$row['count'];
	}
	$estCount=0;

	//all the dbs on the input page are listed by id number
	foreach($dbs as $database){
		$blastDdIdsResult=pg_query(DB::getUI_DB(), "select b.blastdb_id, o.short_name, o.endowed, b.sequence_type from blast_databases b, organism o where b.file_name='$database' and b.organism_id=o.organism_id");
		$row = pg_fetch_assoc($blastDdIdsResult);
		if($row['blastdb_id'] && $row['short_name']){
			$params .= 'target_database='.$row['blastdb_id'].'###';
			//easy way to tell input.php which datasets to check
			if($row['endowed']=='t') $params .= 'target_dataset='.$row['short_name'].'###';
			else $params.='target_dataset=other###';

			if($row['sequence_type']=='EST') $estCount++;
		}else{
		//no blast db was found with that filename, it must be an est db
			$params .= 'estdbs=true###';
		}
	}

	if( $estCount==$numOfESTs) $params.= 'target_dataset=est###';

	//have this be the last param to make the regex parsing on input easier
	$params.= 'programDesc='.$programDesc.'###';

//some debugging output
/*
echo "error";
var_dump($params);
exit();
//*/
	echo "<div class=\"jobBox\" style=\"clear:both;\"> <!-- $params -->
			<h3>Retrieving results for job $jobId</h3>
		</div>";
}

?>
