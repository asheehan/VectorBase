<?php
// this file is posted some hsp ids and it will retrieve the fasta sequences for the corrosponding hits

//header("Content-type: text/plain");
header("Content-type:appliation/octet-stream");
header("Content-Disposition: attachment; filename=\"vbBLASTsequences_".$_POST['jobid']."\"");

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// get hsp ids from the input variables
$hspIds=array();
foreach($_POST as $key => $value){
	if(strstr($key, 'hsp'))
		$hspIds[]=$value;
}


// look up hit names for all the hsp ids
$bhIds=array();
foreach($hspIds as $id){
	$bhIds[]=db_query("select bh_id from blast_hsps where bs_id=$id")->fetchField();
}
foreach($bhIds as $id){
	$names[]=db_query("select name from blast_hits where bh_id=$id")->fetchField();
}
$names=array_unique($names);


// get sequences with these hit names
$conn = pg_connect("host=localhost port=5432 dbname=blast_sequences user=db_public password=limecat");
$out='';

foreach($names as $name){
	$sql="SELECT sequence, description FROM raw_sequences where primary_id='$name';";
	$result = pg_query($conn, $sql);
	while ($row = pg_fetch_assoc($result)) {
		$out.=">$name ".$row['description']."\n".$row['sequence']."\n";
	}
}

// display results
echo $out;
