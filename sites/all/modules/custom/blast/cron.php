<?php

/* SUPER IMPORTANT SCRIPT!!!!!
this guy should be run nightly.
it checks files that have xgrid_enabled selected and compares them to the files on xgrid.
it will load missing dbs on to all xgrid clients listed in the drupal config form
*/


// Pull a bunch of settings out of the drupal db. db host should be this local machine as the rest of the network sees it
$dbhost="192.168.1.70"; // adama (pre)
$webRoot="/vectorbase/web/root/";
$outputFile = "/vectorbase/web/logs/xgridCron.log";

$conn = pg_connect("host=$dbhost port=5432 dbname=vb_drupal user=db_public password=limecat");
$sql="SELECT value FROM variable WHERE name LIKE 'xgrid_client%';";
$result=pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
	preg_match("#\"(.*?)\"#",$row['value'],$match);
	if($match[1]!="")
		$xgridClients[]=$match[1];
}
echo "xgrid client machines:\n";
print_r($xgridClients);

$sql="SELECT value FROM variable WHERE name='xgrid_sshUser';";
$result=pg_fetch_assoc(pg_query($conn, $sql));
$result=pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
        preg_match("#\"(.*?)\"#",$row['value'],$match);
        $sshUser=$match[1];
}

$sql="SELECT value FROM variable WHERE name='xgrid_sshIdent';";
$result=pg_fetch_assoc(pg_query($conn, $sql));
$result=pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
        preg_match("#\"(.*?)\"#",$row['value'],$match);
        $sshIdent=$match[1];
}

$sql="SELECT value FROM variable WHERE name='xgrid_localDirectory';";
$result=pg_fetch_assoc(pg_query($conn, $sql));
$result=pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
        preg_match("#\"(.*?)\"#",$row['value'],$match);
        $clientDir=$match[1];
}

$sql="select value from variable where name='file_public_path';";
$result = pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
	preg_match("#\"(.*?)\"#",$row['value'],$match);
	$publicPath=$webRoot.$match[1];
}

// find db files with sequence info in blast_sequences db
// get list of dbs loaded on a client's fs
echo "Compiling a list of fasta files (blast dbs) that are loaded on one of our xgrid clients ({$xgridClients[0]}:$clientDir), which implies they are on all the xgrid machines."; 
$fsList=shell_exec("ssh -i $sshIdent $sshUser@".$xgridClients[0]." \"cd $clientDir; ls *.fa\"");
echo "done!\n";
//print_r($fsList);
//echo "\n";
$loadedDbs=array();
$conn = pg_connect("host=localhost port=5432 dbname=blast_sequences user=db_public password=limecat");
$sql="SELECT filename FROM raw_sequences group by filename;";
echo "Compiling a list of filenames (blast dbs) from the drupal blast_sequence database. This tells us what files (blast dbs) are currently loaded in blast on drupal. This might take a while (searching a million+ records)...";
$result = pg_query($conn, $sql);
echo "done!\n";
$count = 0;
while ($row = pg_fetch_assoc($result)) {
	// check that this file is actually on an xgrid client's fs!
	if (strstr($fsList,$row['filename']) !== false) {
		$loadedDbs[]=$row['filename'];
	}
/* else {
		echo $row['filename']." is in database but not on xgrid file system!!!!!\n";
		$count++;
	}*/
}
//echo "There are $count files loaded in blast on drupal that are not on the xgrid system\n";

// find dbs marked with xgrid_enabled
$conn = pg_connect("host=localhost port=5432 dbname=vb_drupal user=db_public password=limecat");
echo "Finding what files in drupal are supposed to be 'databases' in blast...";
$sql= "select entity_id from field_data_field_xgrid_enabled where field_xgrid_enabled_value=1;";
$result = pg_query($conn, $sql);
while ($row = pg_fetch_assoc($result)) {
	$entity_ids[]=$row['entity_id'];
}
foreach($entity_ids as $entity_id){
	$sql= "select field_file_fid from field_data_field_file where entity_id=$entity_id;";
	$result = pg_query($conn, $sql);
	while ($row = pg_fetch_assoc($result)) {
		$fids[]=$row['field_file_fid'];
	}
}
foreach($fids as $fid){
	$sql= "select filename,uri from file_managed where fid=$fid;";
	$result = pg_query($conn, $sql);
	while ($row = pg_fetch_assoc($result)) {
		$fileName=substr($row['filename'],0,-3);
		$selectedDbs[]=$fileName;
		$fileInfo[$fileName]=substr($row['uri'],8);
	}
}
echo "done!\n";

date_default_timezone_set('America/New_York');
echo date("Y-m-d H:i:s")."\n";
/*
echo "Loaded:\n";
var_dump($loadedDbs);
echo "Selected:\n";
var_dump($selectedDbs);
*/
$fsString = $fsList;
$fsList = array_filter(explode(',', preg_replace('/[\s\n]/', ',', $fsString)), 'strlen');

// loadedDbs = files in blast_sequences
// selectedDbs = files labeled 'xgrid_enabled' in drupal (download files)
// dbsMissing = files in blast_sequences that are not on xgrid

$dbsMissing = array_diff($loadedDbs, $fsList);
echo "===== Dbs that are labeled as blastable but are not in xgrid =====\n";
if($dbsMissing > 0) {
	echo implode("\n", $dbsMissing);
}
echo "\n";

$dbsToImport= array_diff($selectedDbs,$loadedDbs);
$dbImportCount = count($dbsToImport);
echo "===== DBs (files) to copy to xgrid and load into drupal ($dbImportCount in total) =====\n";
if ($dbImportCount > 0) {
	echo implode("\n", $dbsToImport);
}
echo "\n";

$dbsToRemove=array_diff($loadedDbs,$selectedDbs);
$dbRemoveCount = count($dbsToRemove);
echo "===== DBs (files) to remove because they are not labeled as xgrid enabled in drupal ($dbRemoveCount in total) =====\n";
if ($dbRemoveCount > 0) {
	echo implode("\n", $dbsToRemove);
}
//echo "\nThis is a dry run. Exiting!\n";
//exit();
/*
foreach($xgridClients as $client){
	echo "executing: gunzip -c $publicPath$fileInfo[$db] > $db\n";
	echo "executing: scp -i $sshIdent $db $sshUser@$client:$clientDir\n";
}
// bug out here before we make any actual changes
exit();
*/


$output = array();
$dbImportCurrent = 1;
foreach($dbsToImport as $db){
	// if file name does not have peptide in it, use -p F flag
	if(!stristr($db,"peptide"))
		$type="-dbtype nucl";
	else
		$type="-dbtype prot";

	// uncompress file
	echo "uncompressing $db...\n";
	exec("gunzip -c $publicPath/".$fileInfo[$db]." > $db", $output);

	foreach($xgridClients as $client){
		// send file to client
		echo "scp $db ($dbImportCurrent of $dbImportCount) to $client...\n";
		exec("scp -i $sshIdent $db $sshUser@$client:$clientDir", $output);

		// format db on client
		echo "formatting ($dbImportCurrent of $dbImportCount) $db on $client...\n";
		exec("ssh -i $sshIdent $sshUser@$client \"cd $clientDir; /usr/local/ncbi/blast/bin/makeblastdb $type -in $db\"", $output);

	}

	// clean up uncompressed file
	exec("rm $db", $output);

	// import sequences into db
	// clear current db entries incase this is a new version of the file
	echo "importing $db sequences in db...\n";
	exec("psql -U postgres -c \"delete from raw_sequences where filename='$db'\" blast_sequences", $output);
	exec("ssh -i $sshIdent $sshUser@gene \"/vectorbase/scripts/fastaDBimport.pl $dbhost $clientDir $db\"", $output);

	$dbImportCurrent++;

}

echo "Skipping the old database removal step until we verify by hand everything that is expired.\n";
echo "Blast updates are done.\n";
/*foreach($dbsToRemove as $db){
        //foreach($xgridClients as $client){
        //        echo "removing $db on $client...";
        //        exec("ssh -i $sshIdent $sshUser@$client \"cd $clientDir; rm {$db}*\"");
//		echo "done.\n";
//        }
	echo "Skipping database file client removal step to prevent live from breaking completely.\n";
        echo "removing $db from database...";
        exec("psql -U postgres -c \"delete from raw_sequences where filename='$db'\" blast_sequences", $output);
        echo "done.\n\n";
}*/

// logging output
//file_put_contents($outputFile, $output);

