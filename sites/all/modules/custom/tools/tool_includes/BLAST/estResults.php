<?php
include_once("/Volumes/Web/vectorbase/includes/Jobs.php");
include_once("blast_results.php");
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');
include_once('/Volumes/Web/vectorbase/includes/organism_definitions.php');
//include_once('/Volumes/Web/vectorbase/includes/index_style.css');

//if no results are found a few warnings pop up for a few functions and loops, turn errors of here
//error_reporting(0);

//proceed if there are results/db entries for this job
if($_GET['job_id']){

	$results = array();
	$results_error = 0;
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
	// First time getting results - let's parse them and put into the database
	}else{
		try{ $res = Jobs::getResults($_GET["job_id"], "BLAST");
		}catch(JobException $e){
			$results_error=1;
			if ($e->getJobCode() == JobException::NO_RESULTS)
				print "<br/><div class=\"error\">No results for job ".$_GET["job_id"].". Please report this error to the webmaster.</div>";
			elseif ($e->getJobCode() == JobException::NO_JOB)
				print "<br/><div class=\"error\">No job with id ".$_GET["job_id"].".</div>";
			elseif ($e->getJobCode() == JobException::CLIENT) {
				print "<br/><div class=\"error\">Job with id ".$_GET['job_id']." is too large and returned too many results.  Please consider using a larger word size or a smaller E-Value.</div>";
			}else	print $e->getMessage();
		}

		// no error  
		if (!$results_error){

			//Parsing everything
			//Insert parsed results

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

			foreach ($contents as $input) {
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
						if(!pg_execute(DB::getJOB_DB(), "my_query$i", array($_GET['job_id'], $resId, pg_escape_bytea(serialize($tempResult) ) ) ) ){
							//pg_prepare(DB::getJOB_DB(), "my_query", $addResultQuery);//DB::getJOB_DB(), $addResultQuery);
echo pg_last_error(DB::getJOB_DB());
							print "die";
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
					//$tmpGFF = tempnam("/Volumes/Web2/vectorbase/data/job_output/BLAST/",'tmpGFF_');
					$tmpGFF = "/Volumes/Web/vectorbase/data/job_output/BLAST/" . $_GET['job_id'] . "_" . $gffNum . ".gff";
					$gfh = fopen($tmpGFF, "w");
					//$gfh = fopen( . $_GET['job_id'] . "_". $gffNum . ".gff", "w");
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
		} //end error check

/*
	//at this point all results have been stored in the db. lets store all the results that have at least one hit in a seperate table
	for ($i=0; $i<sizeof($results); $i++){
		if($results[$i]->getNumHsps()>0){
			$sql="INSERT INTO blast_jobs_relevant_results VAULES (DEFAULT,".$_GET['job_id'].", $i);";
			pg_execute(DB::getJOB_DB(),$sql); 
		}
	}
*/

	} //End getting results

// get db info for each search result
for ($i=0; $i<sizeof($results); $i++){

	//preg_match("/((\/.*)*\/)*(.+)/", $results[$i]->getDb(), $db);
	//$blastQ = "select o.short_name,b.display_id, b.sequence_type from blast_databases b, organism o where o.organism_id=b.organism_id and b.file_name = '" . $db[3] . "'";

	$blastQ = "select filename, species, short_name, dev_stage, conditions, body_part, sex, conditions from blast_est where filename='". $results[$i]->getDb()."'";
	$bqResults[] = pg_fetch_assoc(pg_query(DB::getUI_DB(), $blastQ));

	$species[] = 	ORG::$LTS[$bqResults[$i]["species"]]; //get short name for species
	$longNames[] = 	$bqResults[$i]["short_name"];
	$sexes[] =	$bqResults[$i]["sex"];
	$bodyParts[] =	$bqResults[$i]["body_part"];
	$devStages[] =	$bqResults[$i]["dev_stage"];
	$organismNames[] =$bqResults[$i]["species"];
	$conditions[] = $bqResults[$i]["conditions"];
	$filenames[] = $bqResults[$i]["filename"];

	$querySequences[] = $results[$i]->getQueryString();
	$dbsSearched[] = $db[3];
}
$organismsSearched = $species;
$uniqueOrganisms = array_unique($species);
$uniqueQueries = array_unique($querySequences);

$hitlessOrganisms[]='';
foreach($uniqueOrganisms as $organism){
	$emptyResult=true;
	foreach($uniqueQueries as $query){
		for ($i=0; $i<sizeof($organismsSearched); $i++){
			if($organism==$organismsSearched[$i] && $query==$querySequences[$i]){
				if($results[$i]->getNumHsps()!=0){
					$evalueSortedResults=$results[$i]->getSortedHsps('evalue','asc');
					$blastHits[$query][$organism][]= new blastResult($dbDisplayIds[$i],$query,$results[$i]->getNumHsps(),$evalueSortedResults[0]->getEvalue(), $i);
					$emptyResult=false;
				}
			}
		}
	}
	//find organisms with zero hits for all dbs
	if($emptyResult) $hitlessOrganisms[]=$organism;
}

/*
var_dump($organismsSearched);
echo "<br/><br/>";
var_dump($uniqueOrganisms);
echo "<br/><br/>";
var_dump($uniqueQueries);
echo "<br/><br/>";
var_dump($results);
echo "<br/><br/>";
*/

// explain the ? wiki links
echo '<div class="jobBox" style="border: 1px solid #'.DV::$BLASTOCS[$_SESSION["organism_id"]][4].'; margin:10px 10px 4px 0px; float:right; clear:both;padding:2px;font-size:10pt;">Click <img src="/imgs/question_16.png" align="top"> for information on the library</div>';

//display results
echo '<div class="jobBox" style="clear:both;">
	<h3>Job '.$_GET["job_id"].' Results</h3>';

//this is for the separate results page
if($separate) include_once('displayInputParams.php');

//lets just sort the results by query sequence
foreach($uniqueQueries as $query){

	echo '<div class="jobBox" style="border: 1px solid #'.DV::$BLASTOCS[$_SESSION["organism_id"]][4].'; margin: 2px 0px; margin-right:12px; float:left; width:950px;">';
	echo "<h2>$query</h2>";
	echo '<table style="margin-left:10px; border-spacing: 0px 3px; width:98%;color: #'.DV::$BLASTOCS[$organism][0].'; font:normal 8pt Sans; color:#'.DV::$BLASTOCS[$organism][0].';">';
	echo '<tr><td style="font-weight:bold; text-align:left;">Library</td>';
	//echo '<td style="font-weight:bold; text-align:left;">Lib Info</td>';
	echo '<td style="font-weight:bold; text-align:left;">Organism</td>';
	echo '<td style="font-weight:bold; text-align:left;">Sex</td>';
	echo '<td style="font-weight:bold; text-align:left;">Body Part</td>';
	echo '<td style="font-weight:bold; text-align:left;">Development</td>';
	echo '<td style="font-weight:bold; text-align:center;">Hits</td><td style="font-weight:bold; text-align:center;">Best E-Value</td><td style="font-weight:bold; text-align:center;">Raw Results</td></tr>';

	for ($i=0; $i<sizeof($organismsSearched); $i++){
		if($query==$querySequences[$i] && $results[$i]->getNumHsps()!=0){

			$evalueSortedResults=$results[$i]->getSortedHsps('evalue','asc');
			$hitWithEvalsorted = new blastResult($dbDisplayIds[$i],$query,$results[$i]->getNumHsps(),$evalueSortedResults[0]->getEvalue(), $i);

			$aResult=0;
			$rowCount=0;

			$color=DV::$BLASTOCS[ORG::$LTS[$organismNames[$i]]][6];

			echo '<tr>';
			echo '<td style="background-color: #'.$color.';width:21em;"><a target="info" href="http://www.vectorbase.org/Help/EST_Libraries/'.str_replace(" ","_",$organismNames[$i]).'#'.$filenames[$i].'"><img src="/imgs/question_16.png" align="top"></a>&nbsp;&nbsp;<a target="new" href="/Tools/BLAST/?result=html_results&job_id='.$_GET['job_id'].'&resNum='.($i+1).'&page=res" class="hashelp" name="Web:Misc_Help#view_interactive_results" title="'.$conditions[$i].'">'.$longNames[$i].'</a></td>';
			//echo '<td style="background-color: #'.$color.';text-align:center;"></td>';
			echo '<td style="background-color: #'.$color.';">'.$organismNames[$i].'</td>';
			echo '<td style="background-color: #'.$color.';">'.$sexes[$i].'</td>';
			echo '<td style="background-color: #'.$color.';">'.$bodyParts[$i].'</td>';
			echo '<td style="background-color: #'.$color.';">'.$devStages[$i].'</td>';
			echo '<td style="text-align:center; background-color: #'.$color.';">'.$results[$i]->getNumHsps().'</td>';
			echo '<td style="text-align:center; background-color: #'.$color.';">'.$hitWithEvalsorted->getBestEvalue().'</td>';

			if ($results[$i]->getNumHsps() > 0)
			echo '<td style="text-align:center;  width:8em; background-color: #'.$color.';"><a class="hashelp" target="new" name="Web:Misc_Help#view_raw_blast_results" href="/sections/Tools/tool_includes/BLAST/raw_results.php?job_id='.$_GET["job_id"].'&result='.($i+1).'"><img src="/imgs/trans_doc.gif" height="16" width="14"/></a></td>';

			echo '</tr>';
			$aResult++;
			$rowCount++;
			$anyResult++;
		}
	}
	if(!$aResult) echo '<tr><td align="center" colspan="7" style="font-weight:bold;">No Results</td></tr>';
	echo '</table>';
	echo "</div>";
}
echo "</div>";
}
