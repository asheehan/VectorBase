<table border="0" cellspacing="10" cellpadding="0" width="100%">
	<?
	//error_reporting(E_ALL);
	$error = 0;
	require_once("Jobs.php");
	try {
		$blast_job_status = Jobs::getStatus($_GET["job_id"], "HMMBUILD");
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
		$job_status = $blast_job_status->status();
	?>
	<tr>
		<td valign="top"><!--added to make table go up-->
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td  class="services_title">
			Job <?=$_GET["job_id"];?> Activity Report:
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff">
				<table border="0" width="100%" cellspacing="6" cellpadding="0">
				<tr>
					<td>
					<table border="0" cellspacing="1" cellpadding="1" width="100%">
					<tr>
						<td colspan="2">
							<b>Job Run Status&nbsp;&raquo;</b>
						</td>
					</tr>
					<tr>
						<td height="0" colspan="2" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
						</td>
					</tr>
					<tr>
						<td bgcolor="#f8f8f8">
							&nbsp;Job Status:
						</td>
						<td bgcolor="#f8f8f8">
						<?	if ($job_status["status"] == "Running"){
						            $job_status["status"] = "<blink>" . $job_status["status"] . "</blink>";
							}
							 echo $job_status["status"];	?>												
						</td>
					</tr>
				</tr>
				<tr>
					<td bgcolor="#f8f8f8">
						&nbsp;Date Submitted:
					</td>
					<td bgcolor="#f8f8f8">
						<?
						$datetime = extract_datetime_alt($job_status["submitted"]);
						print date("l, dS \of F Y g:i:s A T",$datetime);
						?>														
					</td>
				</tr>
				<? if ($job_status["started"]>$job_status["submitted"]){?>
				<tr>
					<td bgcolor="#f8f8f8">
						&nbsp;Date Started:
					</td>
					<td bgcolor="#f8f8f8">
						<?
						$datetime = extract_datetime_alt($job_status["started"]);
						print date("l, dS \of F Y g:i:s A T",$datetime);
						?>														
					</td>
				</tr>
				<?}
				  if ($job_status["stopped"]>$job_status["submitted"]){
				?>
				<tr>
					<td bgcolor="#f8f8f8">
						&nbsp;Date Finished:
					</td>
					<td bgcolor="#f8f8f8">
						<?
						$datetime = extract_datetime_alt($job_status["stopped"]);
						print date("l, dS \of F Y g:i:s A T",$datetime);
						?>														
					</td>
				</tr>
				<?}?>
				</table>
			</td>
		</tr>
		<tr>
			<td>
		                <table border="0" cellspacing="0" cellpadding="0" width="100%">
		                   <tr>
		                        <td>
                                         	<?
						// --rb
                                                // the job is done 
                                                // so we need to display information
                                                if ($job_status["status"] == "Finished"){
                                                	$results_error = 0;
                                                        try { 
                                                        	$res = Jobs::getResults($_GET["job_id"], "HMMBUILD");
                                                        } catch (JobException $e) {
                                                                //print "<pre>";
                                                                //print_r($e);
                                                                //print "</pre>";
                                                                $results_error=1;
                                                                print "<b>Results: </b>";
                                                                if ($e->getJobCode() == JobException::NO_RESULTS) {
                                                        	        print "No results for job " . $_GET["job_id"] . ". Please report this error to the webmaster.";
                                                                } elseif ($e->getJobCode() == JobException::NO_JOB) {
                                                                        print "No job with id " . $_GET["job_id"] . ".";
                                                                } else {
                                                                        print $e->getMessage();
                                                                }
                                                        }
                                                        /* no error */ 
                                                        if (!$results_error){
                                                                      
                                                                print "<b>Results&nbsp;&raquo;</b>";
                                                                        
                                                        }
	                                 	}
                                                ?>
                              		</td>
                     		</tr>
				<tr><td colspan=\"2\" height=\"1\" bgcolor=\"" . DV::$OCS[$_SESSION["organism_id"]][5] . "\"></td></tr>

				<?
                                if (!$results_error){
					  if ($job_status["status"] == "Finished"){
						print "<tr><td colspan=\"2\" height=\"1\" bgcolor=\"" . DV::$OCS[$_SESSION["organism_id"]][5] . "\"></td></tr>\n";
						print "<tr><td bgcolor=\"#f8f8f8\">View HMMBuild results</td>";
						print "<td bgcolor=\"#f8f8f8\">";
						print "<a class=\"hashelp\" name=\"Web:hmmbuild_results\" target=\"_NEW\" href=\"http://" . $_SERVER["HTTP_HOST"] . "/sections/Tools/tool_includes/HMMER/build_results.php?job_id=" . $_GET["job_id"] . "\">";
						print "[Here]</a></td></tr>\n";

						print "<tr><td bgcolor=\"#f8f8f8\">Use results in HMMSearch</td>";
						print "<td bgcolor=\"#f8f8f8\">";
						print '<a class="hashelp" name="Web:hmmbuild_results" target="_NEW" href="http://'.$_SERVER["HTTP_HOST"].'/Tools/HMMSEARCH?hmmbuild_id='.$_GET["job_id"].'">';
						print "[Here]</a></td></tr>\n";

					  } else {
				?>
						<script language="JavaScript">
						<!--
							function refresh(time) {
								setTimeout("document.location.reload()",time);
							}
						//-->
						</script>
						<input type="submit" value="Reload" onclick="refresh(0);" class="small hashelp" id="Web:hmmbuild_refreshresults" >&nbsp;
						<b>Note:</b> Page will automatically reload every 15 Seconds.
						<img src="/imgs/blank.gif" onload="refresh(15*1000);" border="0"/>
				<?
				  	}
				}
                           	?>
                        </table>
                        </td>
                        </tr>
		</table>
		</td>
		</tr>
		</table>
		</td>
 		<td valign="top" width="360">

                    	<table border="0" cellspacing="0" width="350" cellpadding="0" width="100%">
                        	<tr>
                            	<td class="services_title">
                            		Job Parameters:
				</td>
				</tr>
                            	<tr>
                            	<td bgcolor="#ffffff" style="padding:6px;">
					<table border="0" width="100%" cellspacing="1" cellpadding="1"> 
                                    	<tr>
                                        	<td colspan="2">
                                        	<b>HMMBUILD Configuration &raquo;</b>
                                        	</td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" height="0" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                        	</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding:0px;">
                                        	<?
                                        	$params_array = array(
							"seqtype"=>"Sequence Type",
							"alignment"=>"Alignment",
							"algorithm"=>"Algorithm",
                                                        "calibrate"=>"Calibrate",
							"randomseqlength"=>"Random Sequence Length",
							"randomseed"=>"Random Seed",
							"randomseqlengthmean"=>"Random Sequence Length Mean",
							"sampledseqs"=>"Sampled Seqences",
							"randomseqlengthstddev"=>"Random Sequence Length Std Dev"
                                                        );
						$job_query = "select * from job_params where job_id=".$_GET["job_id"];
						$job_rs = pg_query(DB::getJOB_DB(),$job_query);
						?>
						<table class="trace_table" width="100%">
							<? 
							foreach ($params_array as $param=>$param_display_name){
								print "<tr><th valign=\"top\" width=\"100\">" . $param_display_name . "</th><td>";
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
										print "&bull;&nbsp;<a class=\"hashelp\" name=\"Web:view_hmmbuild_sequence\" href=\"/Tools/HMMBUILD/?job_id=" . $_GET['job_id'] . "&result=sequence&page=sequence&sequence=" . urlencode(trim(substr($sequence[1],1))) . "\">" . substr($sequence[1],1) . "</a>";
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
								print "</td></tr>";
							}
							?>
						</table>
						</td>
					</tr>		
                               	</table>
                            	</td>
                        	</tr>
                    	</table>
					</td>
				</tr>
			<?
		} 
	?>
</table>
