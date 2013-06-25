<?php

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


blast_hspDetails($_POST['id']);
//blast_hspDetails($_GET['id']);
//http://steak.vectorbase.org/sites/all/modules/blast/hspDetails.php?id=647


// display a pretty table of hsp details
function blast_hspDetails($id){
	$hsps=db_query("select * from blast_hsps where bs_id=$id;");
	foreach($hsps as $hsp){
		$bhid=$hsp->bh_id;
		$hitString=$hsp->hit_string;
		$homoString=$hsp->homology_string;
		$queryString=$hsp->query_string;
		$evalue=$hsp->evalue;
		$score=$hsp->score;
		$identity=$hsp->percent_identity;
		$strandHit=$hsp->strandhit;
		$strandQuery=$hsp->strandquery;
		$startHit=$hsp->starthit;
		$startQuery=$hsp->startquery;
		$endQuery=$hsp->endquery;
		$endHit=$hsp->endhit;
		$frameHit=$hsp->framehit;
		$frameQuery=$hsp->framequery;
		$search_id=$hsp->search_id;
	}

	// get some hit info
	$hitName=db_query("select name from blast_hits where bh_id=$bhid;")->fetchField();
	$hitDescription=db_query("select description from blast_hits where bh_id=$bhid;")->fetchField();
	$hitLength=db_query("select length from blast_hits where bh_id=$bhid;")->fetchField();
	$brid=db_query("select br_id from blast_hits where bh_id=$bhid;")->fetchField();

	// get result info
	$dbName=db_query("select database_name from blast_results where br_id=$brid;")->fetchField();
	$queryName=db_query("select query_name from blast_results where br_id=$brid;")->fetchField();
	$queryDescription=db_query("select query_description from blast_results where br_id=$brid;")->fetchField();
	$program=db_query("select algorithm from blast_results where br_id=$brid;")->fetchField();

	// look up what type of db this is in the files
	$fid=db_query("select fid from file_managed where filename='$dbName.gz';")->fetchField();
	$entity_id=db_query("select entity_id from field_data_field_file where field_file_fid=$fid;")->fetchField();
	$tid=db_query("select field_download_file_type_tid from field_data_field_download_file_type where entity_id=$entity_id;")->fetchField();
	$type=db_query("select name from taxonomy_term_data where tid=$tid;")->fetchField();

	// also get ensembl org name for this file
	//$orgId=db_query("select field_organism_target_id from field_data_field_organism where entity_id=$entity_id;")->fetchField();
	$tid=db_query("select field_organism_taxonomy_tid from field_data_field_organism_taxonomy where entity_id=$entity_id;")->fetchField();
	//$orgTid=db_query("select field_organism_taxonomy_tid from field_data_field_organism_taxonomy where entity_id=$orgId;")->fetchField();
	$orgName=str_replace(" ","_",db_query("select name from taxonomy_term_data where tid=$tid;")->fetchField());
	// dirty hack to remove stupid s.s from a. gambiae name
	$orgName=str_replace("_s.s.", "", $orgName);

	//dirty hacks for M and S
	if(stristr($dbName,"Pimperena"))
		$orgName="Anopheles_gambiaeS";
	if(stristr($dbName,"Mali"))
		$orgName="Anopheles_gambiaeM";


	// change some of the hit names so the gffs show up in ensembl properly
	// these should all be tagged with "Reversed Headers"
    // get the tid for "Reversed Headers"
    $rhTid=db_query("select tid from taxonomy_term_data where name='Reversed Headers'")->fetchField();
	// get the nid(entity_id) for this db name
	$fid=db_query("select fid from file_managed where filename='".$dbName.".gz';")->fetchField();
	$entity_id=db_query("select entity_id from field_data_field_file where field_file_fid=$fid;")->fetchField();
	// is this db tagged with reverse headers?
	$isTagged=db_query("select nid from taxonomy_index where tid=$rhTid and nid=$entity_id;")->fetchField();
	if($isTagged){
        preg_match("#^.*?:.*?:(.*?):#",$hitName,$match);
	    $hitDescription=$hitName.$dbName;
		$hitName=$match[1];
	}







	// generate browser links
	$image="<img src=\"/sites/default/files/ftp/images/browse_genome.png\">";
	if($type=='Transcripts'){
		$link="<a href=\"/$orgName/Transcript/Summary?db=core;t=$hitName\" target=\"new\" class=\"hspBrowserLink\">$image</a> <br/>";

	}else if ($type=='Peptides'){
		$link="<a href=\"/$orgName/Transcript/ProteinSummary?db=core;t=$hitName\" target=\"new\" class=\"hspBrowserLink\">$image</a> <br/>";

	}else if ($type =='Chromosomes' || $type =='Scaffolds'){
		// attach the gff to these
		$gffName=($search_id+1)."_$brid.gff";
		$margin=30;
		if($startHit<$endHit){
			$start=$startHit-$margin;
			$end=$endHit+$margin;
		}else{
			$start=$startHit+$margin;
			$end=$endHit-$margin;
		}
		$link="<a href=\"/$orgName/Location/View?r=$hitName:$start-$end;contigviewbottom=url:http://".$_SERVER['SERVER_NAME']."/data/$gffName=unbound\" target=\"new\" class=\"hspBrowserLink\">$image</a> <br/>";

	// bob's rna transcriptomes
	}else if($type=="Assembled transcriptome"){
		$link='<a href="/search/site/'.$hitName.'" target="new" style="float:right;text-decoration:underline;">Sequence Report</a>';
	}



	// fix display text of +/- strands
	if($strandQuery==1){
		$strandQueryText="Plus";
		$queryInt=$startQuery;
	}else{
		$strandQueryText="Minus";
		$queryInt=$endQuery;
	}
	if($strandHit==1){
		$strandHitText="Plus";
		$hitInt=$startHit;
	}else{
		$strandHitText="Minus";
		$hitInt=$endHit;
	}

	// generate fixed length view of hit/homo/query strings
	$length=60;
	$queryStringArray=str_split($queryString,$length);
	$homoStringArray=str_split($homoString,$length);
	$hitStringArray=str_split($hitString,$length);


	// we'll need a sequence indicie multiplier for peptide results
	if($program=="BLASTN" || $program=="BLASTP" || $program=="TBLASTN")
		$queryPep=1;
	else
		$queryPep=3;

	if($program=="BLASTN" || $program=="BLASTP" || $program=="BLASTX")
		$hitPep=1;
	else
		$hitPep=3;


	// some special settings for blastp
	if($program=="BLASTP"){
		$strandQuery=1;
		$strandHit=1;
		$hitInt=$startHit;
		$queryInt=$startQuery;
	}


	$strings="<table id=\"hspTable\"><tbody>";
	for($i=0; $i<count($hitStringArray); $i++){

		$hitGaps=substr_count($hitStringArray[$i],"-");
		$queryGaps=substr_count($queryStringArray[$i],"-");

		$strings.="<tr>
		<td>Query</td>
		<td>$queryInt</td>
		<td>".$queryStringArray[$i]."</td>";
		if($strandQuery==1)
			$queryInt=$queryInt+(strlen($queryStringArray[$i])-$queryGaps)*$queryPep-1;
		else
			$queryInt=$queryInt-(strlen($queryStringArray[$i])+$queryGaps)*$queryPep+1;

$strings.="		<td>$queryInt</td>
		</tr>
		<tr>
		<td></td>
		<td></td>
		<td>".	//account for multiple space in homo string
		str_replace(" ","&nbsp;",$homoStringArray[$i])."</td>
		<td></td>
		</tr>

<tr>
		<td>Sbjct</td>
		<td>$hitInt</td>
		<td>".$hitStringArray[$i]."</td>";
		if($strandHit==1)
			$hitInt=$hitInt+(strlen($hitStringArray[$i])-$hitGaps)*$hitPep-1;
		else
			$hitInt=$hitInt-(strlen($hitStringArray[$i])+$hitGaps)*$hitPep+1;


$strings.="		<td>$hitInt</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>";

		if($strandQuery==1)
			$queryInt=$queryInt+1;
		else
			$queryInt=$queryInt-1;

		if($strandHit==1)
			$hitInt=$hitInt+1;
		else
			$hitInt=$hitInt-1;

	}
	$strings.="</tbody></table>";


	$queryFrame=$strandQuery*($frameQuery+1);
	if($queryFrame>1)
		$queryFrame="+".$queryFrame;
	$hitFrame=$strandHit*($frameHit+1);
	if($hitFrame>1)
		$hitFrame="+".$hitFrame;



	$out="<div id=\"hspContent\">

	$link
	Query: $queryName $queryDescription</br>
	> $hitName</br>";
	if ($hitDescription) {
		$out.="$hitDescription</br>";
	}



$out.="	Length = $hitLength</br></br>
Score = $score <br/>
Expect = $evalue <br/>
Identity = $identity% <br/>
Strand = $strandQueryText/$strandHitText <br/><br/>

Frame: $queryFrame / $hitFrame <br/>

<br/>

$strings
</div>";

	echo $out;
}



