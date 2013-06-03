<?php
# Log is at /vectorbase/web/logs/xgridCron.log
$dbhost = isset($argv[1]) ? $argv[1] : null;
$m = isset($argv[2]) && is_numeric($argv[2]) ? $argv[2] : null;
$d = isset($argv[3]) && is_numeric($argv[3]) ? $argv[3] : null;
$usage = "Usage: purgeBlastRecordsAndGffFiles.php [ip address of database] [older than # of months to purge] [older than # days to purge]\n";
$log = fopen('/vectorbase/web/logs/xgridCron.log', 'a');
if(is_null($dbhost) || is_null($m) || is_null($d)) {
	fwrite($log, "Could not run script: $usage");	
	exit;
}
date_default_timezone_set("America/New_York");
fwrite($log, "Purging drupal's databases for stuff that is older than $m months $d days old on " . date('d M Y, H:i:s e') . "\n");
$conn = pg_connect("host=$dbhost port=5432 dbname=vb_drupal user=db_public password=limecat");

$gatherRawIdQuery = 'SELECT r.value AS rawId, r.job_id as parseId FROM xgrid_job_params d, xgrid_job_params r WHERE d.argument = \'date\' AND d.job_id = r.job_id AND r.argument = \'rawId\' AND AGE(TO_DATE(d.value, \'MM/DD/YY\')) > CAST ($1 AS INTERVAL)'; 

$result = pg_prepare($conn, '', $gatherRawIdQuery);
$result = pg_execute($conn, '', array("$m months $d days"));
$rawIds = array();
$parseIds = array();
while ($row = pg_fetch_assoc($result)) {
	$rawIds[] = $row['rawid']; // stupid php pg functions aren't case sensistive, but php arrays are.
	$parseIds[] = $row['parseid'];
}

$gatherResultIdQuery = 'SELECT br_id FROM blast_results WHERE search_id IN ';
$rawInClause = '($1';
$brInClause = '($1';
$resultIds = array();
if(!empty($rawIds)) {

	// Make in clause for raw ids
	for($i = 2; $i <= count($rawIds); $i++) {
		$rawInClause .= ",\$$i";
	}
	$rawInClause .= ')';
	$gatherResultIdQuery .= '($1)';//$rawInClause;
	$gatherResultIdQuery .= ' group by br_id';	
	//print($gatherResultIdQuery);
	// Make in clause for blast result ids	
	$result = pg_prepare($conn, '', $gatherResultIdQuery);
	$result = pg_execute($conn, '', array('234719'));//$rawIds);
	while($row = pg_fetch_assoc($result)) {
		$resultIds[] = $row['br_id'];	
	}
}
//print($rawIds[0]);
//print_r($rawIds);
print_r($resultIds);
exit;

$deleteHitsQuery = '';
if(!empty($rawIds)) {

	$deleteHitsQuery = 'DELETE FROM blast_hits WHERE br_id IN ';
	$brInClause = '($1';
	if(!empty($resultIds)) {
		for($i = 2; $i <= count($resultIds); $i++) {
			$brInClause .= ",\$$i";
		}
		$brInClause .= ')';
	}
	$deleteHitsQuery .= $brInClause;
}


// BAA-LETED!!!
// $deleteHitsQuery was created in the above if statement
$deleteResultsQuery = "DELETE FROM blast_results WHERE search_id IN $rawInClause";
$deleteHspsQuery = "DELETE FROM blast_hsps WHERE search_id IN $rawInClause";
$deleteXgridParamsQuery = "DELETE FROM xgrid_job_params WHERE job_id IN $rawInClause"; // There will always be the same # of raw and parse ids.

$hitsDeleted = 0;
$resultsDeleted = 0;
$hspsDeleted = 0;
$xgridDeleted = 0;

//ssh bella "psql -U postgres -c \"COPY blast_results to '/tmp/blast_results'; COPY blast_hits to '/tmp/blast_hits'; COPY blast_hsps to '/tmp/blast_hsps'; COPY xgrid_job_params to '/tmp/xgrid_job_params';\" vb_drupal"

if(!empty($rawIds) && pg_close($conn)) {

	$backupFolder = '/tmp/blastPurgeBackup_' . date('d_M_Y_His');
	mkdir($backupFolder);
	chmod($backupFolder, 0777);
	fwrite($log, "Backing up databases to '$backupFolder'\n");
	$archiveOutput = array();
	exec("psql -U postgres -c \"COPY blast_results to '$backupFolder/blast_results'; COPY blast_hits to '$backupFolder/blast_hits'; COPY blast_hsps to '$backupFolder/blast_hsps'; COPY xgrid_job_params to '$backupFolder/xgrid_job_params';\" vb_drupal", $archiveOutput);
	fwrite($log, print_r($archiveOutput, true));

	$conn = pg_connect("host=$dbhost port=5432 dbname=vb_drupal user=db_public password=limecat");
	$result = pg_prepare($conn, '', $deleteHitsQuery);
	$result = pg_execute($conn, '', $resultIds);
	if(!$result) {
		fwrite($log, "Failed to delete records from blast_hits\n");	
	} else {
		$hitsDeleted = pg_affected_rows($result);
		fwrite($log, "Deleted $hitsDeleted from blast_hits\n");
	}


	$result = pg_prepare($conn, '', $deleteResultsQuery);
	$result = pg_execute($conn, '', $rawIds);
	if(!$result) {
		fwrite($log, "Failed to delete records from blast_results\n");	
	} else {
		$resultsDeleted = pg_affected_rows($result);
		fwrite($log, "Deleted $resultsDeleted from blast_results\n");
	}
	
	$result = pg_prepare($conn, '', $deleteHspsQuery);
	$result = pg_execute($conn, '', $rawIds);
	if(!$result) {
		fwrite($log, "Failed to delete records from blast_hsps\n");	
	} else {
		$hspsDeleted = pg_affected_rows($result);
		fwrite($log, "Deleted $hspsDeleted from blast_hsps\n");
	}
	$result = pg_prepare($conn, '', $deleteXgridParamsQuery);
	$result = pg_execute($conn, '', $rawIds);
	if(!$result) {
		fwrite($log, "Failed to delete records from xgrid_job_params\n");	
	} else {
		$xgridDeleted = pg_affected_rows($result);
		fwrite($log, "Deleted $xgridDeleted records from xgrid_job_params\n");
	}
}

fwrite($log, "Deleted a total of " . ($hitsDeleted+$resultsDeleted+$hspsDeleted+$xgridDeleted) . " records.\n");
fclose($log);

