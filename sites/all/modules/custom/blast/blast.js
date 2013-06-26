(function ($) {

 $(document).ready(function () {

	 // weird firefox bug.
	 $("#edit-sequence").css("display",'inline-block');

	 // stupid ie ajax caching bug
	 $.ajaxSetup({ cache: false });

	 //$('#edit-complexitymasking').val('Default');
	 //console.log($('#edit-complexitymasking').val());
	 //$('#edit-complexitymasking select>option:eq(1)').attr('selected', true);
	 //console.log($('#edit-complexitymasking').val());

	 // blast program descriptions for labels and their radio buttons
	 $("label[for='edit-program-blastn']").mouseover(function() {
		 $('#blastProgramDescription').text('blastn - Nucleotide vs. Nucleotide');
		 });
	 $("label[for='edit-program-tblastn']").mouseover(function() {
		 $('#blastProgramDescription').text('tblastn - Peptide vs. Translated Nucleotide');
		 });
	 $("label[for='edit-program-tblastx']").mouseover(function() {
		 $('#blastProgramDescription').text('tblastx - Translated Nucleotide vs. Translated Nucleotide');
		 });
	 $("label[for='edit-program-blastp']").mouseover(function() {
			 $('#blastProgramDescription').text('blastp - Peptide vs. Peptide');
			 });
	 $("label[for='edit-program-blastx']").mouseover(function() {
			 $('#blastProgramDescription').text('blastx - Translated Nucleotide vs. Peptide');
			 });
	 $("input[name='program'][value='blastn']").mouseover(function() {
			 $('#blastProgramDescription').text('blastn - Nucleotide vs. Nucleotide');
			 });
	 $("input[name='program'][value='tblastn']").mouseover(function() {
			 $('#blastProgramDescription').text('tblastn - Peptide vs. Translated Nucleotide');
			 });
	 $("input[name='program'][value='tblastx']").mouseover(function() {
			 $('#blastProgramDescription').text('tblastx - Translated Nucleotide vs. Translated Nucleotide');
			 });
	 $("input[name='program'][value='blastp']").mouseover(function() {
			 $('#blastProgramDescription').text('blastp - Peptide vs. Peptide');
			 });
	 $("input[name='program'][value='blastx']").mouseover(function() {
			 $('#blastProgramDescription').text('blastx - Translated Nucleotide vs. Peptide');
			 });


	 // run the checks when program changes
	 $("input[name='program']", '#blast-ajax-form').change(function() {
			 blastProgramChecks();
			 });

	 // blast program checks
	 function blastProgramChecks(){
		 var checked=$("input[name='program']:checked", '#blast-ajax-form').val();
		 setDefaultWordSize(checked);
		 setDefaultComplexityMasking(checked);

		 // hide scoring matrix for blastn since it isn't supported in new blastall
		 if(checked=='blastn'){
			 $("label[for='edit-scoringmatrix']").css("display","none");
			 $("#edit-scoringmatrix").css("display","none");
			 $("#edit-scoringmatrix").attr("disabled","disabled");
		 }else{
			 $("label[for='edit-scoringmatrix']").css("display","block");
			 $("#edit-scoringmatrix").css("display","block");
			 $("#edit-scoringmatrix").removeAttr("disabled");
		 }
		 setAvailableDbs(checked);
		 setCheckedDbs();
	 }

	 // set default wordsize to 11 for blastn, 3 otherwise
	 function setDefaultWordSize(checked){
		 if(checked=='blastn'){
			 $("#edit-wordsize").val('11').attr("selected","selected");
		 }else{
			 $("#edit-wordsize").val('3').attr("selected","selected");
		 }
	 }

	 // set low complexity masking off for blastp
	 function setDefaultComplexityMasking(checked){
		 if(checked=='blastp'){
			 $("#edit-complexitymasking").val('no').attr("selected","selected");
		 }else{
			 $("#edit-complexitymasking").val('Default').attr("selected","selected");
		 }
	 }

	 // set available dbs for the selected program
	 function setAvailableDbs(checked){
		 if(checked=='blastp' || checked=='blastx'){
			 // only pep dbs
			 // uncheck and disable nucs
			 $("[id^=edit-nucleotide] .nucDbs").removeAttr("checked");
			 $("[id^=edit-nucleotide]").attr("disabled", "disabled");
			 // enable peps
			 $("[id^=edit-peptide]").removeAttr("disabled");
		 }else{
			 // only nuc dbs
			 // uncheck and disable peps
			 $("[id^=edit-peptide] .pepDbs").attr("checked",false);
			 $("[id^=edit-peptide]").attr("disabled", "disabled");
			 // enable nucs
			 $("[id^=edit-nucleotide]").removeAttr("disabled");
		 }
	 }


	 // datasets: toggle active dataset displayed
	 $(".organismCheckboxDiv").mouseover(function() {
			 // clear all visible sets
			 $(".dbContainer:not([data-org="+$(this).attr('data-org') +"])" ).css("display", "none");
			 // enable selected set
			 $(".dbContainer[data-org="+$(this).attr('data-org') +"]" ).css("display", "block");

			 //clear all highlighted organism name divs
			 $(".organismCheckboxDiv").stop().animate({boxShadow: "#eee 0px 0px 0px 0px"}, 600);

			 // highlight this div
			 $(this).stop().animate({boxShadow: "#ddd 0px 0px 7px 8px"}, 300);
			 });


	 // datasets: check associated dbs toggle
	 $(".organismCheckbox").live("change",function (event) {
			 $(".dbs[data-org="+$(this).attr('data-org') +"]:checkbox").attr('checked', this.checked);
			 //uncheck bac dbs
			 $(".dbs[data-org="+$(this).attr('data-org') +"].bac:checkbox").removeAttr('checked');
			 setAvailableDbs($("input[name='program']:checked", '#blast-ajax-form').val());
			 });

	 // examine all checked datasets, check dbs according to what program is selected
	 function setCheckedDbs(){
		$(".organismCheckboxDiv :checked").each(function() {
			$(".organismCheckbox").trigger('change');
		});
	 }

	 // master toggle for all datasets
	 $(".allDatasets").live("click",function (event) {
			 $(".organismCheckboxDiv :checkbox").attr('checked', this.checked);
			 $(".dbs:checkbox").attr('checked',this.checked);

			 // calling this function is taking forever. lets speed it up
			 //setCheckedDbs();
			 setAvailableDbs($("input[name='program']:checked", '#blast-ajax-form').val());

			 });


	 // toggles for specific type select alls
	 $(".allSelector").live("click",function (event) {
			 var thisType= $(this).attr('data-type');
			 $("label.option:contains('"+thisType+"')").each(function (i,v){
				 var idOfCheckbox=$(v).attr('for');
				 $("#"+idOfCheckbox).attr('checked', $(".allSelector[data-type="+thisType+"]").attr('checked'));
				 //console.log(idOfCheckbox + $("#"+idOfCheckbox).attr('checked') );
				 });

			 setCheckedDbs();
			 });


	 // if any dbs are checked, also check it's parent dataset
	 $(".dbs").live("click",function (event) {
			 if( $(".dbs[data-org="+$(this).attr('data-org') +"]:checked").length>0 ){
			 $(".organismCheckbox[data-org="+$(this).attr('data-org') +"]:checkbox").attr('checked', true);
			 }else{
			 $(".organismCheckbox[data-org="+$(this).attr('data-org') +"]:checkbox").removeAttr('checked');
			 }
			 });



	 /**********************************************
	   job has been submitted. we have an id returned.
	   make pop up and wait until we have some job results
	   */



	 var statusRepeat;
	 var jobId;
	 var isRaw=true;
	 var pinwheel='<br/><img src="'+Drupal.settings.blast.blastPath+'/ajax-loader.gif">';

	 // stupid drupal form api won't let us run this on click. use mousedown as dirty hack
	 $("#edit-submit--3").mousedown(function() {

			 // if a user has previously submitted a job, there will be a lot of info on the page.
			 // submitting another will clear the form and leave the view way below the footer.
			 // looks very odd. let's smoothly scroll back to the top for them 
			 $("html, body").animate({scrollTop: 0}, "slow");

			 // create dialog popup
			 $("#submissionDialog").dialog({
autoOpen: true,
show: "scale",
hide: "scale",
position: {my: "center", at: "top", of: $('#blastUIcontainer')},
width: 300,
height: 200,
draggable: false,
modal: true,
title:"BLAST Job Status",
});

			 if($('#edit-lookup').val()==''){
				 $("#submissionDialog").html('Submitting job'+pinwheel);
			 }else{
				 $("#submissionDialog").html('Looking up job'+pinwheel);
			 }

});

// job id element has changed and the new value is presumably a new job id
$('#edit-jobid').bind('DOMNodeInserted DOMNodeRemoved', function(event) {
		if (event.type == 'DOMNodeInserted' && $('#edit-jobid').text()!='') {

		rawId=$('#rawJobId').text();
		parseId=$('#parseJobId').text();
		jobId=rawId;

		//alert('edit-job id has changed and text is not null ' +jobId);

		$("#submissionDialog").dialog("open");
		$("#submissionDialog").html('Job '+parseId+' is being retrieved'+pinwheel);
		// keep checking status until we're all done
		var statusRepeat=setInterval(function(){
			var status=getJobStatus();
			// exit out of this loop once 0 is returned from getJobStatus function
			if(status==1){
			clearInterval(statusRepeat);
			}
			},2000);

		}
});	//end edit-jobid has changed


function getJobStatus(){
	//console.log("looking up status "+jobId);
	var error=false;
	var done=false;

	$.ajax({type: "POST",
			data: "id=" + jobId +"&ieIsCrap="+Math.round(new Date().getTime()/1000.0),
			async: false,
			url: Drupal.settings.xgrid.xgridPath+"/status.php",
	success: function(status){
			//console.log('is raw? '+ isRaw);

			// is this the raw blast job?
			if(isRaw==true){
			// report on the job progress
			//console.log( "id=" + jobId+"&ieIsCrap="+Math.round(new Date().getTime()/1000.0) );
			$.ajax({type: "POST",
				data: "id=" + jobId+"&ieIsCrap="+Math.round(new Date().getTime()/1000.0),
				async: false,
				url: Drupal.settings.xgrid.xgridPath+"/jobProgress.php",
				success: function(msg){
				$("#submissionDialog").dialog("open");
				if(status=="Running"){
				$("#submissionDialog").html("Job "+parseId+" is running: "+msg+'%'+pinwheel);
				}else{
				var statuz = status === "" ? 'in an unknown state' : status.toLowerCase();
				$("#submissionDialog").html("Job "+parseId+" is "+statuz+pinwheel);
				}

				// if final job status has been achieved
				if ( status=="Finished" || status=="Failed" || status=="Canceled" || status=="Error" ) {
					isRaw=false;
					jobId=parseId;
				} else{
					//console.log(status);
				}
			},
	error: function(msg){
	       $("#submissionDialog").dialog("open");
	       $("#submissionDialog").html('Job ' +parseId+' encountered an error while retrieving job status: ' + msg.responseText);
	       error=true;
       }

});

// this is a parse job
} else{
	$("#submissionDialog").html('Job ' + parseId + ' results are being parsed'+pinwheel);
	// if final job status has been achieved
	if ( status=="Finished" || status=="Failed" || status=="Canceled" || status=="Error" ){
		clearInterval(statusRepeat);
		$("#submissionDialog").dialog("open");
		$("#submissionDialog").html('Job ' + parseId + ' results are being retrieved');
		// there are now results available, pull them out and display them
		var s = new Date().getTime();	
		$.ajax({
type: "POST",
data: "id=" + jobId +"&ieIsCrap="+Math.round(new Date().getTime()/1000.0),
async: false,
url: Drupal.settings.blast.blastPath+"/displayResults.php",
success: function(msg){
var ss = new Date().getTime();
//console.log('Time took for post: ' + (ss - s));
$("#edit-result").html(msg);
var s2 = new Date().getTime();
//console.log('Time took for edit-result update: ' + (s2 - ss));
$("#submissionDialog").dialog("close");
var s3 = new Date().getTime();
//console.log('Time took to close the dialog: ' + (s3 - s2));
$("#edit-jobid").html('');
var s4 = new Date().getTime();
//console.log('Time took to clear edit-jobid: ' + (s4 - s3));
isRaw=true;
done=true;
loadInputParams(msg);
var s5 = new Date().getTime();
//console.log('Time took to load input params: ' + (s5 - s4));
//console.log('Time took for whole success method: ' + (s5 - ss));
},
error: function(msg){
	       $("#submissionDialog").dialog("open");
	       $("#submissionDialog").html('Job ' + parseId + ' encountered an error while parsing results: ' + msg.responseText);
	       error=true;
       }

});
}
}
},

error: function(msg){
	       $("#submissionDialog").dialog("open");
	       $("#submissionDialog").html("Error: " + msg.responseText);
	       error=true;
       }
});


// need a way of knowing when to stop running this function as in interval when it is called
if(error==true || done==true){
	return 1;
}
else{
	return 0;
}

}



/*
   end of job submission handling
 **********************************************/




/****************************
  for parsing of job input params
 ******************************************/
function returnOneSubstring(regex,input){
	regex.exec(input);	 
	return RegExp.$1;
}

function loadInputParams(input){
	//var l1 = new Date().getTime();
	// load job input parameters
	$("#edit-sequence").val(returnOneSubstring(/sequence=([\s\S]*?)IIIjustInCase;/,input));

	if(returnOneSubstring(/maxEvalue=([\w|\d|-]+);/m,input)!=''){
		$("#edit-maxevalue").val(returnOneSubstring(/maxEvalue=([\w|\d|-]+)/m,input));
	}
	if(returnOneSubstring(/wordSize=([\d]+);/m,input)!=''){
		$("#edit-wordsize").val(returnOneSubstring(/wordSize=([\d]+)/m,input));
	}
	if(returnOneSubstring(/complexityMasking=([\w]+);/m,input)!=''){
		$("#edit-complexitymasking").val(returnOneSubstring(/complexityMasking=([\w]+)/m,input));
	}
	if(returnOneSubstring(/num_alignments=([\d]+);/m,input)!=''){
		$("#edit-numberofresults").val(returnOneSubstring(/num_alignments=([\d]+)/m,input));
	}
	if(returnOneSubstring(/scoringMatrix=([\w|\d]+)/m,input)!=''){
		$("#edit-scoringmatrix").val(returnOneSubstring(/scoringMatrix=([\w|\d]+)/m,input));
	}

	var program=returnOneSubstring(/program=([\w]+)/m,input);
	if(program!=''){
		//$("#edit-program").val(program);
		var programRadio=$("input[name='program']").filter('[value='+program+']').attr('checked', true);

	}

	//var l2 = new Date().getTime();	
	//console.log('Time took for job input param settings to get filled in: ' + (l2 - l1));
	
	// run some checks on this new data we're importing to the form
	// hide scoring matrix for blastn since it isn't supported in new blastall
	if(program=='blastn'){
		$("#edit-scoringmatrix").css("display","none");
		$("#edit-scoringmatrix").attr("disabled","disabled");
	}else{
		$("#edit-scoringmatrix").css("display","block");
		$("#edit-scoringmatrix").removeAttr("disabled");
	}

	//var l3 = new Date().getTime();	
	//console.log('Time took for some more css and attr modifications: ' + (l3 - l2));

	//  --- check dbs ---
	// first, uncheck all datasets/dbs currently selected
	$(".organismCheckboxDiv :checkbox").removeAttr('checked');
	$(".dbs:checkbox").removeAttr('checked');


	// check dbs listed in inputParams
	var pattern =/database\d+=([\w|.|-]+);/mg;
	var match;
	var org;
	while( ( match=pattern.exec(input) ) != null){
		// check this db
		$(".dbs[data-filename="+ match[1] +"]:checkbox").attr('checked', 'checked');
		// what is data-org for this db?
		org = $(".dbs[data-filename="+ match[1] +"]:checkbox").data("org");
		// check that parent dataset this db belongs to
		$(".organismCheckbox[data-org='"+org+"']:checkbox").attr('checked','checked');
	}

	//var l4 = new Date().getTime();	
	//console.log('Time took for db check box fill-ins: ' + (l4 - l3));
	// do checks on dbs and select datasets of selected dbs
	setAvailableDbs(program);
	//var l5 = new Date().getTime();	
	//console.log('Time took for setAvailableDbs to run: ' + (l5 - l4));
	setCheckedDbs();
	//var l6 = new Date().getTime();	
	//console.log('Time took for setCheckedDbs to run: ' + (l6 - l5));
}




// set some images for the sortable table columns
$('th.headerSortUp').css('background-image', "url('/"+Drupal.settings.blast.blastPath+"/asc.gif')");
$('th.headerSortDown').css('background-image', "url('/"+Drupal.settings.blast.blastPath+"/desc.gif')");



// initially sort the top level results table on most hits, then org name, then db name
$('#edit-result').bind('DOMNodeInserted DOMNodeRemoved', function(event) {
		if (event.type == 'DOMNodeInserted') {
		// if there is red error text in here, we need to close the submission/status popup
		if($(this).css('color')=='rgb(255, 0, 0)'){
		$("#submissionDialog").dialog("close");
		}

		if ($("#topLevelTable").attr("data-initial")=="sortme"){
		//console.log( 'declaring sort order' );
		$("#topLevelTable").removeAttr('data-initial');
		// declare our results table as sortable
		$("#topLevelTable").tablesorter({ 
			// sort on the third column (desc), then first column (asc), then 2nd(asc)
sortList: [[2,1],[0,0],[1,0]] 
});
		}

		}
		});

// load hsp results through ajax
$(".dbResult").live("click",function (event) {
		// remove highlighting of previously checked dbs
		$(".dbResult").stop().animate({boxShadow: "#eee 0px 0px 0px 0px"}, 600);
		//highlight this db
		$(this).stop().animate({boxShadow: "#ddd 0px 0px 7px 8px"}, 300);


		//console.log( Drupal.settings.blast.blastPath+" id=" + $(this).attr('data-id')+"&db="+$(this).attr('data-db') );
		$("#hspLevelResults").html('Retrieving results<br/><img src="'+Drupal.settings.blast.blastPath+'/ajax-loader.gif">');

		$.ajax({
type: "POST",
data: "id=" + $(this).attr('data-id')+"&db="+$(this).attr('data-db'),
url: Drupal.settings.blast.blastPath+"/blastHspResults.php",
success: function(msg){
$("#hspLevelResults").html(msg)

// declare our results table as sortable
$("#blastHsps").tablesorter({
headers: {
// disable sorting on checkbox column (we start counting zero)
0: {
sorter: false
},
// hit names are links but sort on the text inside the link
1: {
sorter: 'links'
},
// special case for evalue column
3: { 
sorter: 'scinot' 
} 
},
sortList:[[2,0]]
});

//scroll view down to where results start
var scrollTo=$('#blastHsps'),
    container=$('html, body');

var	scroll=scrollTo.offset().top  - container.offset().top  + container.scrollTop();
scroll=scrollTo.offset().top-400;
container.animate({
scrollTop: scroll,
}, "slow");

}
});
});


// set defualt for animation speeds
$.fx.speeds._default = 350;

// load popups with hsp details
$(".hsp").live("click",function (event) {

		// conifg the dialog popups
		$("#hspDialog").dialog({
autoOpen: false,
show: "scale",
hide: "scale",
position: "center",
width: 750,
height: 600,
maxWidth: 800,
maxHeight: 1200,
draggable: true,
modal: true,
});

		$("#hspDialog").dialog('open');
		$("#hspDialog").html('Retrieving HSP details<br/><img src="'+Drupal.settings.blast.blastPath+'/ajax-loader.gif">');
		$("#hspDialog").dialog('option','title',"BLAST HSP Details");

		$.ajax({
type: "POST",
data: "id=" + $(this).attr('id'),
url: Drupal.settings.blast.blastPath+"/hspDetails.php",
success: function(msg){
$("#hspDialog").html(msg);
//$("#hspDialog").title("HSP Result");
$("#hspDialog").dialog('open');
}
});
}); // end .hsp click events


// allow clicks in grayed out area to close the hsp details dialog
$('.ui-widget-overlay').live("click", function() {
		//Close the dialog
		$("#hspDialog").dialog("close");
		}); 

// master toggle for hsp results
$("#hspsMaster").live("click",function (event) {
		$("#blastHsps .hsps").attr('checked', this.checked);
		});


// toggle query/hit graphics and numbers
$("#hspGraphicTextSwitch").live("click",function (event) {
		/* i really wanted to do this with display:none for the graphic columns but that completely messes up the widths after multiple toggles */

		// initial state is graphic
		if($("#hspGraphicTextSwitch").text()=="Show Query/Hit Numbers"){
		// change column headers
		$("#queryStart").html("Query Start");
		$("#queryGraphic").html("");
		$("#queryEnd").html("Query End");
		$("#hitStart").html("Hit Start");
		$("#hitGraphic").html("");
		$("#hitEnd").html("Hit End");

		// change column widths and css properties
		$(".rightAln").css({"width":"7em"});
		$(".leftAln").css({"width":"7em"});
		$(".rightAln").css({"text-align":"center"});
		$(".leftAln").css({"text-align":"center"});
		$(".hidden").css({"visibility":"visible"});
		$(".hidden").css({"overflow":"visible"});


		// hide graphics
		$("#queryGraphic").css({"visibility":"hidden"});
		$("#hitGraphic").css({"visibility":"hidden"});
		$(".hspGraphic").css({"visibility":"hidden"});
		$("#queryGraphic").css({"width":"1px"});
		$("#hitGraphic").css({"width":"1px"});
		$(".hspGraphic").css({"width":"1px"});

		// change link text
		$("#hspGraphicTextSwitch").text("Show Query/Hit Graphics");
		}else{
			// change column headers
			$("#queryStart").html("<");
			$("#queryGraphic").html("Query Hit");
			$("#queryEnd").html(">");
			$("#hitStart").html("<");
			$("#hitGraphic").html("DB Sequence Hit");
			$("#hitEnd").html(">");

			// change column widths and css properties
			$(".rightAln").css({"width":"10px"});
			$(".leftAln").css({"width":"10px"});
			$(".rightAln").css({"text-align":"right"});
			$(".leftAln").css({"text-align":"left"});
			$(".hidden").css({"visibility":"hidden"});
			$(".hidden").css({"width":"1px"});
			$(".hidden").css({"overflow":"hidden"});

			// display graphics
			$("#queryGraphic").css({"visibility":"visible"});
			$("#queryGraphic").css({"width":"114px"});
			$("#hitGraphic").css({"visibility":"visible"});
			$("#hitGraphic").css({"width":"114px"});
			$(".hspGraphic").css({"visibility":"visible"});
			$(".hspGraphic").css({"width":"114px"});

			// change link text
			$("#hspGraphicTextSwitch").text("Show Query/Hit Numbers");	
		}
});





//TODO: detect if user has uploaded file:
// $(function() {
//    $("input:file").change(function (){
//      var fileName = $(this).val();
//      $(".filename").html(fileName);
//    });
//  });

// download job results
$("#dlResults").live("click",function (event) {
		var string='id=' + $(this).attr('data-jobid');
		$.download(Drupal.settings.xgrid.xgridPath+'/downloadResults.php',string );
		});

// download checked sequences
$("#downloadSequences").live("click",function (event) {
		var i=0;
		var string='';
		$(".hsps:checked").each(function() {
			string=string+'hsp'+i+'='+$(this).val()+'&';
			i++;
			});
		string=string+'jobid='+ $("#jobId").text();
		if(i>0){
		$.download(Drupal.settings.blast.blastPath+'/downloadSequences.php',string );
		} else{
		alert("No sequences selected");
		}
		});

// send checked sequences to clustalw
$("#sendToClustal").live("click",function (event) {
		var i=0;
		var string='';
		$(".hsps:checked").each(function() {
			string=string+'hsp'+i+'='+$(this).val()+'&';
			i++;
			});
		if(i>0){
		$.customPost('/clustalw',string );
		} else{
		alert("No sequences selected");
		}
		});

// send checked sequences to clustalw
$("#quickAlign").live("click",function (event) {
		var i=0;
		var string='';
		$(".hsps:checked").each(function() {
			string=string+'hsp'+i+'='+$(this).val()+'&';
			i++;
			});
		if(i>1){

		// conifg the dialog popups
		$("#hspDialog").dialog({
autoOpen: false,
show: "scale",
hide: "scale",
position: "center",
width: 750,
height: 600,
maxWidth: 800,
maxHeight: 1200,
draggable: true,
modal: true,
});

$("#hspDialog").dialog('open');
$("#hspDialog").html('Aligning sequences with ClustalW<br/><img src="'+Drupal.settings.blast.blastPath+'/ajax-loader.gif">');
$("#hspDialog").dialog('option','title',"Quick Align");

$.ajax({
type: "POST",
data: string,
url: Drupal.settings.clustalw.clustalwPath+'/quickAlign.php',
success: function(msg){
$("#hspDialog").html(msg);
//$("#hspDialog").title("HSP Result");
$("#hspDialog").dialog('open');
}
});
} else{
	alert("ClustalW needs at least 2 sequences to align.");
}
});

// fire the program changed event on page load
$("input[name='program']", '#blast-ajax-form').trigger('change');

// handle a get/post organism= variable on page load
$(".dbs[data-org="+ $(".form-checkbox:checked").parent().parent().attr('data-org') +"]:checkbox").attr('checked', 'checked');
setAvailableDbs($("input[name='program']:checked", '#blast-ajax-form').val());
$(".organismCheckboxDiv[data-org="+$(".form-checkbox:checked").parent().parent().attr('data-org')+"]").trigger('mouseover');

jQuery.customPost = function(url, data){
	//url and data options required
	if( url && data ){ 
		//data can be string of parameters or array/object
		data = typeof data == 'string' ? data : jQuery.param(data);
		//split params into form inputs
		var inputs = '';
		jQuery.each(data.split('&'), function(){ 
				var pair = this.split('=');
				inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
				});
		//send request
		jQuery('<form action="'+ url +'" method="post" target="_blank">'+inputs+'</form>')
			.appendTo('body').submit().remove();
	};
};


jQuery.download = function(url, data, method){
	//url and data options required
	if( url && data ){ 
		//data can be string of parameters or array/object
		data = typeof data == 'string' ? data : jQuery.param(data);
		//split params into form inputs
		var inputs = '';
		jQuery.each(data.split('&'), function(){ 
				var pair = this.split('=');
				inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
				});
		//send request
		jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
			.appendTo('body').submit().remove();
	};
};


// add extension to tablesorter pluggin so we can sort scientific notation
$.tablesorter.addParser({ 
		// set a unique id
id: 'scinot', 
is: function(s) { 
return /[+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?/.test(s); 
}, 
format: function(s) { 
return $.tablesorter.formatFloat(s);
}, 
type: 'numeric' 
});


$.tablesorter.addParser({
		// set a unique id 
id: 'links',
is: function(s)
{
// return false so this parser is not auto detected 
return false;
},
format: function(s)
{
// format your data for normalization 
return s.replace(new RegExp(/<.*?>/),"");
},
// set type, either numeric or text
type: 'text'
}); 


});
})(jQuery);

