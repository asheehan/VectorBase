<?php


// display a pretty table of top level info on blast job; should be fed raw blast job id
function blast_results_topLevel($id){
	$out='';

// 1) get total number of hits for each db (for all queries combined)
// 1.1) find dbs that were hit
$dbsHit=blast_getDbsForSearchJob($id);
// 1.2) get total number of hits for each db
$hasHits=FALSE;
if($dbsHit){
	foreach($dbsHit as $db){

		// this is just the number of hit sequences reported by bioperl
		//$query=db_query("select sum(num_hits) from blast_results where search_id=$id and database_name='$db'")->fetchField();

		// this is the actual number of hsps we've parsed/saved
		$query=db_query("select count(s.bs_id) from blast_results r, blast_hits h, blast_hsps s where r.br_id=h.br_id and h.bh_id=s.bh_id and r.search_id=$id and r.database_name='$db'")->fetchField();

		$numHits[$db]=$query;
		if($query>0)
			$hasHits=TRUE;
	}

	// 2) display results
	// only show table if there are results
	if($hasHits){

	$out.="
	<div id='topLevelResults'>
		<table id=\"topLevelTable\" class=\"tablesorter\" data-initial=\"sortme\">
			<thead>
				<tr>
					<th>Organism</th>
					<th>Database</th>
					<th title=\"High-scoring Segment Pairs\">HSPs</th>
				</tr>
			</thead>

			<tbody>\n";

		foreach($numHits as $key => $value){
			// only print row for dbs with hits
			if($value>0){

				// look up organism names
				// look up pretty db names
				$dbinfo=blast_dbinfo($key);

				// dirty hack to remove stupid s.s from a. gambiae name
				$orgName=str_replace(" s.s.", "", $dbinfo['organism']);

				$link="<a class=\"dbResult\" data-id=\"$id\" data-db=\"$key\">".$dbinfo['description']."</a>";
				$out.= "		<tr>
					<td>$orgName</td>
					<td>$link</td>
					<td>$value</td>
				</tr>\n";

			}
		}

		$out.="		</tbody>
			</table>
		</div>
		<div id=\"hspLevelResults\"></div>
		<div id=\"hspDialog\" title=\"BLAST HSP Details\"></div>

		";

	}else
		$out="<div id=\"noResults\">No hits found.</div>";
}else
	$out="<div id=\"noResults\">No hits found.</div>";

return $out;
}