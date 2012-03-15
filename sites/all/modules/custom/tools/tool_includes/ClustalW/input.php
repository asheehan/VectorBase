<?
ini_set("include_path",(".:" . $_SERVER["DOCUMENT_ROOT"] . "includes"));
include("clustalw_errors.php");
include_once("Jobs.php");
include_once("blast_results.php");
?>
<script language="JavaScript" type="text/javascript">
<!--
	// dna/protein matrix 
	function matrixCheck(){
		var seqType = document.getElementById('Web:ClustalW#sequence_type');
		if (seqType.value == 'protein') {
			document.getElementById('Web:ClustalW#dna_matrixli').style.display='none';
			document.getElementById('Web:ClustalW#dna_matrixli').disabled=true;
			document.getElementById('Web:ClustalW#pw_matrixli').style.display='block';
			document.getElementById('Web:ClustalW#pw_matrixli').disabled=false;
		}else{
			document.getElementById('Web:ClustalW#dna_matrixli').style.display='block';
			document.getElementById('Web:ClustalW#dna_matrixli').disabled=false;
			document.getElementById('Web:ClustalW#pw_matrixli').style.display='none';
			document.getElementById('Web:ClustalW#pw_matrixli').disabled=true;
		}

	}

	function enforce_param_constraints() {
		var align = document.getElementById('Web:ClustalW#alignment_method');
		if (align.value == 'full') {
			document.getElementById('Web:ClustalW#ktupleli').style.display='block';
			document.getElementById('Web:ClustalW#window_lengthli').style.display='block';
			document.getElementById('Web:ClustalW#score_typeli').style.display='block';
			document.getElementById('Web:ClustalW#top_diagonalsli').style.display='block';
			document.getElementById('Web:ClustalW#gap_penaltyli').style.display='block';

		} else {
			document.getElementById('Web:ClustalW#ktupleli').style.display='none';
			document.getElementById('Web:ClustalW#window_lengthli').style.display='none';
			document.getElementById('Web:ClustalW#score_typeli').style.display='none';
			document.getElementById('Web:ClustalW#top_diagonalsli').style.display='none';
			document.getElementById('Web:ClustalW#gap_penaltyli').style.display='none';
		}
	}
-->
</script>
<form method="post" enctype="multipart/form-data" action="http://<? echo $_SERVER["HTTP_HOST"]; ?>/sections/Tools/tool_includes/ClustalW/submit.php" name="clustalw_input_form">
<div id="leftColumn" style="float:left; clear:none; width:270px;">
<!--
	<div class="jobBox">
		<h1>Directions</h1>
		    <ol>
		    	<li>Paste or upload sequences.</li>
			<li>Select protein or dna sequences.</li>
		    	<li><i>Optional:</i> Set additional ClustalW parameters.</li>
		    	<li>Submit your ClustalW job.</li>
		    </ol>
		<?
			if ($_GET["e10"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[10] . "</span>";
			}
			if ($_GET["e11"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[11] . "</span>";
			}
			if ($_GET["e14"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[14] . "</span";
			}            
		?>
	</div>
-->
	<div class="jobBox">
		<h1>Sequence Type</h1>
			<ul>
			<li id="Web:ClustalW#sequence_typeli"><label class="clustalLabel" for="sequence_type">Sequence Type</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#sequence_type" name="seqtype" onclick="matrixCheck();">
					<option value="dna" <?if (($_GET['type']=='blastn')||($_GET["type"]=="tblastn")||($_GET["type"]=="tblastx")){print "selected=\"SELECTED\"";}?>>dna</option>
					<option value="protein" <?if (($_GET['type']=='blastp')||($_GET["type"]=="blastx")){print "selected=\"SELECTED\"";}?>>protein</option>
				</select>
			</li>
			</ul>
	</div>

	<div class="jobBox" style="margin-bottom:10px;">
		<h1>Options</h1>
			<ul>
			<li class="underLined" id="Web:ClustalW#alignment_methodli"><label class="clustalLabel" for="alignment">Alignment</label>
				<select class="jobSmall hashelp" name="alignment" id="Web:ClustalW#alignment_method" onclick="enforce_param_constraints();">
					<option value="full">full</option>
					<option value="fast">fast</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#dna_matrixli"><label class="clustalLabel" for="dna_matrix">DNA Matrix</label>
				<select class="jobSmall hashelp"  id="Web:ClustalW#dna_matrix" name="dna_matrix">
					<option value="IUB"<?if($_GET['type'] == 'blastn'){print " selected=\"SELECTED\"";}?>>IUB</option>
					<option value="ID">Identity</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#pw_matrixli"><label class="clustalLabel" for="pw_matrix">Protein Weight Matrix</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#pw_matrix" name="pw_matrix">
					<option value="GONNET"<?if($_GET['type'] == 'blastp'){print " selected=\"SELECTED\"";}?>>GONNET</option>
					<option value="BLOSUM">BLOSUM</option>
					<option value="PAM">PAM</option>
					<option value="ID">Identity</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#open_gap_penaltyli"><label class="clustalLabel" for="opengap">Open Gap Penalty</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#open_gap_penalty" name="opengap">
					<option value="default">default</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#end_gap_penaltyli"><label class="clustalLabel" for="endgap">End Gap Penalty</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#end_gap_penalty" name="endgap">
					<option value="default">default</option>
					<option value="10">10</option>
					<option value="20">20</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#gap_extension_penaltyli"><label class="clustalLabel" for="extgap">Gap Extension Penalty</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#gap_extension_penalty" name="extgap">
					<option value="default" selected="selected">default</option> 
					<option value="0.05">0.05</option> 
					<option value="0.5">0.5</option> 
					<option value="1.0">1.0</option>  
					<option value="2.5">2.5</option>
					<option value="5.0">5.0</option>    
					<option value="7.5">7.5</option>  
					<option value="10.0">10.0</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#gap_separation_penaltyli"><label class="clustalLabel" for="sepgap">Gap Separation Penalty</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#gap_separation_penalty" name="sepgap">
					<option value="default">default</option>
					<option value="10">10</option>
					<option value="9">9</option>
					<option value="8">8</option>
					<option value="7">7</option>
					<option value="6">6</option>
					<option value="5">5</option>
					<option value="4">4</option>
					<option value="3">3</option>
					<option value="2">2</option>
					<option value="1">1</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#gap_penaltyli"><label class="clustalLabel" for="gpenalty">Gap Penalty</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#gap_penalty" name="gpenalty">
					<option value="default">default</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="250">250</option>
					<option value="500">500</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#ktupleli"><label class="clustalLabel" for="ktuple">kTuple (Word Size)</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#ktuple" name="ktuple">
					<option value="default">default</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#window_lengthli"><label class="clustalLabel" for="wlength">Window Length</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#window_length" name="wlength">
					<option value="default">default</option>
					<option value="10">10</option>
					<option value="9">9</option>
					<option value="8">8</option>
					<option value="7">7</option>
					<option value="6">6</option>
					<option value="5">5</option>
					<option value="4">4</option>
					<option value="3">3</option>
					<option value="2">2</option>
					<option value="1">1</option>
					<option value="0">0</option>
				</select>
			</li>
			<li class="underLined"  id="Web:ClustalW#score_typeli"><label class="clustalLabel" for="score">Score Type</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#score_type" name="score">
					<option value="percent">percent</option>
					<option value="absolute">absolute</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#top_diagonalsli"><label class="clustalLabel" for="tdiag">Top Diagonals</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#top_diagonals" name="tdiag">
					<option value="default">default</option>
					<option value="10">10</option>
					<option value="9">9</option>
					<option value="8">8</option>
					<option value="7">7</option>
					<option value="6">6</option>
					<option value="5">5</option>
					<option value="4">4</option>
					<option value="3">3</option>
					<option value="2">2</option>
					<option value="1">1</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#outputli"><label class="clustalLabel" for="output">Output Format</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#output" name="output">
					<option value="default">aln</option>
					<option value="gcg">gcg MSF</option>
					<option value="gde">gde</option>
					<option value="pir">pir</option>
					<option value="phylip">phylip</option>
					<option value="nexus">nexus</option>
				</select>
			</li>
			<li class="underLined" id="Web:ClustalW#orderli"><label class="clustalLabel" for="order">Output Order</label>
				<select class="jobSmall hashelp" id="Web:ClustalW#order" name="order">
					<option value="aligned" selected="selected">aligned</option>
					<option value="input">input</option>
				</select>
			</li>
			</ul>
	</div>
</div>


<div id="rightColumn" style="float:left; clear:none;">
	<div class="jobBox">
		<h1>Input Sequences (100Kb / 100 Sequence Limit)</h1>
<div style="width:410px; margin:10px 10px; border:1px solid #888a00; background-color:#c3c517; font:bold 10px Sans-serif; padding:4px 8px;">
Beware of fasta sequence names. ClustalW will not read sequence header text enclosed in parentheses. Therefore if 2+ sequences are to be alligned and have identical sequence names except
for the segments enclosed in parentheses, ClustalW will refuse to align the sequences, producing erroneous results.
</div>

		<?	
			if ($_GET["e5"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[5] . "</span>";
			}
			if ($_GET["e7"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[7] . "</span>";
			}	
			if ($_GET["e8"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[8] . "</span>";
			}
			if ($_GET["e9"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[9] . "</span>";
			}
			if ($_GET["e12"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[12] . "</span>";
			}
			if ($_GET["e13"]){
				print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[13] . "</span>";
			}
		?>
		<b>Upload a file:</b>
			<div class="boxLabel">
				<div class="boxTitle"></div>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?=$MAX_INPUT_SIZE;?>"/>
				<input size="50" type="file" class="small hashelp" id="Web:ClustalW#upload_input_sequences" name="input_file" onClick="document.getElementById('Web:ClustalW#paste_input_sequences').value='';"/>	
			</div>

			<span style="font-weight:bold;">OR</span>
			<span style="margin-left:8px;"><b>Paste in sequences in FASTA format</b></span>
<? //need to do some regex to make sure there are no spaces in sequence names or clustal will bomb
?>
			<textarea class="hashelp" id="Web:ClustalW#paste_input_sequences" name="input_sequence" cols="61" rows="20" style="font-family:Courier New; font-size:11px;"  onfocus="if(this.value=='>Example1\nCGGTCTATTTGGGGATCGAACCCATGACGGGCATGTTGTTAAGTCGTA\n>Example2\nCGGTCTATTTGGGGATTGAACCCATGACGGGCATGTTGTTAAGTCGTA\n>Example3\nCGGTCTATTTGGGGATTTTACCCATGACGGGCATGTTGTTAAGTCGTA')this.value='';"><?
				if($_GET['blast_id']){
					$result = getResult($_GET['blast_id'], $_GET['resNum'], DB::getJOB_DB());
					foreach($result->getHits() as $hit){
						if($_GET[$hit->getId() . 'n0'] == "on"){
							$hsp = $hit->getHsps();
							echo ">".$hit->getName();
							//remove all dashes from sequence
							echo "\n".strtoupper(str_replace("-","",$hsp[0]->getHitString()))."\n";
						}
					}
				}else{
					echo ">Example1\nCGGTCTATTTGGGGATCGAACCCATGACGGGCATGTTGTTAAGTCGTA\n>Example2\nCGGTCTATTTGGGGATTGAACCCATGACGGGCATGTTGTTAAGTCGTA\n>Example3\nCGGTCTATTTGGGGATTTTACCCATGACGGGCATGTTGTTAAGTCGTA";
				}?></textarea>
	</div>

	<div class="jobBox" style="float:left; clear:both; width:97%;">
		<h1>Job Control</h1>
		            <?
		                if ($_GET["e6"]){
		                    print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[6] . "</span>";
		                }
		                if ($_GET["e15"]){
		                    print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[15] . "</span>";
		                }
		                if ($_GET["e16"]){
		                    print "<span style=\"color:red;font-weight:bold;\">" . $clustalw_errors[16] . "</span>";
		                }
		            ?>
		<input type="text" size="20" name="job_id" class="jobSmall" style="float:left; margin:8px;" value="<? if($_GET['jobId']) echo $_GET['jobId']; else echo 'Retrieve ClustalW Job ID';?>" onfocus="if(this.value=='Retrieve ClustalW Job ID')this.value='';"/>
		<input type="submit" name="submit_clustalw" value="Submit ClustalW Job" class="small hashelp" id="Web:ClustalW#submit_clustalw_job" style="float:right; margin:8px;"/>
	</div>
</div>
</form>
<script>
enforce_param_constraints();
matrixCheck();
</script>
<?
function getResult($job_id, $res_id, $db){
	$query = "select hash from blast_hashes where blast_id = " . $job_id . " and result_id = " . $res_id;
	$rs = pg_query($db,$query);
	$row = pg_fetch_assoc($rs);
	return unserialize(pg_unescape_bytea(stripslashes($row['hash'])));
}
?>
