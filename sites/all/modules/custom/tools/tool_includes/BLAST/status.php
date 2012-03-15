<?php
include_once("/Volumes/Web/vectorbase/includes/Jobs.php");
include_once("blast_results.php");
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');
include_once('/Volumes/Web/vectorbase/includes/organism_definitions.php');


	function vbPack($goodies){
	  //print "<br ><pre>".serialize($goodies)."</pre><br>";
	  //$ser = serialize($goodies);
	  //print_r(unserialize($ser));
	  return serialize($goodies);
	}

	function vbUnpack($goodies){
	  return unserialize($goodies);
	}


	//get all job ids for group id
	$sql = "select job_id from job_id_groups where group_id=".$_GET["job_id"].";";
	$sqlResult = pg_query(DB::getJOB_DB(), $sql);
	while ($db_row = pg_fetch_assoc($sqlResult)){
		$jobIds[]=$db_row["job_id"];
	}

//proceed if there are results/db entries for this job
if($jobIds!=null){

//checking to make sure there are no errors with getting status
//also grab the db name being searched while we're at it
$i=0;
foreach($jobIds as $jobId){
	//first get the db file name
	$sql = "select description from job_id_groups where job_id=".$jobId.";";
	$sqlResult = pg_query(DB::getJOB_DB(), $sql);
	while ($db_row = pg_fetch_assoc($sqlResult)){
		$jobDBs[$i]=$db_row["description"];
	}

	//use db file name to look up its display name
	$sql = "select display_id from blast_databases where file_name='".$jobDBs[$i]."';";
	$sqlResult = pg_query(DB::getUI_DB(), $sql);
	while ($db_row = pg_fetch_assoc($sqlResult)){
		$jobDBNames[$i]=$db_row["display_id"];
	}
	$i++;
}

echo '<div class="jobBox" style="clear:both;">
		<h1>Job '.$_GET["job_id"].' Results</h1>';
/*
			 for($i=0; $i<count($jobIds); $i++){
				if($jobsStatus[$i]=="Finished") $finished++;
			}
			$percentDone=round($finished/count($jobIds)*100);
			
			echo '<div id="progressBarBorder" style="width:97%; height: 15px; margin: 4px; border: 1px solid #'.DV::$OCS["all"][0].';">
				<div id="progressBar" style="width:'.$percentDone.'%; height: 100%; vertical-align:middle; text-align:center; color: white; background-color: #'.DV::$OCS["all"][2].';">'.$percentDone.'%</div>
			</div>

			<table class="jobOptionTable">';
			for($i=0; $i<count($jobIds); $i++){
				echo '<tr class="jobOptionTr"><td class="jobOptionTd">'.$jobDBNames[$i].'</td><td class="jobOptionTd">';
				if ($jobsStatus[$i] == "Running" || $jobsStatus[$i] == "Pending") echo "<blink>".$jobsStatus[$i]."</blink>";
				else echo $jobsStatus[$i];
				echo "</td></tr>\n";
			}
			echo '</table>
	</div>';


	//get all job parameters
	$sql = "select * from job_params where job_id=".$_GET["job_id"].";";
	$sqlResult = pg_query(DB::getJOB_DB(), $sql);
	while ($db_row = pg_fetch_assoc($sqlResult)){
		switch($db_row["argument"]){
			//case "job_type":	$jobOptions['Job type']=$db_row['value'];		break;
			//case "user_id":		$jobOptions['User ID']=$db_row['value'];		break;
			//case "submitter_ip":	$jobOptions['Submitter IP']=$db_row['value'];		break;
			//case "job_submit_date":	$jobOptions['Job subission date']=$db_row['value'];	break;
			case "program":		$jobOptions['Program Type']=$db_row['value'];		break;
			case "wordsize":	$jobOptions['Wordsize']=$db_row['value'];		break;
			//case "numhits_oneline":	$jobOptions['Number of hits on one line']=$db_row['value'];break;
			//case "numhits_align":	$jobOptions['Number of hits align']=$db_row['value'];	break;
			case "evalue":		$jobOptions['E-value']=$db_row['value'];		break;
			case "scoringmatrix":	$jobOptions['Scoring Matrix']=$db_row['value'];		break;
			case "masking":		$jobOptions['Masking']=$db_row['value'];		break;
		}
	}

	//display the job params
	 echo '<div class="jobBox" style="float:left;">
		<div class="jobBoxTitle">BLAST Paramaters</div>
			<table class="jobOptionTable">';
			 foreach(array_keys($jobOptions) as $jobOption){
				echo '<tr class="jobOptionTr"><td class="jobOptionTd">'.$jobOption.'</td><td class="jobOptionTd">'.$jobOptions[$jobOption].'</td></tr>';
			}
			echo '</table>
		</div>
	</div>';
*/
//jobs are done, show results
//if(!$notDone){
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
			$results[$i++] = vbUnpack(pg_unescape_bytea(stripslashes($hashRow['hash'])));
		}
	}else{


	// First time getting results - let's parse them and put into the database
		try { 
			$res = Jobs::getResults($_GET["job_id"], "BLAST");
		}catch(JobException $e){
			$results_error=1;
			if ($e->getJobCode() == JobException::NO_RESULTS)
				print "<br /><div style=\"font-weight:bold; padding-left:10px; color:red; font-size:14px;\">No results for job ".$_GET["job_id"].". Please report this error to the webmaster.</div>";
			elseif ($e->getJobCode() == JobException::NO_JOB)
				print "<br /><div style=\"font-weight:bold; padding-left:10px; color:red; font-size:14px;\">No job with id ".$_GET["job_id"].".</div>";
			elseif ($e->getJobCode() == JobException::CLIENT) {
				print "<br /><div style=\"font-weight:bold; padding-left:10px; color:red; font-size:14px;\">Job with id ".$_GET['job_id']." is too large and returned too many results.  Please consider using a larger word size or a smaller E-Value.</div>";
				print "<br /><div style=\"padding-left:10px;\"><a href=\"/Tools/BLAST/?blast_id=".$_GET['job_id']."\">Run new BLAST with same parameters</a></div>";
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
						if(!pg_execute(DB::getJOB_DB(), "my_query$i", array($_GET['job_id'], $resId, pg_escape_bytea(vbPack($tempResult) ) ) ) ){
							//pg_prepare(DB::getJOB_DB(), "my_query", $addResultQuery);//DB::getJOB_DB(), $addResultQuery);
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
					$gffNum = substr($input, 8, 1);
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
							$tempHsp->setStrand( $matches[1] );
							break;
						      case "hsp_query_string";
							$tempHsp->setQueryString( $matches[1] );
							break;
						}
					}
				}
			} //end foreach
		} //end error check
	}

	//End getting results. now display stuff
		echo'<table class="jobOptionTable">';
				
				$iter1 = 0;
				while($iter1<sizeof($results)){
					preg_match("/((\/.*)*\/)*(.+)/", $results[$iter1]->getDb(), $db);
					$blastQ = "select o.short_name,b.display_id, b.sequence_type from blast_databases b, organism o where o.organism_id=b.organism_id and b.file_name = '" . $db[3] . "'";
					$bqResults = pg_fetch_assoc(pg_query(DB::getUI_DB(), $blastQ));
			  		
					echo '<tr>
						<td align="center" valign="top" width="10" rowspan="3" bgcolor="#fcfcfc">&bull;</td>
						<td colspan="2" bgcolor="#ffffff">'.$results[$iter1]->getQueryString().' vs. <i>'.ORG::$DN[$bqResults["short_name"]].'</i> '.$bqResults["display_id"].'</td>
					</tr>
					<tr>
						<td colspan="2" height="2" bgcolor="#'.DV::$OCS[$bqResults["short_name"]][5].'"></td>
					</tr>
					<tr>
						<td bgcolor="#fcfcfc" class="small" style="padding:3px;" width="205">';
							
							// TODO
							// here's the problem -- there are hits getting passed around without hsps in them!
							// do i fix it in the perl or in the php?
							// php is probably easier - do it when we read the hsp in (something like clearEmptyHits()
							// yes!
							print "<b>" . $results[$iter1]->getNumHsps();
							print " Hit";
							if ($results[$iter1]->getNumHits() != 1) echo "s ";
							print "</b> on " . $results[$iter1]->getNumHits() . " unique " . $bqResults["sequence_type"];
							if ($results[$iter1]->getNumHits() != 1) print "s";
							print ".";
							
						echo '</td>
						<td bgcolor="#fafafa" class="small" align="right" style="padding-right:4px;padding-left:4px;">';
							if ($results[$iter1]->getNumHsps() > 0)
								print "<a href=\"/Tools/BLAST/?result=html_results&job_id=" . $_GET['job_id'] . "&resNum=" . ($iter1+1) ."&page=res\" class=\"hashelp\" name=\"Web:Misc_Help#view_interactive_results\">Interactive Results</b></a>&nbsp;&bull;&nbsp;";
							
							echo '<a class="hashelp" name="Web:Misc_Help#view_raw_blast_results" href="/sections/Tools/tool_includes/BLAST/raw_results.php?job_id='.$_GET["job_id"].'&result='.($iter1+1).'">Raw Results</a>
						</td>
					</tr>';
					
					$iter1++;
					if ($iter1!=sizeof($results)) print "<tr><td colspan=\"3\" height=\"8\"></td></tr>\n";
				}
			echo '</table>
</div>';

//} //end check for results being done
}else{
	//no info for the job id, alert the user
	$rdr = "http://" . $_SERVER["HTTP_HOST"] . "/Tools/BLAST/?error=1&e14=1&id=".$_GET['job_id'];
	header("Location: " . $rdr);
}

