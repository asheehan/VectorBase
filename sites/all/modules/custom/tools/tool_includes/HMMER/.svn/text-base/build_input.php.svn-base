<?
	$HMMBUILD_FORM_NAME="hmmbuild_input_form";
	include("hmmer_errors.php");
	include_once("Jobs.php");
	$hmmbuild_errors=$hmmer_errors;
?>

<script language="JavaScript" type="text/javascript">
<!--
	function setMatrix() {
		var sequence_type = document.getElementById('hmmer_seqtype');
		if (sequence_type.value == 'protein') {
			document.<?=$HMMBUILD_FORM_NAME;?>.matrix.selectedIndex = 0;
		} else {
			document.<?=$HMMBUILD_FORM_NAME;?>.matrix.selectedIndex = 3;
		}
	}

	function toggle_div(id) {

		var div = document.getElementById(id).style.visibility;

		if (div == "hidden"){
			document.getElementById(id).style.visibility="visible";					
		} else {
			document.getElementById(id).style.visibility="hidden";
		}
		enforce_param_constraints();
	}

	function enforce_param_constraints() {
		var align = document.getElementById('Web:hmmbuild_model');
		if (align.value == 'default') {
			var popup = document.getElementById('Web:hmmbuild_gapmax');
			popup.disabled = true;
		} else {
			var popup = document.getElementById('Web:hmmbuild_gapmax');
			popup.disabled = false;
		}
	}
	-->
</script>
<form method="post" enctype="multipart/form-data" action="http://<? echo $_SERVER["HTTP_HOST"]; ?>/sections/Tools/tool_includes/HMMER/build_submit.php" name="<?=$HMMBUILD_FORM_NAME;?>">
<div id="leftColumn" style="float:left; clear:none; width:315px;">
	<div class="box">
		<div class="boxTitle">
			Directions:
		</div>
		<ol>
			<li>Paste or upload multiple sequence alignment.</li>
			<li><i>Optional:</i> Set additional HMMBUILD parameters.</li>
			<li>Submit your HMMBUILD job.</li>
			<li>For more information, read the <a href="ftp://selab.janelia.org/pub/software/hmmer/CURRENT/Userguide.pdf">HMMER User's Guide</a></li>
		</ol>
                    <?
                        if ($_GET["e10"]){
                            print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[10] . "</span>";
                        }
                        if ($_GET["e11"]){
                            print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[11] . "</span>";
                        }
                        if ($_GET["e14"]){
                            print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[14] . "</span>";
                        }            
                    ?>
	</div>

	<div class="box">
		<div class="boxTitle">
			Sequence Type:
		</div>

		<div class="boxLabel">
			<div class="leftLabel">
				Sequence Type:
			</div>

			<select class="small hashelp" id="Web:hmmbuild_seqtype" name="seqtype" onclick="setMatrix();">
				<option value="protein" <?if($_GET['type']=='blastp'){print "selected=\"SELECTED\"";}?>>protein</option>
				<option value="dna" <?if($_GET['type']=='blastn'){print "selected=\"SELECTED\"";}?>>dna</option>
 			</select>
		</div>
	</div>

	<div class="box">
		<div class="boxTitle">
			HMMBuild Options:
		</div>

		<div class="boxLabel">
			<div class="leftLabel">
				Alginment:
			</div>

			<select class="small hashelp" id="Web:hmmbuild_alignment" name="alignment">
				<option value="default">domain alignment</option>
				<option value="-f">multi-hit local</option>
				<option value="-g">global alignment</option>
				<option value="-s">local alignment</option> <? /* Smith/Waterman */?>
			</select>
		</div>

		<div class="boxLabel">
			<div class="leftLabel">
				Weighting Algorithm:
			</div>

			<select class="small hashelp" id="Web:hmmbuild_algorithm" name="algorithm">
				<option value="gsc">GSC</option>
				<option value="blosum">BLOSUM</option>
				<option value="me">Krogh/Mitchison</option>
				<option value="pb">Henikoff</option>
				<option value="voronoi">Voronoi</option>
				<option value="none">none</option>
			</select>
		</div>

		<div class="boxLabel">
			<div class="leftLabel">
				Calibrate for HMMSearch:
			</div>

			<input type="checkbox" name="calibrate" value="true" checked="true" onclick="toggle_div('hmmcalibrate');">
		</div>
	</div>

	<div id="hmmcalibrate">
		<div class="box">
			<div class="boxTitle">
				HMMCalibrate Options:
			</div>

			<div class="boxLabel">
				<div class="leftLabel">Random sequence length:</div>
				<input type="text" size="6" name="randomseqlength" class="small hashelp" value="default"/>
			</div>
	 
			<div class="boxLabel">
				<div class="leftLabel">Random seq length mean:</div>
				<input type="text" size="6" name="randomseqlengthmean" class="small hashelp" value="350"/>
			</div>

			<div class="boxLabel">
				<div class="leftLabel">Number of sampled seqs:</div>
				<input type="text" size="6" name="sampledseqs" class="small hashelp" value="5000"/>
			</div>

			<div class="boxLabel">
				<div class="leftLabel">Random seq length std. dev:</div>
				<input type="text" size="6" name="randomseqlengthstddev" class="small hashelp" value="350"/>
			</div>

			<div class="boxLabel">
				<div class="leftLabel">Random seed:</div>
				<input type="text" size="6" name="randomseed" class="small hashelp" value="default"/>
			</div>
		</div>
	</div>

</div>

<div id="rightColumn" style="float:right; clear:none; width:480px;">
	<div class="box">
		<div class="boxTitle">
			Input Multiple Sequence Alignment:
		</div>
		<?
		if ($_GET["e5"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[5] . "</span>";
		}
		if ($_GET["e7"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[7] . "</span>";
		}	
		if ($_GET["e8"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[8] . "</span>";
		}
		if ($_GET["e9"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[9] . "</span>";
		}
		if ($_GET["e12"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[12] . "</span>";
		}
		if ($_GET["e13"]){
			print "<span style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[13] . "</span>";
		}
		?>

		<p><b>Upload a file:</b>
		<div class="boxLabel">
			<div class="boxTitle"></div>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?=$MAX_INPUT_SIZE;?>"/>
			<input size="30" type="file" class="small hashelp" name="input_file" id="Web:hmmbuild_upload"/>
		</div>

		<p><span style="font-weight:bold;">OR</span><br/>
		<b>Paste in multiple sequence alignment:</b><br/>
		<textarea class="hashelp" id="Web:hmmbuild_paste" name="input_sequence" cols="60" rows="20" style="font-family:Courier New; font-size:11px;"><? 
	 			if( isset($_GET['clustal_results_id']) ) {
					$results = Jobs::getResults($_GET["clustal_results_id"], "ClustalW");
					print trim($results->parsedResults(),"\r\n");
				} 
							?></textarea>
	</div>

	<div class="box">
		<?
		if ($_GET["e6"]){
			print "<span height=\"20\" style=\"color:red;font-weight:bold;\">" . $hmmbuild_errors[6] . "</span>";
		}
 		?>

		<div class="boxTitle">
			Job Control:
		</div>

		<div class="boxLabel">
			<div class="leftText">
				Submit your HMMBUILD job
			</div>

			<div class="rightText">
				<input type="submit" name="submit_hmmbuild" value="Submit HMMBUILD Job" class="small hashelp" id="Web:hmmbuild_submit"/>
			</div>
		</div>

		<div class="boxLabel">
			<div class="leftText">Retrieve a previously run HMMBUILD job</div>

			<div class="rightText">
				<input type="text" size="10" name="job_id" class="small" value="Enter Job ID" onfocus="if(this.value=='Enter Job ID')this.value='';"/>
				&nbsp;&nbsp;&bull;&nbsp;&nbsp;
				<input name="get_hmmbuild" type="submit" value="Retrieve HMMBUILD Job" class="small hashelp" id="Web:hmmbuild_retrieve"/></div>
		</div>
	</div>
</div>


</form>

