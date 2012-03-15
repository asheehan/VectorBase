<?
include_once '/Volumes/Web/vectorbase/includes/Jobs.php';
include_once '/Volumes/Web/vectorbase/includes/hmmOut.php';
include_once '/Volumes/Web/vectorbase/includes/organism_definitions.php';

$organism_name = ORG::$SN[$_GET['organism_id']];

$results = Jobs::getResults($_GET["job_id"], "HMMSEARCH");                             
		$output = new hmmOut($results->results());
		$searchedDBs = $output->searchedDBs();
		$db_key = array_search($_GET['file'], $searchedDBs["searched"]);
		$db = $output->getOneDB($db_key);

		$sequenceStats = $output->sequenceStats($db);
		$searchStats = $output->searchStats($db);
		$histogram = $output->histogram($db);
		$binwidth = $output->histoWidth($db);

$fp = fopen("/Volumes/Web/vectorbase/data/job_output/results.php.debug",'w');
fwrite($fp, $searchsequenceStats . "\n");
fwrite($fp, $searchStats . "\n");
fwrite($fp, $histogram . "\n");
fwrite($fp, $binwidth . "\n");


/* NEED BETTER ERROR CHECKING
		if(count($searchedDBs["errored"])>0) {
			echo '<font color="red"><bold>There was an error searching the following: </bold><br/><br/>';
			foreach($searchedDBs["errored"] as $errordb) {
				echo $errordb.'<br/>';
			} echo '</font>';
		}
*/

?>
<script language="JavaScript" type="text/javascript">
<!-- 
	function histoStats(score,obs,expt){
		var score_element = document.getElementById('score');
		var obs_element = document.getElementById('obs');
		var expt_element = document.getElementById('expt');
		score_element.innerHTML = score;
		obs_element.innerHTML = obs;
		expt_element.innerHTML = expt;
	}
-->
</script>
<head>
  <link rel="stylesheet" href="/includes/index_style.css" type="text/css"/>
<style type="text/css">
<!--
.histoBar {
width:2px;
background-color:#<?=DV::$OCS[$organism_name][0];?>;
position:absolute;
bottom:0px;
margin:0px 0px 0px 0px;
}
.histoBarTransOn {
width:2px;
background-color:#<?=DV::$OCS[$organism_name][3]?>;
position:absolute;
bottom:0px;
}
.histoBarTrans {
width:2px;
position:absolute;
bottom:0px;
border: none;
	opacity: 0.0; /* the standards compliant attribute that all browsers should recognize, but... */
	filter:alpha(opacity=0); /* for IE */
	-khtml-opacity: 0.0; /* for old Safari (1.x) */
	-moz-opacity:0.0; /* for old skool Netscape Navigator */
}
.histoBarExp {
width:2px;
background-color:#<?=DV::$OCS[$organism_name][3]?>;
position:absolute;
bottom:0px;
border: none;
opacity: 0.5;
filter:alpha(opacity=50);
-khtml-opacity: 0.5;
-moz-opacity:0.5;
}

.mybold {
font-family:Arial;
font-weight:bold;
color:#<?=DV::$OCS[$organism_name][0]?>;
}

.rowOn{
background-color:#<?=DV::$OCS[$organism_name][4]?>;
}
.rowOff{
background-color:none;
}
-->
</style>

</head>



<p><span class="mybold"><?=$_GET['db']?>&nbsp;&raquo;</span>
<div class="boxLabel">
	<div id="line" style="border:1px solid #<?=DV::$OCS[$organism_name][2]?>;"></div>
	<div class="boxLabel" style="position:relative;width:100%">

		<div class="boxLabel" style="float:left;clear:none;margin:0px 0px 0px 0px;">
			Search Stats
				<table class="trace_table">
					<tr>
						<td>Sequences Searched</td><td><?=$searchStats['sequencesSearched']?></td>
					</tr>
					<tr>
						<td>Total Hits</td><td><?=$searchStats['totalHits']?></td>
					</tr>
					<tr>
						<td>Satisfying E-cutoff</td><td><?=$searchStats['eCutoff']?></td>
					</tr>
					<tr>
						<td>Total Time (sec)</td><td><?=$searchStats['totalTime']?></td>
					</tr>
				</table>			
		</div>

		<div class="boxLabel" style="float:left;clear:none;margin-left:15px;">
			Theoretical EVD Fit Stats
				<table class="trace_table">
					<tr>
						<td>Mu</td><td><?=$searchStats['mu']?></td>
					</tr>
					<tr>
						<td>Lambda</td><td><?=$searchStats['lambda']?></td>
					</tr>
					<tr>
						<td>Chi-Square Statistic</td><td><?
						if($searchStats['chiSq']>1000)
						  $chisq=round($searchStats['chiSq']);
						else
						  $chisq=$searchStats['chiSq'];

						echo $chisq;

						?></td>
					</tr>
				</table>			
		</div>

		<?$histograph = $output->histograph($db,$organism_name);?>

	</div>

	
	<table width="100%" cell padding ="10">

	<?$dbInfo = $output->dbInfo($searchedDBs["searched"][$db_key]);
	$link = $dbInfo["link"];

	echo "<tr><td><span class=\"mybold\">Sequences</td><td><span class=\"mybold\">Descriptions</td><td><span class=\"mybold\">Scores</td><td><span class=\"mybold\">E-Values</b></td></tr>";
	for($j=0; $j < count($sequenceStats["sequences"]); $j++) {

		  //only display genome browser links for aedes and anopheles
		  if ( preg_match("#(agambiae|aaegypti).*#",$searchedDBs["searched"][$db_key]) and !(preg_match("#.*?SUPP.*?#",$searchedDBs["searched"][$db_key])) )
			$gbrowser="<a href=\"".$link.$sequenceStats["sequences"][$j]."\">".$sequenceStats["sequences"][$j]."</a>";
		  else
			$gbrowser=$sequenceStats["sequences"][$j];

			print "<tr onmouseover=\"this.className='rowOn'\" onmouseout=\"this.className='rowOff'\">
				<td>".$gbrowser."</td>
				<td>".$sequenceStats["descriptions"][$j]."</td>
				<td>".$sequenceStats["scores"][$j]."</td>
				<td>".$sequenceStats["evals"][$j]."</td></tr>\n";	
	}

	if ($j==0) {
		echo "<tr><td colspan=\"5\">No results</td></tr>";
	}

		echo "\n</table>\n";

echo '</div>';
?>
