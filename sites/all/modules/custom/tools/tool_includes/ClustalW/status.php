<?
//error_reporting(E_ALL);
$error = 0;
//require_once("Jobs.php");
include_once('/Volumes/Web/vectorbase/includes/Jobs.php');
include_once('/Volumes/Web/vectorbase/includes/functions.php');
include_once('/Volumes/Web/vectorbase/includes/static_vars.php');
include_once('/Volumes/Web/vectorbase/includes/functions.php');
include_once('/Volumes/Web/vectorbase/includes/db_connect.php');
//include_once('/Volumes/Web/vectorbase/sections/Tools/tool_includes/ClustalW/style.css');


try {
	$job_status = Jobs::getStatus($_GET["job_id"], "ClustalW");
} catch (JobException $e) {
	$error = 1;
	print "<tr><td colspan=\"2\"><span style=\"font-size:12px;\"><span style=\"color:red;font-weight:bold;\">Error: </span>";
	if ($e->getJobCode() == JobException::NO_JOB){
		print "No Record of job " . $_GET["job_id"] . " found.";
	} else {
		print "Please report the follwing message to the site administrator: <b>" . $e->getMessage() . "</b>";
	}
	print "</span></td></tr>";
} 

if (!$error){
	$job_status = $job_status->status();
?>
<div id="leftColumn" style="float:left; clear:left; width:419px">
	<div class="box">
		<div class="boxTitle">
			<p>Job <?=$_GET["job_id"];?> Activity Report:
		</div>
		        <p><b>Job Run Status &raquo;</b>

		<div class="boxLabel">
		<div class="boxTitle"></div>
			<div class="leftText">Job Status:</div>
			<div class="rightText">
				<? if ($job_status["status"] == "Running"){
					    $job_status["status"] = "<blink>" . $job_status["status"] . "</blink>";
				}
				echo $job_status["status"];
				?>
			</div>
		</div>
														
		<div class="boxLabel">
			<div class="leftText">Date Submitted:</div>
			<div class="rightText">
				<? $datetime = extract_datetime($job_status["submitted"]);
				print date("l, dS \of F Y g:i:s A T",$datetime);
				?>
			</div>														
		</div>


			<? if ($job_status["started"]>=$job_status["submitted"]){?>
		<div class="boxLabel">
			<div class="leftText">Date Started:</div>
			<div class="rightText">
				<?
				$datetime = extract_datetime($job_status["started"]);
				print date("l, dS \of F Y g:i:s A T",$datetime);
				?>
			</div>
		</div>
			<?}
			if ($job_status["stopped"]>=$job_status["submitted"]){
			?>
		<div class="boxLabel">
			<div class="leftText">Date Finished:</div>
			<div class="rightText">
				<?
				$datetime = extract_datetime($job_status["stopped"]);
				print date("l, dS \of F Y g:i:s A T",$datetime);
				?>
			</div>
		</div>
			<?}


			// the job is done 
			// so we need to display information
			if ($job_status["status"] == "Finished"){
				$results_error = 0;
				try { 
					$res = Jobs::getResults($_GET["job_id"], "ClustalW");
					} catch (JobException $e) {
						$results_error=1;
						print "<p><b>Results:</b>";
						if ($e->getJobCode() == JobException::NO_RESULTS) {
							print "<p>No results for job " . $_GET["job_id"] . ". Please report this error to the webmaster.";
						} elseif ($e->getJobCode() == JobException::NO_JOB) {
							print "<p>No job with id " . $_GET["job_id"] . ".";
						} else {
							print $e->getMessage();
						}
					}
				/* no error */ 
				if (!$results_error){
					print "<p><b>Results &raquo;</b>";
				}
			}


			if (!$results_error){
				if ($job_status["status"] == "Finished"){
					$clustal_results=trim(file_get_contents('http://'.$_SERVER["HTTP_HOST"].'/sections/Tools/tool_includes/ClustalW/raw_results.php?job_id='.$_GET['job_id']));
					$job_query = "select * from job_params where job_id=".$_GET["job_id"];
					$job_rs = pg_query(DB::getJOB_DB(),$job_query);
						while ($job_row = pg_fetch_assoc($job_rs)){
							if ($job_row["argument"]=='seqtype'){
								$job_seqtype=$job_row["value"];
							}
						}?>


						<div class="boxLabel"><div class="boxTitle"></div>
							<div class="leftText">
								<applet code="jalview.bin.JalviewLite"
									width="168" height="35"
									archive="http://<? echo $_SERVER["HTTP_HOST"];?>/sections/Tools/tool_includes/ClustalW/jviewApplet.jar">
			  						<param name="file" value="http://<? echo $_SERVER["HTTP_HOST"];?>/sections/Tools/tool_includes/ClustalW/raw_results.php?job_id=<? echo $_GET["job_id"];?>">
			    						<param name="showFullId" value="false">
									<param name="label" value="View results in JalView">
			    						<param name="RGB"  value="f8f8f8">
								</applet>
							</div>
						</div>

						<div class="boxLabel">
							<a id="Web:ClustalW#display_results" class="hashelp" target="_NEW" href="http://<? echo $_SERVER["HTTP_HOST"]; ?>/sections/Tools/tool_includes/ClustalW/raw_results.php?job_id=<? echo $_GET["job_id"];?>">View raw results</a>
						</div>

						<div class="boxLabel">
							<a href="http://<? echo $_SERVER["HTTP_HOST"];?>/Tools/HMMBUILD?clustal_results_id=<? echo $_GET["job_id"];?>">Send results to HMMBuild</a>
						</div>

						<? //for jalview applet... <param name="userDefinedColour" value="C=yellow; R,K,H=FF5555; D,E=5555FF">
/*
								<applet code="jalview.bin.JalviewLite"
									width="160" height="35"
									archive="http://<? echo $_SERVER["HTTP_HOST"];?>/sections/Tools/tool_includes/ClustalW/jviewApplet.jar">
			  						<param name="file" value="http://<? echo $_SERVER["HTTP_HOST"];?>/sections/Tools/tool_includes/ClustalW/raw_results.php?job_id=<? echo $_GET["job_id"];?>">
			    						<param name="showFullId" value="false">
									<param name="label" value="View results in JalView">
			    						<param name="RGB"  value="f8f8f8">
								</applet>
*/
						  } else {?>

						<div class="boxLabel">
							<div class="boxTitle"></div>
							<script language="JavaScript">
							<!--
								function refresh(time) {
									setTimeout("document.location.reload()",time);
								}
							//-->
							</script>
							<input type="submit" value="Reload" onclick="refresh(0);" class="small hashelp" id="Web:ClustalW#refresh_results"/>&nbsp;
							<b>Note:</b> Page will automatically reload every 5 Seconds.
							<img src="/imgs/blank.gif" onload="refresh(5*1000);" border="0"/>
						</div>
					<?
					  	}
					}
		                   	?>
	</div>
</div>

<div id="rightColumn" style="float:left; clear:right; width:380px">
	<div class="box">
		<div class="boxTitle">
			<p>Job Parameters:
		</div>
		        <p><b>ClustalW Configuration &raquo;</b>

		<div class="boxLabel">
		<div class="boxTitle"></div>
			<p>
			<?
			$params_array = array(
			"seqtype"=>"Sequence Type",
			"format"=>"Output Format",
			"order"=>"Output Order",
			"alignment"=>"Alignment",
			"ktuple"=>"kTuple (Word Size)",
			"wlength"=>"Window Length",
			"score"=>"Score Type",
			"tdiag"=>"Top Diagonals",
			"gpenalty"=>"Gap Penalty",
			"matrix"=>"Scoring Matrix",
			"opengap"=>"Open Gap Penalty",
			"endgap"=>"Close Gap Penalty",
			"extgap"=>"Gap Extension Penalty",
			"sepgap"=>"Gap Separation Penalty",
			"sequence"=>"Sequence(s)"
			);
			$job_query = "select * from job_params where job_id=".$_GET["job_id"];
			$job_rs = pg_query(DB::getJOB_DB(),$job_query);
			?>
			<table class="trace_table" width="100%">
			<? foreach ($params_array as $param=>$param_display_name){
			   		while ($job_row = pg_fetch_assoc($job_rs)){
						if ($job_row["argument"]==$param){
							$value=$job_row["value"];
						}
					}
					pg_result_seek($job_rs,0);
			if($value!="default" && $value!=""){
				print "\t\t<tr><th valign=\"top\" width=\"100\" style=\"font-weight:normal;\">" . $param_display_name . "</th><td>";
				if ($param == "sequence"){
											
					$input_sequence="";
					while ($job_row = pg_fetch_assoc($job_rs)){
						if ($job_row["argument"]=="sequence"){
							$input_sequence = $job_row["value"];
						}
					}
					pg_result_seek($job_rs,0);
					preg_match_all("/(\>.*\n)(.*)/i",$input_sequence,$sequences,PREG_SET_ORDER);
					foreach ($sequences as $sequence){
						print "&bull;&nbsp;<a id=\"Web:ClustalW#view_input_sequence\" class=\"hashelp\" href=\"/Tools/ClustalW/?job_id=" . $_GET['job_id'] . "&result=sequence&page=sequence&sequence=" . urlencode(trim(substr($sequence[1],1))) . "\">" . substr($sequence[1],1) . "</a>";
						print "(" . strlen($sequence[2]) . " residues)";
						print "<br/>";
					}
				} else {
					while ($job_row = pg_fetch_assoc($job_rs)){
						if ($job_row["argument"]==$param){
							print $job_row["value"];
						}
					}
					pg_result_seek($job_rs,0);
				}
				print "</td></tr>\n";
			}
			}?>
			</table>
		</div>
	</div>
</div>
	<?
		} 
	?>
</td></tr>
