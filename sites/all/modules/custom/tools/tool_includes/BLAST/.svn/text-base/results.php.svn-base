<?php
include_once("/Volumes/Web/vectorbase/includes/Jobs.php");
include_once("blast_results.php");
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');
include_once('/Volumes/Web/vectorbase/includes/organism_definitions.php');
//include_once('/Volumes/Web/vectorbase/includes/index_style.css');

//job results can be big...
ini_set("memory_limit","1024M");
ini_set("max_execution_time", 600);

// turn of warnings this check might produce
error_reporting(E_ERROR | E_PARSE);

function vbPack($goodies){
  //print "<br ><pre>".serialize($goodies)."</pre><br>";
  //$ser = serialize($goodies);
  //print_r(unserialize($ser));
  return serialize($goodies);
}

function vbUnpack($goodies){
  return unserialize($goodies);
}


//proceed if there are results/db entries for this job
if($_GET['job_id']!=null){

	$results = array();
	$resQuery = "select raw_results from blast_results where blast_id = " . $_GET['job_id'];
	$resRes = pg_query(DB::getJOB_DB(), $resQuery);
	$resRow = pg_fetch_assoc($resRes);

	//Our results are parsed and in the database - let's just pull them out
	if($resRow['raw_results']){
		$hashQuery = "select result_id,hash from blast_hashes where blast_id = " . $_GET['job_id'];
		$hashRes = pg_query(DB::getJOB_DB(), $hashQuery);
		$i = 0;
		while ($hashRow = pg_fetch_assoc($hashRes)){
			//Strip slashes because we put it in using pg_prepare
			$results[$i++] = unserialize(pg_unescape_bytea(stripslashes($hashRow['hash'])));
		}

	}else{ // First time getting results - parse and place into database
		$res = Jobs::getResults($_GET["job_id"], "BLAST");

		$insertQuery = "insert into blast_results (blast_id,raw_results,parsed_results) values (".$_GET['job_id'].",'".addslashes($res->results())."','".addslashes($res->parsedResults())."')";
		pg_query(DB::getJOB_DB(), $insertQuery);

		$tempResult = new VectorbaseBlastResult();
		$tempHit = new VectorbaseBlastHit();
		$tempHsp = new VectorbaseBlastHsp();

		$contents = explode("\n", $res->parsedResults());
		// 0 = nothing. 1 = result.  2 = hit.  3 = hsp.
		$on = 0;
		$hspId = 1;
		$hitId = 1;
		$resId = 1;
		$gffNum = 0;

		$i=0;

		foreach($contents as $input) {
			$i++;
			$input = chop($input);
			// If input is a new result/hit/hsp we declare the arrays
			if (substr($input, 0, 2) == '++') {
				$on++;
				if($on == 1) $tempResult = new VectorbaseBlastResult();
				if($on == 2) $tempHit = new VectorbaseBlastHit();
				if($on == 3) $tempHsp = new VectorbaseBlastHsp();
			}
			// If input  is end of a result/hit/hsp
			//  we iterate to get the next one, and
			// reset the last data structure
			elseif (substr($input, 0, 2) == '--') {
				if($on == 1){
					//Add result to database
					$tempResult->clearEmptyHits();
					$addResultQuery = "insert into blast_hashes (blast_id,result_id,hash) values ($1, $2, $3)";
					pg_prepare(DB::getJOB_DB(), "my_query$i", $addResultQuery);//DB::getJOB_DB(), $addResultQuery);
					if(!pg_execute(DB::getJOB_DB(), "my_query$i", array($_GET['job_id'], $resId, pg_escape_bytea(vbPack($tempResult) ) ) ) ){
						//pg_prepare(DB::getJOB_DB(), "my_query", $addResultQuery);//DB::getJOB_DB(), $addResultQuery);
//this is doing stuff..why>			//print "die";
					}
					$results[$resId-1] = $tempResult;
					$resId++;
				}
				if($on == 2){
					$tempHit->setId($hitId++);
					$tempResult->addHit($tempHit);
				}
				if($on == 3){
					$tempHsp->setId($hspId++);
					$tempHsp->setParent($tempHit);
					$tempHit->addHsp($tempHsp);
				}
				$on--;
			}
			elseif( substr($input, 0, 8) == '*&*&*gff' ){// && (!file_exists($viewPath.'view'.$_GET['job_id'].'.gff')) )
				$onGFF = 1;
				$gffNum = substr($input, 8);

				$tmpGFF = "/Volumes/Web/vectorbase/data/job_output/BLAST/" . $_GET['job_id'] . "_" . $gffNum . ".gff";
				$gfh = fopen($tmpGFF, "w");

				if (!$gfh) {print "Error!1"; exit; }
			} 
			elseif(substr($input, 0, 9) == '*&*&*/gff' ) {
				$onGFF = 0;
				fclose($gfh);
			}
			// We're looking at a gff
			elseif($on == 0 && $onGFF){
				if(substr($input, 0, 5) == "track") $input .= $_GET['job_id'];

				if (!fwrite($gfh, $input . "\n")) { print "ha".$input . "Error!2" . $on; exit; }
				//Write the line to the file!
				//$input
			}else {
				$matches = explode('=>', $input, 2);
				if($on == 1){
					if($matches[0] == "res_database_name") $tempResult->setDb($matches[1]);
					if($matches[0] == "res_query_name") $tempResult->setQueryString($matches[1]);
				}
				if($on == 2) {
					if($matches[0] == "hit_name") $tempHit->setName($matches[1]);
				}
				if($on == 3){
					switch($matches[0]) {
					      case "hsp_evalue":
						$tempHsp->setEvalue( $matches[1] );
						break;
					      case "hsp_length(hit)":
						$tempHsp->setLength( $matches[1] );
						break;
					      case "hsp_score":
						$tempHsp->setScore( $matches[1] );
						break;
					      case "hsp_percent_identity":
						$tempHsp->setIdentity( $matches[1] );
						break;
					      case "hsp_start(hit)":
						$tempHsp->setHitStart( $matches[1] );
						break;
					      case "hsp_end(hit)":
						$tempHsp->setHitEnd( $matches[1] );
						break;
					      case "hsp_start(query)":
						$tempHsp->setQueryStart( $matches[1] );
						break;
					      case "hsp_end(query)":
						$tempHsp->setQueryEnd( $matches[1] );
						break;
					      case "hsp_homology_string":
						$tempHsp->setHomologyString( $matches[1] );
						break;
					      case "hsp_hit_string":
						$tempHsp->setHitString( $matches[1] );
						break;
					      case "hsp_strand(hit)":
						$tempHsp->setHitStrand( $matches[1] );
						break;
					      case "hsp_strand(query)":
						$tempHsp->setQueryStrand( $matches[1] );
						break;
					      case "hsp_frame(hit)":
						$tempHsp->setHitFrame( $matches[1] );
						break;
					      case "hsp_frame(query)":
						$tempHsp->setQueryFrame( $matches[1] );
						break;
					      case "hsp_query_string";
						$tempHsp->setQueryString( $matches[1] );
						break;
					}
				}
			}
		} //end foreach
	} //End getting results

// first get organism name, query seauence, and db for each result
//var_dump($results);

for ($i=0; $i<sizeof($results); $i++){
	//preg_match("/((\/.*)*\/)*(.+)/", $results[$i]->getDb(), $db);
	$db=$results[$i]->getDb();
	$blastQ = "select o.short_name,b.display_id, b.sequence_type from blast_databases b, organism o where o.organism_id=b.organism_id and b.file_name = '" . $db . "'";

	//if there are no sql results, it's because db is an est db
	if( !pg_fetch_assoc(pg_query(DB::getUI_DB(), $blastQ)) ){

		$blastQ = "select species, short_name from blast_est where filename = '" . $db . "'";
		$bqResults[] = pg_fetch_assoc(pg_query(DB::getUI_DB(), $blastQ));
		$organismsSearched[] = ORG::$LTS[$bqResults[$i]["species"]];
		$dbDisplayIds[] = $bqResults[$i]["short_name"];
		$querySequences[] = $results[$i]->getQueryString();
		$dbsSearched[] = $db;
	//normal blast db found
	}else{
		$bqResults[] = pg_fetch_assoc(pg_query(DB::getUI_DB(), $blastQ));
		$organismsSearched[] = $bqResults[$i]["short_name"];
		$dbDisplayIds[] = $bqResults[$i]["display_id"];
		//$dbSequenceTypes[] = $bqResults[$i]["sequence_type"];
		$querySequences[] = $results[$i]->getQueryString();
		$dbsSearched[] = $db;
	}

}


if(!array_unique($organismsSearched)){
//something bad happened if we managed to get here... the job status says done but there are no results!
	echo '<div class="jobBox" style="float:left; clear:both; margin-left:8px; width:98%;"><h1>Job '.$_GET["job_id"].' Results</h1>';
	echo '<p>Could not retrieve results! Possible cause: Results too large or improper output generated. <a href="/sections/Tools/tool_includes/BLAST/raw_results.php?job_id='.$_GET["job_id"].'">Job raw output</a></p></div>';
	echo '<!-- error -->';
	exit();
}

$uniqueOrganisms = array_unique($organismsSearched);
$uniqueQueries = array_unique($querySequences);
$hitlessOrganisms[]=NULL;
foreach($uniqueOrganisms as $organism){
	$emptyResult=true;
	foreach($uniqueQueries as $query){
		for ($i=0; $i<sizeof($organismsSearched); $i++){
			if($organism==$organismsSearched[$i] && $query==$querySequences[$i]){
				if($results[$i]->getNumHsps()!=0){
					$evalueSortedResults=$results[$i]->getSortedHsps('evalue','asc');
					$blastHits[$organism][$query][]= new blastResult($dbDisplayIds[$i],$query,$results[$i]->getNumHsps(),$evalueSortedResults[0]->getEvalue(), $i);
					$emptyResult=false;
				}
			}
		}
	}
	//find organisms with zero hits for all dbs
	if($emptyResult) $hitlessOrganisms[]=$organism;
}

//display results
echo '<div class="jobBox" style="float:left; clear:both; margin-left:8px; width:98%;"><h3>Job '.$_GET["job_id"].' Results</h3></div>';

//this is for the separate results page
if($separate) include_once('displayInputParams.php');

//sort by organism
foreach($uniqueOrganisms as $organism){
	if(!array_search($organism,$hitlessOrganisms) && $organism!=NULL){
		$organismTitle=(ORG::$FN[$organism])?ORG::$FN[$organism]:'mRNAseq Data';
		echo '<div class="jobBox" style="border: 1px solid #'.DV::$BLASTOCS[$organism][4].'; margin: 2px 0px; margin-left:8px; float:left; clear:both; width:98%;">';
		echo '<h1 style="font-style: italic; font-size:12px; color:#'.DV::$BLASTOCS[$organism][0].'; border-width: 0px; border-bottom-width: 1px; border-color:#'.DV::$BLASTOCS[$organism][4].'; background:#'.DV::$BLASTOCS[$organism][4].'; background-color:#'.DV::$BLASTOCS[$organism][5].';">'.$organismTitle.'</h1>';

		if($blastHits[$organism]){	//somehow null enteries are getting into this array. make sure it has something here
		foreach($blastHits[$organism] as $query){
			$rowCount=0;
			echo '<table style="margin-left:10px; border-spacing: 0px 3px; width:98%;color: #'.DV::$BLASTOCS[$organism][0].'; font-family: arial; font-size:12px;">';
			echo '<tr>
	<td style="width:33em; font-size:1.1em; font-weight:bold;color: #'.DV::$BLASTOCS[$organism][0].';">'.$query[0]->getQueryName().'</td>
	<td style="font-weight:bold; text-align:center;color:#'.DV::$BLASTOCS[$organism][0].';">Hits</td>
	<td style="font-weight:bold; text-align:center;color:#'.DV::$BLASTOCS[$organism][0].';">Best E-Value</td>
	<td style="font-weight:bold; text-align:center;color:#'.DV::$BLASTOCS[$organism][0].';">Raw Results</td></tr>';

			foreach($query as $blastresult){
				if($rowCount%2==1) $color="ffffff";
				else $color=DV::$BLASTOCS[$organism][6];

				$i=$blastresult->getResultNumber();
				echo '<tr>';
				echo '<td style="background-color: #'.$color.';"><a target="new" href="/Tools/BLAST/?result=html_results&job_id='.$_GET['job_id'].'&resNum='.($i+1).'&page=res" class="hashelp" name="Web:Misc_Help#view_interactive_results">'.strip_tags($blastresult->getDbName()).'</td>';
				echo '<td style="text-align:center; color:#'.DV::$BLASTOCS[$organism][0].'; background-color: #'.$color.';">'.$blastresult->getNumberOfHits().'</td>';
				echo '<td style="text-align:center; color:#'.DV::$BLASTOCS[$organism][0].'; background-color: #'.$color.';">'.$blastresult->getBestEvalue().'</td>';
				echo '<td style="text-align:center; color:#'.DV::$BLASTOCS[$organism][0].'; width:8em; background-color: #'.$color.';"><a class="hashelp" target="new" name="Web:Misc_Help#view_raw_blast_results" href="/sections/Tools/tool_includes/BLAST/raw_results.php?job_id='.$_GET["job_id"].'&result='.($i+1).'"><img src="/imgs/trans_doc.gif" height="16" width="14"/></a></td>';
				echo '</tr>';
				$rowCount++;
			}

			echo '</table>';
		}
		}
		echo '</div>';
	}
}

//display organisms with no hits
if($hitlessOrganisms[1]!=NULL){
	echo '<div class="jobBox" style="float:left; clear:none; width:98%; border: 1px solid #'.DV::$BLASTOCS['all'][4].'; margin: 2px; margin-left:8px;">
		<h1>No Results for these organisms</h1>
		<ul>';
	foreach($hitlessOrganisms as $organism){
		echo '<li><i>'.ORG::$FN[$organism].'</i></li>';
	}
	echo '</ul></div>';
}

}else echo '<span class="errorText">No job ID was entered. How did you get to this point?</span>';
