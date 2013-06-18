<?php
// this file is posted some hsp ids and it will retrieve the fasta sequences for the corrosponding hits

//header("Content-type: text/plain");
header("Content-type:appliation/octet-stream");
header("Content-Disposition: attachment; filename=\"vbBLASTsequences_".$_POST['jobid']."\"");
// **** load drupal enviornment ****
//define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
//require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
//drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
// get hsp ids from the input variables
$hspIds=array();
$placeHolders = '(';
$count = 0;
foreach($_POST as $key => $value) {
	if(strstr($key, 'hsp')) {
		$count++;
		$hspIds[]=$value;
		$placeHolders.="\$$count, ";
	}
}

// Exit if there were no ids provided.
if(empty($hspIds)) {
	echo 'No information could be found.';
	exit;
}

$placeHolders = substr($placeHolders, 0, -2);
$placeHolders.=')';

$conn = pg_connect("host=localhost dbname=vb_drupal user=db_public password=limecat");

$namesQuery = "SELECT hits.name FROM blast_hits hits, blast_hsps hsps WHERE hsps.bs_id in $placeHolders AND hsps.bh_id = hits.bh_id";
$namesResult = pg_prepare($conn, 'namesQuery', $namesQuery);
$namesResult = pg_execute($conn, 'namesQuery', $hspIds);

$names = array();

if($namesResult) {
	while($row = pg_fetch_assoc($namesResult)) {
		$names[] = $row['name'];
	}
}

pg_close($conn);

if(empty($names)) {
	echo "Could not find blast hit names.\n\tQuery: $namesQuery\n\tParameters: " . print_r($hspIds, true);
	exit;
}

$names = array_unique($names);

$conn = pg_connect("host=localhost port=5432 dbname=blast_sequences user=db_public password=limecat");

$placeHolders = '(';
for($i=1;$i<=count($names);$i++) {
	$placeHolders.="\$$i, ";
	if($i === count($names)) {
		$placeHolders = substr($placeHolders, 0, -2);
		$placeHolders.=')';
	}
}


$sequenceQuery = "SELECT primary_id, sequence, description FROM raw_sequences WHERE primary_id in $placeHolders";
$sequenceResult = pg_prepare($conn, 'sequenceQuery', $sequenceQuery);
$sequenceResult = pg_execute($conn, 'sequenceQuery', $names);

$out='';
if($sequenceResult) {
	while($row = pg_fetch_assoc($sequenceResult)) {
		$out.=">{$row['primary_id']} {$row['description']}\n{$row['sequence']}\n";
	}
} else {
	echo "Could not find blast sequences.\n\tQuery: $sequenceQuery\n\tParameters: " . print_r($names, true) . "\n";
	exit;
}

pg_close($conn);

// display results
echo $out;
