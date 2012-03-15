<?php
include_once("/Volumes/Web/vectorbase/includes/Jobs.php");
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');

try{
	$status = Jobs::getStatus($_GET['job_id']);
	$blastJobStatus = $status->status();		
}catch(JobException $e){
	$error = 1;
	if ($e->getJobCode() == JobException::NO_JOB) $errorMessage='We have no record for job '.$_GET['job_id'];
	else $errorMessage=$e->getMessage();
}
if($blastJobStatus['status']==null) $errorMessage='We have no record for job '.$_GET['job_id'];
elseif($blastJobStatus['status']!='Finished') $errorMessage='Job '.$_GET['job_id'].' has not finished';
if($_GET['job_id']==null) $errorMessage='No job id was provided';

//proceed if there are results for this job
if($error!=1 && $blastJobStatus['status']=='Finished' && $_GET['job_id']!=null){
	//look up some job params and figure out which results page we need
	include_once('lookUpInputParams.php');
	$separate=true;
	if($params['detailed_est']=='true')
		include_once('estResults.php');
	else
		include_once('results.php');
}
else{
	echo '<div class="jobBox" style="float:left;clear:both;margin:8px;padding:4px;">';
	echo '<div class="errorText">';
	echo $errorMessage;
	echo '</div></div>';
}
?>
