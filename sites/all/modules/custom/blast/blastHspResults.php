<?php

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


blast_listHspByHit($_POST['id'],$_POST['db']);

// display a pretty table of hsp info on blast job; should be fed raw blast job id and database filename
//function blast_resultsHspByHit($id, $dbFile){
function blast_listHspByHit($id, $dbFile){

	$results=db_query("select br_id,query_name,query_description,query_length,algorithm from blast_results where search_id=$id and database_name='$dbFile'");
	$details='';
	// find how many queries were hit
	// if only one: display that information above table
	// else: have a query column in the table
	$i=0;
	$queryUnique=true;
	foreach($results as $result){
		$queryName=$result->query_name;
		$queryDes=$result->query_description;
		$query=$queryName.' '.$queryDes;

		if($i==0)
			$queryOne=$query;
		else{
			if($query!=$queryOne)
				$queryUnique=false;
		}
		$i++;
	}

	$results=db_query("select br_id,query_name,query_description,query_length,algorithm from blast_results where search_id=$id and database_name='$dbFile'");
	// results for each query per db
	foreach($results as $result){
		$brid=$result->br_id;
		$queryName=$result->query_name;
		$queryDes=$result->query_description;
		$queryLength=$result->query_length;
		$program=$result->algorithm;


		//get all hit info for this result
		$hits=db_query("select * from blast_hits where br_id=$brid");
		foreach($hits as $hit){
			//get hit name to list all the hsps under
			$hitName=$hit->name;
			$hitDesc=$hit->description;
			$bhid=$hit->bh_id;
			$hitLength=$hit->length;

			// now find hsps for each hit
			$hsps=db_query("select * from blast_hsps where bh_id=$bhid;");
			foreach($hsps as $hsp){
				$hspId=$hsp->bs_id;
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

				//blastp will allways be positive direction and bioperl returns negative for both query and subject
				if($program!="BLASTP"){
					// hit in reverse direction, swap end/start values
					if($strandQuery<1){
						$temp=$startQuery;
						$startQuery=$endQuery;
						$endQuery=$temp;
					}
					if($strandHit<1){
						$temp=$startHit;
						$startHit=$endHit;
						$endHit=$temp;
					}
				}


				if($startQuery>$endQuery){
					$startDisplay=$endQuery;
					$endDisplay=$startQuery;
				}else{
					$startDisplay=$startQuery;
					$endDisplay=$endQuery;
				}

				if($startHit>$endHit){
					$startHitDisplay=$endHit;
					$endHitDisplay=$startHit;
				}else{
					$startHitDisplay=$startHit;
					$endHitDisplay=$endHit;
				}


				if (strlen($hitName)<13){
					$hitNameWidth=strlen($hitName).'em';
				}else
					$hitNameWidth="auto";

				if ( (strlen($queryName)+strlen($queryDes)) <13){
					$queryNameWidth=(strlen($queryName)+strlen($queryDes)).'em';
				}else
					$queryNameWidth="auto";


				$details.="<tr><td><input type=\"checkbox\" class=\"hsps\" name=\"selectedHsps\" value=\"$hspId\" /></td>
				<td class=\"hspHitName\" ><a class=\"hsp\" id=\"$hspId\" title=\"$hitName\">$hitName</a></td>\n";

				if(!$queryUnique)
				$details.="<td class=\"hspQueryName\" title=\"$queryName $queryDes\">$queryName $queryDes</td>\n";

				$details.="<td>$evalue</td>
				<td>$score</td>
				<td>".round($identity,1)."%</td>

				<td class=\"hidden rightAln\" >$startDisplay</td>
				".hspHitLocationGraphic($startQuery,$endQuery,$queryLength)."
				<td class=\"hidden leftAln\">$endDisplay</td>
				<td class=\"hidden rightAln\">$startHitDisplay</td>
				".hspHitLocationGraphic($startHit,$endHit,$hitLength)."
				<td class=\"hidden leftAln\">$endHitDisplay</td>
				</tr>";
			}
		}
	}





	$out="
	<div id=\"hspControl\">
	<fieldset class=\"form-wrapper\" style=\"padding:6px;margin:8px;4px;\"><legend>Checked Hits</legend>
	<button type=\"button\" id =\"downloadSequences\">Download</button> 
	<button type=\"button\" id=\"sendToClustal\">Pass to ClustalW</button>
	<button type=\"button\" id=\"quickAlign\">Quick align</button>
	<div id=\"downloadSequencesStatus\"></div>
	</fieldset>
	</div>";

	if($queryUnique)
		$out.="<div id=\"uniqueQuery\" title=\"$query\"><b>Query</b><br/><div id=\"uniqueQueryName\">$query</div></div>";

	$out.="
<div style=\"float:right; clear:both; padding:2px 0px;\"><a id=\"hspGraphicTextSwitch\">Show Query/Hit Numbers</a></div>
	<table id=\"blastHsps\" class=\"tablesorter\"style='table-layout:fixed; width:870px;'>
	<thead>
	<tr>
		<th style=\"width:16px; padding-left:3px;\"><input type=\"checkbox\" id=\"hspsMaster\" name=\"selectedHsps\" value=\"all\" /></th>
		<th class=\"hspHitName\">Hit</th>\n";

		if(!$queryUnique)
		$out.="<th class=\"hspQueryName\">Query</th>\n";

		$out.="<th style=\"width:7%;\">E-value</th>
		<th style=\"width:7%;\">Score</th>
		<th style=\"width:7%;\">Identity</th>

		<th id=\"queryStart\"	class=\"rightAln queryText\"'><</th>
		<th id=\"queryGraphic\"	class=\"queryText\" style=\"width:114px;\">Query Hit</th>
		<th id=\"queryEnd\"		class=\"leftAln queryText\">></th>
		<th id=\"hitStart\"		class=\"rightAln dbText\"><</th>
		<th id=\"hitGraphic\"	class=\"dbText\" style=\"width:114px;\">DB Sequence Hit</th>
		<th id=\"hitEnd\"		class=\"leftAln dbText\">></th>

	</tr>
	</thead>
	<tbody>
";

	$out=$out.$details;


	$out=preg_replace("#<th class=\"hspHitName\">Hit</th>#","<th class=\"hspHitName\" style=\"width:$hitNameWidth;\">Hit</th>",$out);
	$out=preg_replace("#<th class=\"hspQueryName\">Query</th>#","<th class=\"hspQueryName\" style=\"width:$queryNameWidth;\">Query</th>",$out);

	$out.="</tbody></table>";

//	$commands[]=ajax_command_html('#hspLevelResults',$id."hello");
//	return array('#type' => 'ajax', '#commands' => $commands);


	//$out=var_export($id).var_export($dbFile).var_export(&$dbFile).'eeee';
	echo $out;
//	return $out;


}



function hspHitLocationGraphic($start,$end,$length){
				//typical scenerion. forward facing arrow
				if($start<$end){
					$startPercent=round(($start-1)/$length,1)*100;	// take into account index starts a 1
					$stopPercent=round(($end)/$length,1)*100;
					$color="#95CF1A";
					$textColor="black";
					$text=">";

				// hit is in reverse direction
				}else{
					$startPercent=round(($end-1)/$length,1)*100;
					$stopPercent=round(($start)/$length,1)*100;
					$color="#4186B5";
					$textColor="white";
					$text="<";
					$reverse=true;
				}

				// require hit match box to be at least a certain size so the direction character shows up
				$widthPercent=$stopPercent-$startPercent;
				$minSize=7;
				if($widthPercent<$minSize){
					$widthPercent=$minSize;
				}

				// make sure the hit match box doesn't overflow past the end of it's box
				if($startPercent>100-$minSize){
					$startPercent=$startPercent-($minSize-(100-$startPercent));
				}


				$out="<td class=\"hspGraphic\" title=\"Start: $start   End: $end  Sequence Length: $length\">".'
					<div style="border: 1px solid #bbb; margin-right:4px;margin-left:4px; width:100px;">
<div class="hitGraph" style="left:'.$startPercent.'%; width:'.$widthPercent.'%; background-color:'.$color.'; color:'.$textColor.';">'.$text.'</div>
					</div></td>';
	return $out;
}

