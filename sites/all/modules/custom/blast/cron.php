<?php

/* SUPER IMPORTANT SCRIPT!!!!!
this guy should be run nightly.
it checks files that have xgrid_enabled selected and compares them to the files on xgrid.
it will load missing dbs on to all xgrid clients listed in the drupal config form
*/


// Pull a bunch of settings out of the drupal db. db host should be this local machine as the rest of the network sees it
$dbhost="192.168.1.80"; // adama (pre)
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
$fsList=shell_exec("ssh -i $sshIdent $sshUser@".$xgridClients[0]." \"cd $clientDir; ls *.fa\"");
$loadedDbs=array();
$conn = pg_connect("host=localhost port=5432 dbname=blast_sequences user=db_public password=limecat");
$sql="SELECT DISTINCT filename FROM raw_sequences;";
$result = pg_query($conn, $sql);
$count = 0;
while ($row = pg_fetch_assoc($result)) {

	// check that this file is actually on an xgrid client's fs!
	if (strstr($fsList,$row['filename']) === FALSE) {
		$loadedDbs[]=$row['filename'];
	} else {
		echo $row['filename']." is in database but not on xgrid file system!!!!!\n";
		$count ++;
	}
}
echo "$count files in DB and not on the xgrid system\n";





// find dbs marked with xgrid_enabled
$conn = pg_connect("host=localhost port=5432 dbname=vb_drupal user=db_public password=limecat");
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




date_default_timezone_set('America/New_York');
echo date("Y-m-d H:i:s")."\n";
/*
echo "Loaded:\n";
var_dump($loadedDbs);
echo "Selected:\n";
var_dump($selectedDbs);
*/

$dbsToImport=array_diff($selectedDbs,$loadedDbs);
$dbImportCount = count($dbsToImport);
if ($dbImportCount > 0) {
echo "\n===== DBs to load ($dbImportCount in total) =====\n";
foreach($dbsToImport as $db)
  echo "$db\n";
}


$dbsToRemove=array_diff($loadedDbs,$selectedDbs);
$dbRemoveCount = count($dbsToRemove);
if ($dbRemoveCount > 0) {
echo "\n===== DBs to remove ($dbRemoveCount in total) =====\n";
foreach($dbsToRemove as	$db)
  echo "$db\n";
}

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
	exec("gunzip -c $publicPath".$fileInfo[$db]." > $db", $output);

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



foreach($dbsToRemove as $db){
        /*foreach($xgridClients as $client){
                echo "removing $db on $client...";
                exec("ssh -i $sshIdent $sshUser@$client \"cd $clientDir; rm {$db}*\"");
		echo "done.\n";
        }*/
	echo "Skipping database file client removal step to prevent live from breaking completely.\n";
        echo "removing $db from database...";
        exec("psql -U postgres -c \"delete from raw_sequences where filename='$db'\" blast_sequences", $output);
        echo "done.\n\n";
}

// logging output
//file_put_contents($outputFile, $output);
