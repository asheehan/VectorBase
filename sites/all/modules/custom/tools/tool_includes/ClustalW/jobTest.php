<?php
include_once('/Volumes/Web/vectorbase/includes/Jobs.php');

$job = Jobs::getStatus($_GET["job_id"], "");
$job_status = $job->status();
print_r($job_status['status']);


try {
	$job_status = Jobs::getStatus($_GET["job_id"], "ClustalW");
} catch (JobException $e) {
	$error = 1;
	print "<tr><td colspan=\"2\"><span style=\"font-size:12px;\"><span style=\"color:red;font-weight:bold;\">Error: </span>";
	if ($e->getJobCode() == JobException::NO_JOB){
		print "No Record of job " . $_GET["job_id"] . " found.";
	} else {
		print "Please report the follwing message to the site administrator: <b>" . $e->getMessage() . "</b>";
	}
	print "</span></td></tr>";

print_r($e);
} 

?>
