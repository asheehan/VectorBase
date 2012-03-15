<?
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');

//look up the results in the db
$result=pg_query(DB::getJOB_DB(), "select * from job_params where job_id=".$_GET['job_id']);
while ($row = pg_fetch_assoc($result)) {
	if($row['argument']=='target_database') $dbs[]=$row['value'];
	else $params[$row['argument']]=$row['value'];
}

//make some of the params look nice
preg_match_all("#>(.*)?\n([ARNDCEQGHILKMFPSTWYV|\n]+)+[\n]?#",$params['sequence'],$matches);
//$matches[1] fasta headers
//$matches[2] nucleotides/peptides
for($i=0; $i<count($matches[1]); $i++){
$sequence.=">".$matches[1][$i]."<br/>".chunk_split(preg_replace("#\s#","<br/>",$matches[2][$i]),70,"<br/>");
}

if(substr_count($params['sequence'],">")>1) $s='s'; else $s='';

if($params['masking']=="F") $params['masking']="Off";
else $params['masking']="Low";
