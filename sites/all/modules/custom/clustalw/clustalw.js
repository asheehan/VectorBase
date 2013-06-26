(function ($) {
	$(document).ready(function () {

		// attempt to guess sequence type
		$("#edit-sequence").mouseout(function () {
			// lets make this easy: remove all the headers then see what we have left
			var fasta=$("#edit-sequence").val();
			var re = new RegExp("(>.*)","g");
			fasta=fasta.replace(re, "");

			// now if we only have atgcn-\s\r\n we've got ourselves some dna sequence
			var dna = /^[ACGTN\s\r\n-]+$/ig;

			// check the dna type if we have dna
			if(dna.test(fasta)){
				$('input:radio[name="type"]:[value="DNA"]').attr('checked',true);
			}else{
				$('input:radio[name="type"]:[value="PROTEIN"]').attr('checked',true);
			}
		});


		// if blast is injecting sequences, we should try to auto set the input type on page load
		//setTimeout(sample,2000)
		$("#edit-sequence").trigger("mouseout");


		// toggle scores div
/*
		$("#toggleScores").live("click",function (event) {
			if( $("#scores").css('display')=='none'){
				$("#scores").css('display','block');
				$('#toggleScores').html("Hide Alignment Scores");
			}else{
				$("#scores").css('display','none');
				$('#toggleScores').html("View Alignment Scores");
			}
		});
*/

		// download scores
		$("#downloadScores").live("click",function (event) {
			$.download(Drupal.settings.clustalw.clustalwPath+'/clustalwDownloadResults.php', 'id='+$("#jobId").text()+'&type=stdout' );
		});

		// download scores
		$("#downloadTree").live("click",function (event) {
			$.download(Drupal.settings.clustalw.clustalwPath+'/clustalwDownloadResults.php', 'id='+$("#jobId").text()+'&type=tree' );
		});

		// download results
		$("#download").live("click",function (event) {
			$.download(Drupal.settings.clustalw.clustalwPath+'/clustalwDownloadResults.php', 'id='+$("#jobId").text()+'&type=align' );
		});

		// send results to hmmer
		$("#sendToHMMer").live("click",function (event) {
			$.customPost('/content/hmmer', 'id='+$("#jobId").text() );
		});


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

	});
})(jQuery);