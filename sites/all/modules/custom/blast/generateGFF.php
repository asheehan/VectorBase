<?php

require_once('Timer.php');

// these are used for viewing chromosome arm/supercontig segments in the genome browser
function blast_generateGFF($id, $searchId = null){

	$debugFilename = $_SERVER['DOCUMENT_ROOT']."/data/debugDataForJob_$id.log";
	$hspsQuery = '';
	$bh_ids = null;
	$queryTimer = new Timer();
	$writeTimer = new Timer();
	$reverseHeaderTimer = new Timer();
	$allResultsTimer = new Timer();
	$hitsTimer = new Timer();
	$hspsQueryFetchTimer = new Timer();
	if(empty($searchId)) {
		$searchId=blast_getRawJobId($id);
	}
	$br_ids=array();


	// get the tid for "Reversed Headers"
	$reverseHeaderTimer->start();
	$rhTidQuery=db_select('taxonomy_term_Data', 't');
	$rhTidQuery->addField('t', 'tid');
	$rhTidQuery->condition('t.name', 'Reversed Headers', '=');
	$rhTid = $rhTidQuery->execute()->fetchField();

	$reverseHeaderTimer->stop();

	// look up all blast_results that have this search id
	$allResultsTimer->start();	
	$blastResultsQuery=db_select('blast_results', 'br');
	$blastResultsQuery->addField('br', 'br_id');
	$blastResultsQuery->addField('br', 'query_name');
	$blastResultsQuery->addField('br', 'query_description');
	$blastResultsQuery->addField('br', 'database_name');
	$blastResultsQuery->condition('br.search_id', $searchId, '=');
	$results = $blastResultsQuery->execute();
	$allResultsTimer->stop();

	while(($result = $results->fetchAssoc()) !== false){
		$br_ids[]=$result['br_id'];  
		$queryNames[]=trim($result['query_name'].' '.$result['query_description']);
		$databaseNames[] = $result['database_name'];
		$rh_dbs[$result['database_name']] = null; // super important to make this null - tells us we haven't looked up if we have a reverse header or not
	}

	// only run if there are results or else drupal will report notice errors
	if(count($br_ids)>0){

		// Generate gff file for each blast_result
		for($br_idx = 0; $br_idx < count($br_ids); $br_idx++) {
			$br_id = $br_ids[$br_idx];
			$bh_ids=array();
			$hitNames=array();

			$gff='track name="BLAST Hits" description="BLAST Hits" color=green useScore=0 url=http://www.vectorbase.org/Tools/BLAST/?result=html_results&br_id='.$br_id.'&page=res&job_id='.$id."\n";

			// look up all blast hits for this blast result
			$queryTimer->start();
			$blastHitsQuery=db_select('blast_hits', 'bh');
			$blastHitsQuery->addField('bh', 'bh_id');
			$blastHitsQuery->addField('bh', 'name');	
			$blastHitsQuery->addField('bh', 'description');
			$blastHitsQuery->condition('bh.br_id', $br_id, '=');
			$hits = $blastHitsQuery->execute();
			$queryTimer->stop();
			while(($hit = $hits->fetchAssoc()) !== false){
				$bh_ids[]=$hit['bh_id'];
				$hitNames[]=$hit['name'];
				//$hitDescriptions[]=$hit->description;
			}

			// get hsp info for these hits
			if($bh_ids){ // check for results

				for($k=0; $k<count($hitNames); $k++){

					// change some of the hit names so the gffs show up in ensembl properly
					// these should all be tagged with "Reversed Headers"

					// get the nid(entity_id) for this db name
					if(is_null($rh_dbs[$databaseNames[$br_idx]])) {
						$queryTimer->start();			
						$isTaggedQuery = db_select('file_managed', 'fm');
						$isTaggedQuery->addField('fm', 'fid');
						$isTaggedQuery->join('field_data_field_file', 'ff', 'fm.fid = ff.field_file_fid');
						$isTaggedQuery->join('field_data_field_tags', 'ft', 'ft.entity_id = ff.entity_id');
						$isTaggedQuery->condition('fm.filename', $databaseNames[$br_idx], '=');
						$isTaggedQuery->condition('ft.field_tags_tid', $rhTid, '=');
						$isTaggedQuery = $isTaggedQuery->countQuery();
						$isTagged = $isTaggedQuery->execute()->fetchAssoc();
						//$isTaggedObj=db_query('select count(*) from file_managed fm, field_data_field_file ff, field_data_field_tags ft where fm.filename = :filename and fm.fid = ff.field_file_fid and ff.entity_id = ft.entity_id and ft.field_tags_tid = :taxId', array(':filename'=>$databaseNames[$br_idx], ':taxId'=>$rhTid));
						//$isTagged = $isTaggedObj->fetchAssoc();
						$rh_dbs[$databaseNames[$br_idx]] = ($isTagged !== false && !empty($isTagged['count']));
						$queryTimer->stop();
					}

					if($rh_dbs[$databaseNames[$br_idx]]){
						preg_match("#^.*?:.*?:(.*?):#",$hitNames[$k],$match);
						$hitNames[$k]=$match[1];
					}

				}

				$hitsTimer->start();			
				$hspsQuery = db_select('blast_hsps', 'bh');
				$hspsQuery->addField('bh', 'bh_id');
				$hspsQuery->addField('bh', 'starthit');
				$hspsQuery->addField('bh', 'endhit');
				$hspsQuery->addField('bh', 'score');
				$hspsQuery->addField('bh', 'strandhit');
				$hspsQuery->condition('bh.bh_id', $bh_ids, 'IN');
				$hspsQuery->orderBy('bh.bh_id');
				//'select bh_id, starthit,endhit,score,strandhit from blast_hsps where bh_id in ($1';
				//				for($bh_idx=1;$bh_idx<count($bh_ids);$bh_idx++){
				//					$hspsQuery .= ',$';
				//					$hspsQuery .= ($bh_idx+1);
				//				}
				//				$hspsQuery .= ') order by bh_id';
				//				$hspsObj=db_query($hspsQuery, $bh_ids);
				//$db = pg_connect("host=db.vectorbase.org dbname=vb_drupal user=db_public password=limecat");
				//if(!$db) {
				//	die("Error in connection: " . pg_last_error());
				//	}   
				//	$result = pg_prepare($db, 'hspsQuery', $hspsQuery);
				//	$hspsObj = pg_execute($db, 'hspsQuery', $bh_ids);
				//	$hsps = pg_fetch_array($hspsObj);
				$hsps = $hspsQuery->execute();
				$hitsTimer->stop();

				/*$hspsQueryFetchTimer->start();
				  $hsps = $hspsObj->fetchAssoc();
				  $hspsQueryFetchTimer->stop();*/

				//$j=0;
				//foreach($bh_ids as $bh_id) {
				$hsp = $hsps->fetchAssoc();
				if($hsp !== false) {
					$currentBlastResultIdx = 0;
					$lastDistinctBlastId = $hsp['bh_id'];
					do {

						file_put_contents($debugFilename, print_r($hsp, true) . "\n", FILE_APPEND);
						if($lastDistinctBlastId !== $hsp['bh_id']) {
							$currentBlastResultIdx++;
							$lastDistinctBlastId = $hsp['bh_id'];
						}
						if($hsp['strandhit']=='1')
							$strand="+";
						else if($hsp['strandhit']=='-1')
							$strand="-";
						else 
							$strand=".";

						$gff.=$hitNames[$currentBlastResultIdx]."\tBLAST\tBlast Hit\t".$hsp['starthit']."\t".$hsp['endhit']."\t".$hsp['score']."\t".$strand."\t.\t".$queryNames[$br_idx]."\n";
						//      hit name        BLAST   Blast Hit   start   end     length  strand  .   query name
					} while(($hsp = $hsps->fetchAssoc()) !== false); 
				}
				//}

				// save locally
				$location=$_SERVER['DOCUMENT_ROOT']."/data/";
				$fileName=$id."_".$br_id.".gff";
				$writeTimer->start();
				file_put_contents($location.$fileName,$gff);
				$writeTimer->stop();
			} // end check for results
		}
	}


	/*$queryTimer = new Timer();
	  $writeTimer = new Timer();
	  $reverseHeaderTimer = new Timer();
	  $allResultsTimer = new Timer();
	  $hitsTimer = new Timer();*/

	$timingData = "Timing data for gff file generation for job $id / $searchId\n";
	$timingData .= "\tReverse header query took: " . $reverseHeaderTimer->elapsed() . " seconds\n";
	$timingData .= "\tAll blast results query took: " . $allResultsTimer->elapsed() . " seconds\n";
	$timingData .= "\tIs tagged queries (3n) took: " . $queryTimer->elapsed() . " seconds\n";
	$timingData .= "\tHits query took: " . $hitsTimer->elapsed() . " seconds\n";
	//	$timingData .= "\tTime took to fetch hit results out of object: " . $hspsQueryFetchTimer->elapsed() . "\n";
	$timingData .= "\tFile writing took: " . $writeTimer->elapsed() . " seconds\n";	
	$timingData .= "\tBlast hit ids (should match the number of ?'s in the hists query) (size: " . count($bh_ids) . '):  ' . print_r($bh_ids, true) . "\n";
	file_put_contents($_SERVER['DOCUMENT_ROOT']."/data/gffFileGenerationTimingDataForJob_$id.log", $timingData);
}
