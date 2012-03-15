<?
error_reporting(E_ALL);
$error = 0;
require_once("/Volumes/Web/vectorbase/includes/Jobs.php");
require_once("/Volumes/Web/vectorbase/includes/hmmOut.php");

try {
  $hmmer_job_status = Jobs::getStatus($_GET["job_id"], "HMMSEARCH");
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

?>


<script language="JavaScript" type="text/javascript">
	<!-- // Required to be compliant with XHTML-->
	function results(database,file,color)
	{
	 var xmlHttp=null; // Defines that xmlHttp is a new variable.
	 // Try to get the right object for different browser
	 try {
	    // Firefox, Opera 8.0+, Safari, IE7+
	    xmlHttp = new XMLHttpRequest(); // xmlHttp is now a XMLHttpRequest.
	 } catch (e) {
	    // Internet Explorer
	    try {
	       xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
	       xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
	 }
	 xmlHttp.onreadystatechange = function() {
	    if (xmlHttp.readyState == 4)
	       try { // In some instances, status cannot be retrieved and will produce 
		     // an error (e.g. Port is not responsive)
		  if (xmlHttp.status == 200) {
		     // Set the main HTML of the body to the info provided by the 
		     // Ajax Request
		     document.getElementById("details").innerHTML 
		        = xmlHttp.responseText;
		  }
	       } catch (e) {
		  document.getElementById("details").innerHTML 
		     = "Error on Ajax return call : " + e.description;
	       }
	 
	 }
	 xmlHttp.open("get",'/sections/Tools/tool_includes/HMMER/results.php?job_id=<?=$_GET["job_id"]?>&db='+database+'&file='+file+'&organism_id='+color,true); // .open(RequestType, Source);
	 xmlHttp.send(null); // Since there is no supplied form, null takes its place 
		             // as a new form.
	}


		function histoStats(score,obs,expt){
			var score_element = document.getElementById('score');
			var obs_element = document.getElementById('obs');
			var expt_element = document.getElementById('expt');
			score_element.innerHTML = score;
			obs_element.innerHTML = obs;
			expt_element.innerHTML = expt;
		}






var loadedobjects=""
function loadobjs(){
	if (!document.getElementById)
	return

	for (i=0; i<arguments.length; i++){
		var file=arguments[i]
		var fileref=""
		//if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
			if (file.indexOf(".js")!=-1){ //If object is a js file
				fileref=document.createElement('script')
				fileref.setAttribute("type","text/javascript");
				fileref.setAttribute("src", file);
			}
			else if (file.indexOf(".css")!=-1){ //If object is a css file
				fileref=document.createElement("link")
				fileref.setAttribute("rel", "stylesheet");
				fileref.setAttribute("type", "text/css");
				fileref.setAttribute("href", file);
			}
		//}
		if (fileref!=""){
			document.getElementsByTagName("head").item(0).appendChild(fileref)
			loadedobjects+=file+" " //Remember this object as being already added to page
		}
	}
}
-->
</script>




<?
if (!$error){
  $job_status = $hmmer_job_status->status(); ?>


<div class="box" style="float:left; clear:none; width:45%;">

	<div class="boxTitle">
		    <p>Job <?=$_GET["job_id"];?> Activity Report
	</div>

	<p><b>Job Run Status&nbsp;&raquo;</b>

	<div class="boxLabel">
	<div class="boxTitle"></div>

		<p>Job Status:
		<?if ($job_status["status"] == "Running"){
		    $job_status["status"] = "<blink>" . $job_status["status"] . "</blink>";
		}
		 echo $job_status["status"];	?>												
	</div>

	<div class="boxLabel">
		<p>Date Submitted:
		<?
		$datetime = extract_datetime_alt($job_status["submitted"]);
		print date("l, dS \of F Y g:i:s A T",$datetime);
		?>														
	</div>

<? if ($job_status["started"] > $job_status["submitted"]){ ?>
	<div class="boxLabel">
		<p>Date Started:
		<?
		$datetime = extract_datetime_alt($job_status["started"]);
		print date("l, dS \of F Y g:i:s A T",$datetime); ?>
	</div>
		<?} ?>

<?if ($job_status["stopped"] > $job_status["submitted"]){?>
	<div class="boxLabel">
		<p>Date Finished:
		<?
		$datetime = extract_datetime_alt($job_status["stopped"]);
		print date("l, dS \of F Y g:i:s A T",$datetime); ?>
	</div>
		<?}?>

<?
//the job is done 
// so we need to display information
if ($job_status["status"] == "Finished"){
	$results_error = 0;
	try { 
		$res = Jobs::getResults($_GET["job_id"], "HMMSEARCH");
	} catch (JobException $e) {
		$results_error=1;
		print "<p><b>Results: </b>";
		if ($e->getJobCode() == JobException::NO_RESULTS) {
			print "No results for job " . $_GET["job_id"] . ". Please report this error to the webmaster.";
		} elseif ($e->getJobCode() == JobException::NO_JOB) {
			print "No job with id " . $_GET["job_id"] . ".";
		} else {
			print $e->getMessage();
		}
	}
}

if (!$results_error){
	//job isn't done, show refresh button
	if ($job_status["status"] != "Finished"){ 
?>
	<div class="boxLabel">
	<div class="boxTitle"></div>
		<script language="JavaScript">
			<!--
			function refresh(time) {
				setTimeout("document.location.reload()",time);
			}
			-->
		</script>
	        <input type="submit" value="Reload" onclick="refresh(0);" class="small hashelp" id="Web:Misc_Help:hmmsearch_refresh_results">&nbsp;
		<b>Note:</b> Page will automatically reload every 15 Seconds.
		<img src="/imgs/blank.gif" onload="refresh(15*1000);" border="0"/>
	</div>
<?
  	}
}
?>
</div>



<? if ($job_status["status"] != "Finished"){
?>

<div class="box" style="float:right; clear:none; width:50%">
	<div class="boxTitle">
        	<p>Job Parameters:
	</div>

                <p><b>HMMSEARCH Configuration &raquo;</b>

	<div class="boxLabel">
	<div class="boxTitle"></div>
	<p>
              <?
              $params_array = array(
                "evalue"=>"Maximum E-Value",
		"target_database"=>"Databases"
                //"masking"=>"Low Complexity Masking"
              );
              $job_query = "select jp.*, bdb.display_id,o.display_name as organism_display_name,dv.body_bg as textcolor from job_params jp left join blast_databases bdb on bdb.file_name=jp.value left join organism o on o.organism_id=bdb.organism_id left join display_vars dv on dv.organism_id=bdb.organism_id where jp.job_id=".$_GET["job_id"];
	      $job_query = "select * from job_params where job_id=".$_GET["job_id"];
              $job_rs = pg_query(DB::getJOB_DB(),$job_query);
              ?>
                <table class="trace_table" width="100%">
                  <? 

                  foreach ($params_array as $param=>$param_display_name){
                    print "<tr><th valign=\"top\" width=\"130\">" . $param_display_name . "</th><td>";
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
                        print "&bull;&nbsp;<a onmouseover=\"displayHelp(event, '" . addslashes($wh->helpShort("view_hmmer_query_sequence")) . "', 'view_hmmer_query_sequence');\" onmouseout=\"clearHelp();\" href=\"/Tools/HMMSEARCH/?job_id=" . $_GET['job_id'] . "&result=sequence&page=sequence&sequence=" . urlencode(trim(substr($sequence[1],1))) . "\">" . substr($sequence[1],1) . "</a>";
                        print "(" . strlen($sequence[2]) . " residues)";
                        print "<br/>";
                      }


                    } else if ($param == "databases"){
                      while ($job_row = pg_fetch_assoc($job_rs)){
                        if ($job_row["argument"]=="target_database"){
                          $TARGETDB[$job_row["organism_display_name"]]["databases"][$job_row["display_id"]] = true;
                          $TARGETDB[$job_row["organism_display_name"]]["color"] = $job_row["textcolor"];
                        }
                      }
                      pg_result_seek($job_rs,0);
                      $j=0;
                      foreach ($TARGETDB as $organism => $param){
                        $j++;
                        print "<span style=\"color:#" . $param["color"] . ";\"><i>" . $organism . "</i> target databases:</span><br/>";
                        foreach ($param["databases"] as $database => $text_color){
                          print "&bull;&nbsp;" . $database . "<br/>";
                        }
                        if ($j != count($TARGETDB)){
                          print "<br/>\n";
                        }	

                      }
                    } else {
                      while ($job_row = pg_fetch_assoc($job_rs)){
                        if ($job_row["argument"]==$param){
                          print $job_row["value"].'<br/>';
                        }
                      }
                      pg_result_seek($job_rs,0);
                    }
                    print "</td></tr>";
                  }
?>
                  </table>
	</div>
</div>
<?
} else {?>
<div class="box" style="float:right; clear:none; width:50%">
	<div class="boxTitle">
        	<p>Results</p>
	</div>

	<p>
	<div class="boxLabel">
		<div class="boxTitle">
		</div>

		<?
			$results = Jobs::getResults($_GET["job_id"], "HMMSEARCH");                             
			$output = new hmmOut($results->results());
			$searchedDBs = $output->searchedDBs();?>

		<div style="width:30px;float:left;clear:none;text-align:right;margin-right:8px;">
			Hits
		</div>

		<div style="width:auto;float:left;">
			Database
		</div>

		<div style="float:right;">
			<? echo "<a class=\"hashelp\" name=\"Web:Misc_Help#view_raw_hmmsearch_results\" href=\"http://" . $_SERVER["HTTP_HOST"] . "/sections/Tools/tool_includes/HMMER/search_results.php?job_id=" . $_GET["job_id"] . "\">[Raw Results]</a></div></p>";?>
		</div>

		<?
		$i=0;
                $fp = fopen("/Volumes/Web/vectorbase/data/job_input/search_status",'w');
                fwrite($fp, "Hello\n");
                fwrite($fp, $searchedDBs['titles'] . "\n");
		foreach ($searchedDBs['titles'] as $dbtitle) {
			
			$searchStats = $output->searchStats($output->getOneDB($i));

                        fwrite($fp,$dbtitle."\n");

			$organism_id = $searchedDBs["organism_ids"][$i] -1;
                        fwrite($fp,$organism_id . "\n");
			$organism_name = ORG::$SN[$organism_id];
			$color = DV::$OCS[$organism_name][4];

                        $dbtitle_tmp = str_replace("\"", "&#34;", $dbtitle);
                        $dbtitle_new = str_replace("<b class", "<b_class", $dbtitle_tmp);

			echo '<div class="boxLabel" style="background-color:#'.$color.';">';
			//echo '<p style="background-color:#'.DV::$OCS[$organism_name][4].';">';
			$link="<a href=\"javascript:results('$dbtitle_new','".$searchedDBs['searched'][$i]."','".$organism_id."');loadobjs('sections/Tools/tool_includes/HMMER/hmm.css?organism_name=".$organism_name."');\">";

//loadobjs('/sections/Tools/tool_includes/HMMER/hmm.css?organism_name=".$organism_name."');

			echo '<span style="width:30px;background-color:inherit;float:left;clear:none;text-align:right;margin-right:8px;">'.$link.$searchStats["eCutoff"].'</a></span>';
			echo '<span style="width:auto;background-color:inherit;float:left;">'.$link.$dbtitle.'</a></span>';
			echo "</div>\n";
			$i++;
		} ?>

	</div>
</div>
	<?
}



 if ($job_status["status"] == "Finished"){?>

<div class="box" style="width:780px; clear:both;">
	<div class="boxTitle">
		<p>Detailed Results
	</div>

	<div id="details">
		<p>Click on a database to view its results.</p>
	</div>


</div>
<?}
}
?>
