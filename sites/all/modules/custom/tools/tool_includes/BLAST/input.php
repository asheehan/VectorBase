<?
	$BLAST_FORM_NAME="blast_input_form";
	include("blast_errors.php");
	//include_once("organism_definitions.php");
	//include_once("db_connect.php");
	//blast_programs.php
	$blast_programs["blastn"]="Nucleotide vs. Nucleotide";
	$blast_programs["tblastn"]="Peptide vs. Translated Nucleotide";
	$blast_programs["tblastx"]="Translated Nucleotide vs. Translated Nucleotide";
	$blast_programs["blastp"]="Peptide vs. Peptide";
	$blast_programs["blastx"]="Translated Nucleotide vs. Peptide";

  print "starting...<br />";

//this needs to grab the associated ids and their params
	if($_GET['blast_id']){
          $job_query = "select * from job_params where job_id = " . $_GET['blast_id'];
          $job_rs = pg_query(DB::getJOB_DB(), $job_query);
          $redoDatabases = array();
          while($job_row = pg_fetch_assoc($job_rs)){
//var_dump($job_row["argument"]);
            if($job_row["argument"] == "sequence"){
              $redoSequence = $job_row['value'];
            }
            elseif($job_row["argument"] == "program"){
              $redoProgram = $job_row['value'];
            }
            elseif($job_row["argument"] == "target_database"){
              array_push($redoDatabases, $job_row['value']);
            }
            elseif($job_row['argument'] == "wordsize"){
              $redoWordsize = $job_row['value'];
            }
            elseif($job_row['argument'] == "numhits_oneline"){
              $redoNumhits_oneline = $job_row['value'];
            }
            elseif($job_row['argument'] == "numhits_align"){
              $redoNumhits_align = $job_row['value'];
            }
            elseif($job_row['argument'] == "evalue"){
              $redoEvalue = $job_row['value'];
            }
            elseif($job_row['argument'] == "scoringmatrix"){
              $redoScoringmatrix = $job_row['value'];
            }
            elseif($job_row['argument'] == "masking"){
              $redoMasking = $job_row['value'];
            }
          }
        }

?>

JavaScript...<br />

<script language="JavaScript" type="text/javascript">
	<!--
		var http_request = false;
		var response = '';
		var jobId = '';
		var selectedOrganism='';
		var detailEST=false;

		//auto sets wordsize to 11 for blastn, 3 for anything else
		function setWordSize(blast_program){
			if (blast_program == 'blastn'){
				document.<?=$BLAST_FORM_NAME;?>.wordsize.selectedIndex = 4;
			} else {
				document.<?=$BLAST_FORM_NAME;?>.wordsize.selectedIndex = 0;
			}
		}
		// set low complexity masking off for blastp
		function setLowComplexity(blast_program){
			if (blast_program == 'blastp'){
				document.<?=$BLAST_FORM_NAME;?>.dust.selectedIndex = 1;
			} else {
				document.<?=$BLAST_FORM_NAME;?>.dust.selectedIndex = 0;
			}
		}

		function wordSizeCheck(){
			if(getSelectedBlastProgram()=='blastn' && document.<?=$BLAST_FORM_NAME;?>.wordsize.options[0].selected){
				document.<?=$BLAST_FORM_NAME;?>.wordsize.selectedIndex = 1;
				alert("Word Size must be at least 5 for nucleotide searches");
			}
			if((getSelectedBlastProgram()=='tblastn' || getSelectedBlastProgram()=='blastp' || getSelectedBlastProgram()=='blastx') && (document.<?=$BLAST_FORM_NAME;?>.wordsize.options[3].selected || document.<?=$BLAST_FORM_NAME;?>.wordsize.options[4].selected || document.<?=$BLAST_FORM_NAME;?>.wordsize.options[5].selected || document.<?=$BLAST_FORM_NAME;?>.wordsize.options[6].selected || document.<?=$BLAST_FORM_NAME;?>.wordsize.options[7].selected)){
				document.<?=$BLAST_FORM_NAME;?>.wordsize.selectedIndex = 2;
				alert("Word Size must be 7 or less for this program");
			}
		}

		// disable the other and est datasets option for peptide searches
		function setEstOtherDataset(blast_program){
			var output = '';
			if (blast_program == 'blastp' || blast_program == 'blastx'){
				document.getElementById("other_checkbox").checked=false;
				document.getElementById("other_checkbox").disabled=true;
				document.getElementById("otherLabel").style.color="Grey";
				document.getElementById("est_checkbox").checked=false;
				document.getElementById("est_checkbox").disabled=true;
				document.getElementById("est_standard").checked=false;
				document.getElementById("est_standard").disabled=true;
				document.getElementById("est_detailed").checked=false;
				document.getElementById("est_detailed").disabled=true;
				document.getElementById("estLabel").style.color="Grey";
				output=false;
			}else{
				document.getElementById("other_checkbox").disabled=false;
				document.getElementById("otherLabel").style.color="#<?=DV::$BLASTOCS["llongipalpis"][0];?>";
				document.getElementById("est_checkbox").disabled=false;
				document.getElementById("estLabel").style.color="#<?=DV::$BLASTOCS["llongipalpis"][0];?>";
				document.getElementById("est_standard").disabled=false;
				document.getElementById("est_detailed").disabled=false;

				//include other and est datasets if select all is checked and a peptide search is not selected
				if(document.getElementById("all_checkbox").checked==true) {
					document.getElementById("other_checkbox").checked=true;
					document.getElementById("est_checkbox").checked=true;
				}


				if(document.getElementById("est_detailed").checked==true){
					document.getElementById("other_checkbox").checked=false;
					document.getElementById("other_checkbox").disabled=true;
				}

				output=true;

			}
			return output;
		}

		// look at all datasets, if set is checked select all appropriate (nuc or pep) dbs for that set and blast program type combination
		function selectDatasetDBs(blast_program){
			var datasets = document.getElementsByName("datasets[]");
			for(var i=0; i<datasets.length;i++) {

				var pepSet = document.getElementsByName("pepdbs['"+datasets[i].value+"'][]");
				var nucSet = document.getElementsByName("nucdbs['"+datasets[i].value+"'][]");
				var traceSet = document.getElementsByName("tracedbs['"+datasets[i].value+"'][]");

				//if it's checked then at least one db is selected
				if (datasets[i].checked==true){
					if (blast_program == 'blastp' || blast_program == 'blastx'){
						//select pep dbs
						for(var j=0; j<pepSet.length; j++){
							pepSet[j].checked=true;
							pepSet[j].disabled=false;
						}
						//deselect and deactivate nuc dbs
						for(var j=0; j<nucSet.length; j++){
							nucSet[j].checked=false;
							nucSet[j].disabled=true;
						}
						//deselect and deactivate trace dbs
						for(var j=0; j<traceSet.length; j++){
							traceSet[j].checked=false;
							traceSet[j].disabled=true;
						}

					}else{
						//select nuc dbs
						for(var j=0; j<nucSet.length; j++){
							nucSet[j].checked=true;
							nucSet[j].disabled=false;
						}
						//activate trace dbs
						for(var j=0; j<traceSet.length; j++){
							traceSet[j].disabled=false;
						}
						//deselect and deactivate pep dbs
						for(var j=0; j<pepSet.length; j++){
							pepSet[j].checked=false;
							pepSet[j].disabled=true;
						}
					}
				}else{
				//display correct databases but don't check anything
					if (blast_program == 'blastp' || blast_program == 'blastx'){
						//select pep dbs
						for(var j=0; j<pepSet.length; j++){
							pepSet[j].disabled=false;
						}
						//deselect and deactivate nuc dbs
						for(var j=0; j<nucSet.length; j++){
							nucSet[j].disabled=true;
						}
						for(var j=0; j<traceSet.length; j++){
							traceSet[j].disabled=true;
						}

					}else{
						//select nuc dbs
						for(var j=0; j<nucSet.length; j++){
							nucSet[j].disabled=false;
						}
						for(var j=0; j<traceSet.length; j++){
							traceSet[j].disabled=false;
						}
						//deselect and deactivate pep dbs
						for(var j=0; j<pepSet.length; j++){
							pepSet[j].disabled=true;
						}
					}
				}
			}
		}



		//these run when a blast program is selected
		function blastProgramChecks(){
			var blastProgram=getSelectedBlastProgram();

			//user has selected a detailed search that disabled all datasets. if peptide search program is selected we need to enable the datasets
			if(document.getElementById("est_detailed").checked==true && (blastProgram=='blastp' || blastProgram=='blastx')){
				document.getElementById("agambiae_checkbox").disabled=false;
				document.getElementById("aaegypti_checkbox").disabled=false;
				document.getElementById("iscapularis_checkbox").disabled=false;
				document.getElementById("cquinquefasciatus_checkbox").disabled=false;
				document.getElementById("phumanus_checkbox").disabled=false;
				document.getElementById("all_checkbox").disabled=false;
			}

			setWordSize(blastProgram);
			setLowComplexity(blastProgram);
			selectDatasetDBs(blastProgram);
			setEstOtherDataset(blastProgram);
			//wordSizeCheck();	wordsize is being auto set by function above. shouldn't have to check it here
		}

		function getSelectedBlastProgram(){
			var blastPrograms = document.getElementsByName('program');
			for(var i=0; i<blastPrograms.length; i++){
				if (blastPrograms[i].checked==true){
					var selectedProgram = blastPrograms[i].value;
				}
			}
			return selectedProgram;
		}

		function uncheckAllDBs(){
			var datasets = document.getElementsByName("datasets[]");
			for(var i=0; i<datasets.length;i++) {
				var pepSet = document.getElementsByName("pepdbs['"+datasets[i].value+"'][]");
				var nucSet = document.getElementsByName("nucdbs['"+datasets[i].value+"'][]");
				var traceSet = document.getElementsByName("tracedbs['"+datasets[i].value+"'][]");

				for(var  j=0;j<nucSet.length;j++) {
					nucSet[j].checked=false;
				}

				for(var j=0;j<pepSet.length;j++) {
						pepSet[j].checked=false;
				}

				for(var j=0;j<traceSet.length;j++) {
						traceSet[j].checked=false;
				}
			}
		}

		//this is the toggle for the select/unselect all
		function toggleAllDatasets(){
			var sets = document.getElementsByName("datasets[]");
			if(document.getElementById("all_checkbox").checked==true ){
				for(var i=0;i<sets.length;i++) {
					document.getElementsByName("datasets[]")[i].checked=true;
					// if a peptide program is selected, don't select the other or est sets
					if(document.getElementsByName("program")[3].checked==true || document.getElementsByName("program")[4].checked==true){
						if(document.getElementsByName("datasets[]")[i].value=='other' || document.getElementsByName("datasets[]")[i].value=='est'){
							document.getElementsByName("datasets[]")[i].checked = false;
						}
					}
				}
				//now select all the dbs for the set
				selectDatasetDBs(getSelectedBlastProgram());

			}else{
				for(var i=0;i<sets.length;i++) {
					document.getElementsByName("datasets[]")[i].checked=false;
				}
				uncheckAllDBs();

			}
		}

		function validateFormOnSubmit(theForm) {
			var reason = "";
			var result = false;
			var errorColor="#fe6969"
			wordSizeCheck();

			//reset the fasta background to white
			//if(theForm.job_id.value=="Retrieve BLAST Job ID" || theForm.job_id.value==""){
			//	theForm.job_id.style.background = 'White';
			//	theForm.input_sequence.style.background = errorColor;
			//}

			//user has entered data in job_id field and is trying to retrieve a job, doesn't need a db or fasta sequence
			if( theForm.job_id.value!="Retrieve BLAST Job ID" && theForm.job_id.value!=""){
				if (isNaN(theForm.job_id.value)) {
					theForm.job_id.style.background = errorColor;
					reason = "Job ID contains illegal characters\n"
				}else{
					theForm.job_id.style.background = "white";
				}

			//user is submitting a job, check fasta syntax and ensure at least 1 db is selected
			}else{
				//check fasta
				var numberOfQueries = 0;
				if(theForm.input_sequence.value.match(/(>)/gm) != null ){
					numberOfQueries = theForm.input_sequence.value.match(/(>)/gm).length;
				}

				//no query
				if(theForm.input_sequence.value=="") {
					reason += "<li>Enter a query sequence</li>";
					theForm.input_sequence.style.background = errorColor;

				//too many queries
				}else if(numberOfQueries > 20 ) {
					reason += "<li>The maximum number of query sequences is twenty.</li>";
					theForm.input_sequence.style.background = errorColor;

				//this is the case for a user entering a single query sequence with no >sequence name
				}else if( theForm.input_sequence.value.match(/([ARNDCEQGHILKMFPSTWYVN\-]+)/gim)!=null && numberOfQueries==0 ) {
					theForm.input_sequence.style.background = 'White';
					theForm.input_sequence.value= ">Untitled Query Sequence\n" + theForm.input_sequence.value;

				//bad fasta sequence
				}else if( theForm.input_sequence.value.match(/^[\n|\r]*(?:>[^\n\r]*[\n|\r]+[ARNDCEQGHILKMFPSTWYVN\-\n\r]+)+$/i) == null ) {
					reason +=  "<li>Input query must be in FASTA format</li>";
					theForm.input_sequence.style.background = errorColor;
				}

				//check for at least one database selected
				var total=0;
				var datasets = document.getElementsByName("datasets[]");
				for(var i=0; i<datasets.length; i++) {
					var pepSet = document.getElementsByName("pepdbs['"+datasets[i].value+"'][]");
					var nucSet = document.getElementsByName("nucdbs['"+datasets[i].value+"'][]");
					var traceSet = document.getElementsByName("tracedbs['"+datasets[i].value+"'][]");

					for(var j=0; j<pepSet.length; j++){
						if(pepSet[j].checked==true){
							total++;
						}
					}
					for(var j=0; j<nucSet.length; j++){
						if(nucSet[j].checked==true){
							total++;
						}
					}
					for(var j=0; j<traceSet.length; j++){
						if(traceSet[j].checked==true){
							total++;
						}
					}
				}
				//separate check for est dbs
				if(document.getElementById('est_checkbox').checked == true){ total++;}

				var ds1 = document.getElementById("datasetsDiv");
				if(total==0){
					ds1.style.borderColor = errorColor;
					ds1.style.borderWidth = 'medium';
					reason += "<li>Select at least one database</li>";
				}else{
					ds1.style.borderColor = <? echo '\'#'.DV::$BLASTOCS[$_SESSION["organism_id"]][5].'\'';?>;
					ds1.style.borderWidth = 'thin';
				}
			}

			//now check to see if there were errors
			if(reason!=""){
				document.getElementById("errorBox").innerHTML='<ul class="errorList">' + reason + '</ul>';
				return false;
			}
			else {
				theForm.input_sequence.style.background = 'White';
				theForm.job_id.style.background = 'White';
				document.getElementById("errorBox").innerHTML='';
				return true;
			}

		}

		function submitBLAST(){
			//pinwheel cursor
			document.getElementById('blastForm').style.cursor='progress';

			//disable button
			document.getElementById('Web:Misc_Help#submit').disabled=true;
			document.getElementById('Web:Misc_Help#submit').value="Running";

			// is user looking up old job?
			if( document.<?=$BLAST_FORM_NAME;?>.job_id.value!="Retrieve BLAST Job ID" && document.<?=$BLAST_FORM_NAME;?>.job_id.value!=""){
				jobId = document.<?=$BLAST_FORM_NAME;?>.job_id.value;
				document.getElementById('jobActivity').innerHTML = '<div class="jobBox" style="clear:both;"><h3>Retrieving Job '+jobId+' Information</h3></div>';
				makeRequest('/sections/Tools/tool_includes/BLAST/processing.php', '?job_id='+jobId, 'GET');
			} else { //user is submitting a new job

				//update the status/results div
				document.getElementById('jobActivity').innerHTML = '<div class="jobBox" style="clear:both; width:98%;"><h3>Submitting Job</h3></div>';

				//clear the results link so users aren't confused
				document.getElementById('jobResultsLink').innerHTML = '';

				//start submit process
				makeRequest('/sections/Tools/tool_includes/BLAST/submit.php', getSubmitParams(), 'POST');
			}
		}

		//build submit string
		function getSubmitParams() {
			var getstr = "";//"?";
			var j=0;
			var programs = document.getElementsByName("program");		      
			for(var i=0;i<programs.length;i++) {
				if(programs[i].checked==true){
					getstr +="program=" + programs[i].value + "&";
				}
			}

			var k=0;
			var datasets = document.getElementsByName("datasets[]");
			for(var i=0; i<datasets.length; i++) {
				var pepSet = document.getElementsByName("pepdbs['"+datasets[i].value+"'][]");
				var nucSet = document.getElementsByName("nucdbs['"+datasets[i].value+"'][]");
				var traceSet = document.getElementsByName("tracedbs['"+datasets[i].value+"'][]");

				for(var j=0; j<pepSet.length; j++){
					if(pepSet[j].checked==true){
						getstr +="blastdbs[" + k + "]=" + pepSet[j].value + "&";
						k++;
					}
				}

				for(var j=0; j<nucSet.length; j++){
					if(nucSet[j].checked==true){
						getstr +="blastdbs[" + k + "]=" + nucSet[j].value + "&";
						k++;
					}
				}

				for(var j=0; j<traceSet.length; j++){
					if(traceSet[j].checked==true){
						getstr +="blastdbs[" + k + "]=" + traceSet[j].value + "&";
						k++;
					}
				}

			}

			//special vars for est searches
			if(document.getElementById('est_checkbox').checked == true && document.getElementById('est_detailed').checked == true) {
				getstr +="detailed_est=true&";
			}else if(document.getElementById('est_checkbox').checked == true && document.getElementById('est_standard').checked == true) {
				getstr +="standard_est=true&";
			}

			// new lines are getting dropped from the input sequence, we need to fix that. adding Z-z-Z string as place holder that submit.php will use to reinsert new lines
			var sequence = document.getElementsByName("input_sequence")[0].value;
			var newseq = sequence.replace(new RegExp('\\n',"g"), 'Z-z-Z');

			getstr += "evalue=" + document.getElementsByName("evalue")[0].value + "&";
			getstr += "wordsize=" + document.getElementsByName("wordsize")[0].value + "&";
			getstr += "scoringmatrix=" + document.getElementsByName("scoringmatrix")[0].value + "&";
			getstr += "dust=" + document.getElementsByName("dust")[0].value + "&";
			getstr += "num_results=" + document.getElementsByName("num_results")[0].value + "&";
			getstr += "input_sequence=" + newseq;

			return getstr;
		   }


		   function makeRequest(url,params,openMethod) { //openMethod is POST,GET, or HEAD
			if (window.XMLHttpRequest) { // Mozilla, Safari, IE7+...
				http_request = new XMLHttpRequest();
			}else if (window.ActiveXObject) {
				try{
					http_request = new ActiveXObject("Msxml2.XMLHTTP");
				}catch(e) {
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} 
			}

			if (!http_request) {
				alert('Cannot create XMLHTTP instance, upgrade to a newer browser.');
				return false;
			}

			http_request.onreadystatechange = function () {
				if (http_request.readyState == 4) {
					if(http_request.status == 200) {
						response = http_request.responseText;
						analyzeResponse(response);
					}else{
						//alert('Unexpected response from server:\n"'+http_request.responseText+'"\nreadyState: '+http_request.readyState+'\nstatus: '+http_request.status);
						//unpinwheel cursor
						document.getElementById('blastForm').style.cursor='default';
						//enable button
						document.getElementById('Web:Misc_Help#submit').disabled=false;
						document.getElementById('Web:Misc_Help#submit').value="BLAST!";
						//update the status/results div
						document.getElementById('jobActivity').innerHTML = '';
						//clear the results link so users aren't confused
						document.getElementById('jobResultsLink').innerHTML = '';
					}
				}
 			};

			if(openMethod=='GET'){
				http_request.open(openMethod, url+params, true);
				http_request.send(null);
			}else{
				http_request.open(openMethod, url+'?'+params, true);
				http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http_request.setRequestHeader("Content-length", params.length);
				http_request.setRequestHeader("Connection", "close");
				http_request.send(params);
			}

		   }

		function returnOneSubstring(regex,input){
			regex.exec(input);
			return RegExp.$1;
		}

		   function analyzeResponse(response) {
			//if only numbers are returned it's the job id
//alert(response);
			if( !isNaN(response) ){
				jobId = response;
				document.getElementById('jobActivity').innerHTML = '<div class="jobBox" style="clear:both;"><h3>Retrieving Job '+jobId+' Information</h3></div>';
				makeRequest('/sections/Tools/tool_includes/BLAST/processing.php', '?job_id='+jobId, 'GET');
			}
			//results are done, processing them and storing in the db...
			else if (response.match(/Retrieving results for job/gm)) {
				document.getElementById('jobActivity').innerHTML = '<div class="jobBox" style="clear:both;"><h3>Retrieving results for job '+jobId+'</h3></div>';

				//parse out all the job's input params. ps substring matching in js is ridiculous
				var program = returnOneSubstring(/program=(\w+)/m,response);
				var wordsize = returnOneSubstring(/wordsize=(\d+)/m,response);
				var numhits_oneline = returnOneSubstring(/numhits_oneline=(\d+)/m,response);
				var numhits_align = returnOneSubstring(/numhits_align=(\d+)/m,response);
				var evalue = returnOneSubstring(/evalue=([\w|\d|-]+)/m,response);
				var scoringmatrix = returnOneSubstring(/scoringmatrix=([\w|\d]+)/m,response);
				var masking = returnOneSubstring(/masking=(\w)/m,response);
				var sequence = returnOneSubstring(/sequence=((>.*\n[ARNDCEQGHILKMFPSTWYV|\n]+)+[\n]?)/m,response);
				var detailed_est = returnOneSubstring(/detailed_est=(\w+)###/m,response);
				var program_desc = returnOneSubstring(/programDesc=(.*)###/m,response);
				//var estdbs = returnOneSubstring(/estdbs=(\w+)/m,response);

				//set correct blast description
				document.getElementById('blastDescription').innerHTML=program + ' - ' + program_desc;


				// uncheck all databases
				uncheckAllDBs();
				// uncheck all datasets
				var datasets = document.getElementsByName("datasets[]");
				for(var i=0; i<datasets.length; i++) {
					document.getElementsByName("datasets[]")[i].disabled=false;
					document.getElementsByName("datasets[]")[i].checked=false;
				}
				document.getElementById("all_checkbox").disabled=false;
				document.getElementById("all_checkbox").checked=false;


				if(detailed_est=='true'){
					//check est dataset and select est_fancy radio button
					document.getElementById('est_detailed').checked=true;
					document.getElementById('est_checkbox').checked=true;
					//disabled everything else
					datasetDisplayToggle('est');
				}else{
					var temp=response.match(/target_database=(\d+)###/gm);
					if(temp){
						re=/target_database=(\d+)###/m
						for(i=0; i<temp.length; i++){
							re.exec(temp[i]);
							document.getElementById(RegExp.$1).checked=true;
						}	
					}

					temp=response.match(/target_dataset=(\w+)###/gm);
					if(temp){
						re=/target_dataset=(\w+)###/m
						for(i=0; i<temp.length; i++){
							re.exec(temp[i]);
							document.getElementById(RegExp.$1 + '_checkbox').checked=true;
						}	
					}

					if( response.match(/estdbs=true/gm) ){
						//traditional est search was selected, check est box and est radio button
						document.getElementById('est_checkbox').checked=true;
						document.getElementById('est_standard').checked=true;
					}
				}

				//update all the parameters to match the job being retrieved
				document.getElementById('Web:Misc_Help#paste').value=sequence;
				document.getElementById(program).checked=true;
				document.getElementById('Web:BLAST#maximum_e-value').value=evalue;
				document.getElementById('Web:BLAST#wordlength').value=wordsize;
				document.getElementById('Web:BLAST#scoring_matrix').value=scoringmatrix;
				document.getElementById('Web:BLAST#masking').value=masking;
				//document.getElementById('numhits_oneline').value=numhits_oneline;
				document.getElementById('Web:BLAST#number_of_results').value=numhits_align;

				selectDatasetDBs(getSelectedBlastProgram());
				setEstOtherDataset(getSelectedBlastProgram());

				if(detailed_est=='true'){
					makeRequest('/sections/Tools/tool_includes/BLAST/estResults.php','?job_id='+jobId, 'GET');
				}else {
					makeRequest('/sections/Tools/tool_includes/BLAST/results.php','?job_id='+jobId, 'GET');
				}

				//set this global variable
				detailEST=detailed_est;

			}
			//we've been forwarded to the results page, all done here
			else if(response.match(/Results/gm) && !response.match(/Retrieving results/gim) ){
				if(detailEST=='true'){
					document.getElementById('jobResultsLink').innerHTML = '<div style="float:right;padding-right:15px;"><a href="/Tools/BLAST/?estResult&job_id='+jobId+'" target="_blank">View results in a new window</a></div>';
				}else{
				document.getElementById('jobResultsLink').innerHTML = '<div style="float:right;padding-right:15px;"><a href="/Tools/BLAST/?job_id='+jobId+'" target="_blank">View results in a new window</a></div>';
				}
				document.getElementById('jobActivity').innerHTML = response;

				//unpinwheel cursor
				document.getElementById('blastForm').style.cursor='default';
				//enable button
				document.getElementById('Web:Misc_Help#submit').disabled=false;
				document.getElementById('Web:Misc_Help#submit').value="BLAST!";
				//reset detailEST
				detailEST=false;

			}
			//ugh oh, errors!
			else if (response.match(/error/gim) && !response.match(/Retrieving results/gim) ) { 
				document.getElementById('jobActivity').innerHTML = response;

				//unpinwheel cursor
				document.getElementById('blastForm').style.cursor='default';

				//enable button
				document.getElementById('Web:Misc_Help#submit').disabled=false;
				document.getElementById('Web:Misc_Help#submit').value="BLAST!";
			}
			//no results yet, keep waiting...
			else {	
				document.getElementById('jobActivity').innerHTML = response;
				makeRequest('/sections/Tools/tool_includes/BLAST/processing.php','?job_id='+jobId, 'GET');
			}
		}


		function checkEsts(){
			// est box needs to be checked when either of its radio buttons are clicked
			document.getElementById('est_checkbox').checked=true;

			//set some defaults for the detailed search
			if(document.getElementById("est_detailed").checked){
				document.<?=$BLAST_FORM_NAME;?>.dust.selectedIndex=1;
				document.<?=$BLAST_FORM_NAME;?>.evalue.selectedIndex=3;
			}

		}

		var activatedDataset='';
		function datasetDisplayToggle(organism){
			var dataset = document.getElementById((organism + '_databases'));
			document.getElementById('jobDatasetDescriptionHelp').innerHTML='';

			if(activatedDataset){ var datasetToDeactivate = document.getElementById((activatedDataset + '_databases')); }

			if (dataset.style.display=='none'){
				dataset.style.display='block';
				if(activatedDataset){ datasetToDeactivate.style.display='none'; }
				activatedDataset=organism;
			}

			//special case for ests
			if(organism=='est'){
				var sets = document.getElementsByName("datasets[]");

				//est box has been unchecked, activate all datasets
				if(document.getElementById("est_checkbox").checked==false){
					var sets = document.getElementsByName("datasets[]");
					for(var i=0;i<sets.length;i++) {
							document.getElementsByName("datasets[]")[i].disabled=false;
					}
					document.getElementById('all_checkbox').disabled=false;
					document.getElementById('est_standard').checked=true;
				}
				else if(document.getElementById('est_detailed').checked==true){
				//uncheck and deactivate all other datasets and select all
					for(var i=0;i<sets.length;i++) {
						if(document.getElementsByName("datasets[]")[i].value!="est") {
							document.getElementsByName("datasets[]")[i].checked=false;
							document.getElementsByName("datasets[]")[i].disabled=true;
						//needs to uncheck all dbs too
							var nucSet = document.getElementsByName("nucdbs['"+document.getElementsByName("datasets[]")[i].value+"'][]");
							for(var j=0; j < nucSet.length; j++) {
								nucSet[j].checked = false;
							}

							var traceSet = document.getElementsByName("tracedbs['"+document.getElementsByName("datasets[]")[i].value+"'][]");
							for(var j=0; j < traceSet.length; j++) {
								traceSet[j].checked = false;
							}
						}
					}
					document.getElementById('all_checkbox').checked=false;
					document.getElementById('all_checkbox').disabled=true;
				}else{
				//activate all datasets
					for(var i=0;i<sets.length;i++) {
						document.getElementsByName("datasets[]")[i].disabled=false;
					}
					document.getElementById('all_checkbox').disabled=false;
				}

				//if est box is checked and neither search option is checked, default to checking standard so the search doesn't bomb
				if(document.getElementById("est_standard").checked==false && document.getElementById("est_detailed").checked==false){
					document.getElementById("est_standard").checked=true;
				}
			}
		}


		function datasetCheckToggle(organism){
			var pepSet = document.getElementsByName("pepdbs['"+organism+"'][]");
			var nucSet = document.getElementsByName("nucdbs['"+organism+"'][]");
			var traceSet = document.getElementsByName("tracedbs['"+organism+"'][]");

			if(document.getElementById(organism+'_checkbox').checked==true){
			//enable all the dbs for this organism
				for(var i=0; i < nucSet.length; i++) {
					if(nucSet[i].disabled == false){
						nucSet[i].checked = true;
					}
				}
				for(var i=0; i < pepSet.length; i++) {
					if(pepSet[i].disabled == false){
						pepSet[i].checked = true;
					}
				}

			}else {
			//disable all dbs for organism
				for(var i=0; i < nucSet.length; i++) {
					nucSet[i].checked = false;
				}
				for(var i=0; i < traceSet.length; i++) {
					traceSet[i].checked = false;
				}
				for(var i=0; i < pepSet.length; i++) {
					pepSet[i].checked = false;
				}
			}
		}


		function databaseChecks(organism){

			var pepSet = document.getElementsByName("pepdbs['"+organism+"'][]");
			var nucSet = document.getElementsByName("nucdbs['"+organism+"'][]");
			var traceSet = document.getElementsByName("tracedbs['"+organism+"'][]");
			var atLeastOne = 0;

			for(var i=0; i < nucSet.length; i++) {
				if(nucSet[i].checked == true ) atLeastOne = 1;
			}
			for(var i=0; i < pepSet.length; i++) {
				if(pepSet[i].checked == true ) atLeastOne = 1;
			}
			for(var i=0; i < traceSet.length; i++) {
				if(traceSet[i].checked == true ) atLeastOne = 1;
			}

			if(document.getElementById(organism+'_checkbox').checked==true){
			//the dataset is checked, if no dbs are checked then uncheck dataset
				if (atLeastOne==0) { document.getElementById(organism+'_checkbox').checked=false; }
			} else {
			//dataset is unchecked, if there is at least one db selected then check the dataset
				if (atLeastOne==1) { document.getElementById(organism+'_checkbox').checked=true; }
			}

		}

	-->
</script>


<div id="errorBox">
<?
	if ($_GET["e5"])
		print $blast_errors[5];
	if ($_GET["e7"])
		print $blast_errors[7];
	if ($_GET["e8"])
		print $blast_errors[8];
	if ($_GET["e9"])
		print $blast_errors[9];
	if ($_GET["e12"])
		print $blast_errors[12];
	if ($_GET["e14"])
		print $blast_errors[14];
?>
</div>

<form method="post" enctype="multipart/form-data" action="javascript:submitBLAST();" id="blastForm" name="<?=$BLAST_FORM_NAME;?>" onsubmit="return validateFormOnSubmit(this)">

<div id="ieAlert" style="display:none; margin-top:4px; margin-left:30px; width:90%; border:1px solid #888a00; background-color:#c3c517; font:bold 10px Sans-serif; padding:4px 8px;">
 IE 7 Users: There is a limitation with IE 7 that prevents successful submission of BLAST jobs. Please consider upgrading to IE 8 or using Firefox.
</div>

<div id="issueAlert" style="display:none; margin-top:4px; margin-left:30px; width:90%; border:1px solid #888a00; background-color:#c3c517; font:bold 10px Sans-serif; padding:4px 8px;">
 BLAST Users: There is currently an issue with BLAST jobs, VectorBase staff are aware of the issue and are working to correct the problem. If your job takes more then ten minutes to complete please try refreshing the page. We appreciate your patience and patronage.
</div>

<!-- wtf is this??
<div id="blastTimer" style="display:none; margin-top:4px; margin-left:30px; width:90%; border:1px solid #888a00; background-color:#c3c517; font:bold 10px Sans-serif; padding:4px 8px;">
    Your query has been running for <script language="JavaScript">QueryTimer()</script>
</div>
-->

<div class="jobBox" style="width:98%;">
	<h1>FASTA Query Sequence</h1>
		<textarea class="hashelp" id="Web:Misc_Help#paste" name="input_sequence" style="font-family:Sans-serif; font-size:11px; margin:8px; width:97%; height:10em;" onfocus="if(this.value=='>Example Sequence\nCGGTCTATTTGGGGATCGAACCCATGACGAGCATGATGTTAAGTCGTA')this.value='';"><?
			if($_GET['blast_id']) echo $redoSequence; 
			else echo ">Example Sequence\nCGGTCTATTTGGGGATCGAACCCATGACGAGCATGATGTTAAGTCGTA";
		?></textarea>
</div>

<table>
<tr><td style="vertical-align:top">

<div class="jobBox" style="margin-left:6px">
	<h1>Program</h1>
		<table style="margin:6px 0px 0px 8px; padding-bottom:0px; width:100%;">
			<tr>
		<? foreach ($blast_programs as $program => $null){
			echo '<td>';
			echo '<label for="'.$program.'" class="blastProgram" ';
			echo ' onmouseover="document.getElementById(\'blastDescription\').innerHTML=\''.$program.' - '.$blast_programs[$program].'\'" ';
			echo '>';
			echo '<input id="'.$program.'" type="radio" style="vertical-align:bottom;" name="program" value="'.$program.'" onclick="blastProgramChecks();" ';
			echo ' alt="'.$blast_programs[$program].'" ';

			if($_GET['blast_id']){
				if($program == $redoProgram) echo " checked ";
			}else{
				if($program == 'blastn') echo " checked ";
			}
			echo '/>';

			echo $program;

			echo '</label></td>'."\n";
		}?>
			</tr>
			</table>
			<span id="blastDescription" style="margin:4px 0px; text-align:center;">blastn - <?=$blast_programs["blastn"];?></span>
</div>

<div id="datasetsDiv" class="jobBox" style="margin-left:6px; width:48em;">
	<h1>Datasets</h1>
		<table style="width:100%;">
			<tr><td style="width:16em; vertical-align:top;">
			<?
			foreach (ORG::$ENDOWED as $organism){
				if ($organism != "all" && $organism !="other"){
					echo '<div class="jobDataset" onclick="datasetDisplayToggle(\''.$organism.'\');" style="border-color: #'.DV::$BLASTOCS[$organism][4].'; background-color:#'.DV::$BLASTOCS[$organism][5].';">';
					echo '	<input type="checkbox" id="'.$organism.'_checkbox" name="datasets[]" value="'.$organism.'" style="vertical-align:middle;"';
					if ($_SESSION["organism_id"] == $organism) echo ' checked';
					echo ' onclick="datasetCheckToggle(\''.$organism.'\');"/>'."\n";
					echo '	<label for="'.$organism.'_checkbox" style="vertical-align:middle; color: #'.DV::$BLASTOCS[$organism][0].';"><i>'.ORG::$FN[$organism].'</i></label>'."\n";
					echo '</div>'."\n";
				}
			}?>

			<!-- other organisms -->
			<div class="jobDataset" onclick="datasetDisplayToggle('other');" style="border-color:#<?=DV::$BLASTOCS["llongipalpis"][4];?>; background-color:#<?=DV::$BLASTOCS["llongipalpis"][5];?>;">
				<input type="checkbox" id="other_checkbox" name="datasets[]" value="other" style="vertical-align:middle;" onclick="datasetCheckToggle('other');" />
				<label id="otherLabel" for="other_checkbox" style="vertical-align:middle; color: #<?=DV::$BLASTOCS["llongipalpis"][0];?>;">Other Organisms</label>
			</div>

			<!-- ESTs -->
			<div class="jobDataset" onclick="datasetDisplayToggle('est');" style="border-color:#<?=DV::$BLASTOCS["llongipalpis"][4];?>; background-color:#<?=DV::$BLASTOCS["llongipalpis"][5];?>;">
				<input type="checkbox" id="est_checkbox" name="datasets[]" value="est" style="vertical-align:middle;" onclick="datasetCheckToggle('est');"/>
				<label id="estLabel" for="est_checkbox" style="vertical-align:middle; color: #<?=DV::$BLASTOCS["llongipalpis"][0];?>;">ESTs</label>
			</div>

			<!-- all organisms -->
			<div class="jobDataset" style="border-color:#<?=DV::$BLASTOCS["all"][4];?>; background-color:#<?=DV::$BLASTOCS["all"][5];?>;">
				<input type="checkbox" id="all_checkbox" name="blastAll" onclick="toggleAllDatasets();" style="vertical-align:middle;"/>
				<label id="allLabel" for="all_checkbox" style="vertical-align:middle; color: #<?=DV::$BLASTOCS["all"][0];?>;">Select all</label>
			</div>
			</td>

			<!-- description column-->
			<td style="vertical-align:top;">
				<div id="jobDatasetDescription" style="font:normal 12px Sans-serif">
					<span id="jobDatasetDescriptionHelp" style="font-family:Sans-serif">Click on an organism to view its databases</span>
<?
$i=0;
// lists all dbs for each organism. these will be displayed one at a time, when that organism has been clicked
foreach (ORG::$ENDOWED as $organism){

	if ($organism != "all" && $organism != "other"){
//nuc dbs
		echo '<div id="'.$organism.'_databases" style="display:none; width:100%; border-radius: 12px; background-color:#'.DV::$BLASTOCS[$organism][5].'; border: 1px solid #'.DV::$BLASTOCS[$organism][4].';">';

		echo '<fieldset style="margin-bottom:6px">';
		echo '	<legend style="color: #'.DV::$BLASTOCS[$organism][0].'; margin: 0px; padding: 2px 2px 2px 8px;">Nucleotide</legend>';
		echo '	<ul>';

		$sql = "select b.display_id, b.blastdb_id, b.file_name, b.sequence_type from blast_databases b, organism o where b.organism_id=o.organism_id and o.short_name='".$organism."' and b.residue_type='NUCLEOTIDE' order by b.order_by";
		$dbResult = pg_query(DB::getUI_DB(),$sql);
		while ($row = pg_fetch_assoc($dbResult)){
			if($row["sequence_type"]=='Trace Read')
//need to do something really sweet here to not check these when the dataset is checked
				echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="tracedbs[\''.$organism.'\'][]" onclick="databaseChecks(\''.$organism.'\')" value="'.$row["file_name"].'" style="vertical-align:middle;"/><label style="font-family:Sans-serif;vertical-align:middle; color: #'.DV::$BLASTOCS[$organism][0].'; font-size:10px;" for="'.$row["blastdb_id"].'">'.$row["display_id"].'</label></li>'."\n";
			else
				echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="nucdbs[\''.$organism.'\'][]" onclick="databaseChecks(\''.$organism.'\')" value="'.$row["file_name"].'" style="vertical-align:middle;"/><label style="font-family:Sans-serif;vertical-align:middle; color: #'.DV::$BLASTOCS[$organism][0].'; font-size:10px;" for="'.$row["blastdb_id"].'">'.$row["display_id"].'</label></li>'."\n";
		}
		echo "	</ul>";
		echo "</fieldset>";
//pep dbs
		echo '<fieldset>';
		echo '	<legend style="color: #'.DV::$BLASTOCS[$organism][0].'; margin: 0px; padding: 2px 2px 2px 8px;">Peptide</legend>';
		echo '	<ul>';

		$sql = "select b.display_id, b.blastdb_id, b.file_name from blast_databases b, organism o where b.organism_id=o.organism_id and o.short_name='".$organism."' and b.residue_type='PEPTIDE'  order by b.order_by";
		$dbResult = pg_query(DB::getUI_DB(),$sql);
		while ($row = pg_fetch_assoc($dbResult)){ // setting the peptide dbs to disabled initially since the default blast program is blastn
			echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="pepdbs[\''.$organism.'\'][]" onclick="databaseChecks(\''.$organism.'\')" value="'.$row["file_name"].'" style="vertical-align:middle;" disabled="disabled" /><label style="vertical-align:middle; color: #'.DV::$BLASTOCS[$organism][0].';font-size:10px;" for="'.$row["blastdb_id"].'">'.$row["display_id"].'</label></li>'."\n";
		}
		echo "	</ul>";
		echo "	</fieldset>";
		echo "</div>";
		$i++;
	}
}

//other datasets
	echo '<div id="other_databases" style="display:none; width:100%; border-radius: 12px; background-color:#'.DV::$BLASTOCS["llongipalpis"][5].'; border: 1px solid #'.DV::$BLASTOCS["llongipalpis"][4].'; color: #'.DV::$BLASTOCS["llongipalpis"][0].';">';
	echo '<fieldset>';
	echo '	<legend style="color: #'.DV::$BLASTOCS["llongipalpis"][0].'; margin: 0px; padding: 2px 2px 0px 8px;">Nucleotide</legend>';
	//est 
	echo '	<legend style="color: #'.DV::$BLASTOCS["llongipalpis"][0].'; margin: 0px; padding: 2px; font-size: 8pt; padding-left:8px; padding-top:6px;">ESTs</legend>';
	echo '	<ul>';
	$sql = "select blastdb_id, description, file_name from blast_databases where sequence_type='EST' and organism_id!=9 and organism_id>7 order by order_by";
	$dbResult = pg_query(DB::getUI_DB(),$sql);
	while ($row = pg_fetch_assoc($dbResult)){
		echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="nucdbs[\'other\'][]" onclick="databaseChecks(\'other\')" value="'.$row["file_name"].'" /><label for="'.$row["blastdb_id"].'" style="color: #'.DV::$BLASTOCS["llongipalpis"][0].';font-size:10px;">'.$row["description"].'</label></li>'."\n";
	}
	echo '</ul>';
	//trace reads 
	echo '	<legend style="color: #'.DV::$BLASTOCS["llongipalpis"][0].'; margin: 0px; padding: 2px; font-size: 8pt; padding-left:8px; padding-top:10px;">Trace Reads</legend>';
	echo '<ul>';	
	$sql = "select blastdb_id, description, file_name from blast_databases where sequence_type='Trace Read' and organism_id!=9 and organism_id>7 order by order_by";
	$dbResult = pg_query(DB::getUI_DB(),$sql);
	while ($row = pg_fetch_assoc($dbResult)){
		echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="tracedbs[\'other\'][]" onclick="databaseChecks(\'other\')" value="'.$row["file_name"].'" /><label for="'.$row["blastdb_id"].'" style="color: #'.DV::$BLASTOCS["llongipalpis"][0].';font-size:10px;">'.$row["description"].'</label></li>'."\n";;
	}

	//mRNAseq
	echo '	<legend style="color: #'.DV::$BLASTOCS["llongipalpis"][0].'; margin: 0px; padding: 2px; font-size: 8pt; padding-left:8px; padding-top:10px;">mRNAseq</legend>';
	echo '<ul>';	
	$sql = "select blastdb_id, description, file_name from blast_databases where sequence_type='mRNAseq' order by order_by";
	$dbResult = pg_query(DB::getUI_DB(),$sql);
	while ($row = pg_fetch_assoc($dbResult)){
		echo '<li class="altLi"><input type="checkbox" id="'.$row["blastdb_id"].'" name="nucdbs[\'other\'][]" onclick="databaseChecks(\'other\')" value="'.$row["file_name"].'" /><label for="'.$row["blastdb_id"].'" style="color: #'.DV::$BLASTOCS["llongipalpis"][0].';font-size:10px;">'.$row["description"].'</label></li>'."\n";;
	}

	echo "</ul></fieldset></div>";

//EST datasets
	echo '<div id="est_databases" style="display:none; width:100%; border-radius: 12px; background-color:#'.DV::$BLASTOCS["llongipalpis"][5].'; border: 1px solid #'.DV::$BLASTOCS["llongipalpis"][4].'; color: #'.DV::$BLASTOCS["llongipalpis"][0].';">';
	echo '<fieldset>';
	echo '	<legend style="color: #'.DV::$BLASTOCS["llongipalpis"][0].'; margin: 0px; padding: 2px 2px 2px 8px;">Nucleotide</legend>';
	echo '	<ul>';

	echo '<li class="altLi"><input type="radio" id="est_standard" name="est_results" onclick="checkEsts(); datasetDisplayToggle(\'est\');" checked/><label for="est_standard" style="color: #'.DV::$BLASTOCS["llongipalpis"][0].';">All Libraries<span>Search complete species EST datasets (One database per species)</span></label></li>';

	echo '<li class="altLi"><input type="radio" id="est_detailed" name="est_results" onclick="checkEsts();datasetDisplayToggle(\'est\');" /><label for="est_detailed" style="color: #'.DV::$BLASTOCS["llongipalpis"][0].';">Individual Libraries<span>Search individual EST libraries from all species (One database per library)</span></label></li>';

	echo '<li class="jobSmall" style="color:black;margin-left:35px;">We suggest decreasing the Maximum E-Value for more significant results</li>'; 

	echo "</ul></div>";

?>
		</div>
	</td></tr></table>
</div> <!-- end datasetsDiv -->



</td>
<td style="vertical-align:top">

<div class="jobBox" style="width:97%;">
	<h1>Options</h1>
		<ul>
			<li><label class="altLabel" for="evalue">Maximum E-Value</label>
				<select class="jobSmall hashelp" name="evalue" id="Web:BLAST#maximum_e-value">
				<? $evalsArray=array("10","1","0.1","1E-3","1E-5","1E-10","1E-20","1E-40","1E-80");
				foreach($evalsArray as $option){
					echo "<option value=\"" . $option . "\"";
					if($_GET['blast_id']){
						if($option == $redoEvalue)
							echo " selected=\"selected\"";
					}elseif ($option=="1") echo " selected=\"selected\""; 
					echo ">" . $option . "</option>\n";
				}?>
				</select>
			</li>

			<li><label class="altLabel" for="wordsize">Word Size</label>
				<select class="jobSmall hashelp" name="wordsize" id="Web:BLAST#wordlength" onchange="wordSizeCheck()">
				<? $sizes = array(3, 5, 7, 8, 11, 15, 30, 60);
				foreach($sizes as $size){
					echo "<option value=\"" . $size . "\"";
					if($_GET['blast_id'] && $size == $redoWordsize)	echo " selected=\"selected\"";
					elseif($size==11) echo " selected=\"selected\"";
					echo ">" . $size . "</option>";
				}?>
				</select>
			</li>

			<li><label class="altLabel" for="scoringmatrix">Scoring Matrix</label>
				<select class="jobSmall hashelp" name="scoringmatrix" id="Web:BLAST#scoring_matrix">
				<? $sizes = array("BLOSUM45", "BLOSUM62", "BLOSUM80", "PAM30", "PAM70");
				foreach($sizes as $size){
					echo "<option value=\"" . $size . "\"";
					if($_GET['blast_id'] && $size == $redoScoringmatrix) echo " selected=\"selected\"";
					else if ($size=="BLOSUM62") echo " selected=\"selected\"";
					echo ">" . $size . "</option>";
				}?>
				</select>
			</li>

			<li><label class="altLabel" for="dust">Complexity Masking</label>
				<select class="jobSmall hashelp" name="dust" id="Web:BLAST#masking">
					<option value="T" <? if($_GET['blast_id'] && $redoMasking == "T") echo "selected=\"selected\""; ?>>Low</option>
					<option value="F" <? if($_GET['blast_id'] && $redoMasking == "F") echo "selected=\"selected\""; ?>>Off</option>
				</select>
			</li>

			<li><label class="altLabel" for="num_results">Number of Results</label>
				<select class="jobSmall hashelp" name="num_results" id="Web:BLAST#number_of_results">
				<? $sizes = array(1, 5, 10, 50, 100, 250, 500);
				$numhitset = 0;
				foreach($sizes as $size){
					echo "<option value=\"" . $size . "\"";
					if($_GET['blast_id'] && $size == $redoNumhits_align){
						echo " selected=\"selected\"";
						$numhitset = 1;
					}elseif ($size==50 && $numhitset != 1) echo " selected=\"selected\"";
					echo ">" . $size . "</option>";
				}?>
				</select>
			</li>
		</ul>
</div>

<div class="jobBox" style="float:left; clear:both; width:97%;">
	<h1>Job Control</h1>
		<input type="text" size="18" name="job_id" class="jobSmall" style="float:left; margin:8px;" value="<? if($_GET['jobId']) echo $_GET['jobId']; else echo 'Retrieve BLAST Job ID';?>" onfocus="if(this.value=='Retrieve BLAST Job ID')this.value='';" />
		<input type="submit" value="BLAST!" class="jobSmall" id="Web:Misc_Help#submit" style="float:right; margin:8px;"/>
</div>

</td></tr></table>
</form>


<div id="jobResultsLink" style="font: normal 12px Sans-serif;"></div>
<div id="jobActivity" style="float:left; clear:both;width:100%;"></div>
<div id="spacer" style="float:left; clear:both; margin-top:8px;"></div>

<script>
//now that page has loaded, if we are under an organism page, make sure dbs are selected for the species dataset, also make that tab viewable
<? if ($_SESSION["organism_id"]) {
	echo 'datasetCheckToggle(\''.$_SESSION["organism_id"].'\');';
	echo 'datasetDisplayToggle(\''.$_SESSION["organism_id"].'\');';
  }
?>


//document.getElementById('issueAlert').style.display='block';
//var ieVersion=returnOneSubstring(/MSIE (\d+\.\d+);/m,navigator.appVersion);
//if(ieVersion=='7.0'){
//	document.getElementById('ieAlert').style.display='block';
//}
</script>
