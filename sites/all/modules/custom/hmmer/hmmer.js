(function ($) {
	$(document).ready(function () {


		// attempt to guess sequence type
		$("#edit-sequence").live("mouseout",function (event) {
			// lets make this easy: remove all the headers then see what we have left
			var fasta=$("#edit-sequence").val();
			var re = new RegExp("(>.*)","g");
			fasta=fasta.replace(re, "");

			// now if we only have atgcn-\s\r\n we've got ourselves some dna sequence
			var dna = /^[ACGTN-\s\r\n]+$/ig;

			// check the dna type if we have dna
			if(dna.test(fasta)){
				$('input:radio[name="type"]:[value="DNA"]').attr('checked',true);
			}else{
				$('input:radio[name="type"]:[value="PROTEIN"]').attr('checked',true);
			}
			$('#edit-type').trigger('click');

		});




		// set default values depending on which kind of cut-off is selected
		$("#edit-cutoff").live("click",function (event) {
				//alert($('input:radio[name="cutoff"]:checked').val());

			if( $('input:radio[name="cutoff"]:checked').val()=='evalue'){
				//evale selected
				$('#edit-sigsequence').val("0.01");
				$('#edit-sighit').val("0.03");
				$('#edit-reportsequence').val("1");
				$('#edit-reporthit').val("1");
			}else{
				//bit score selected
				$('#edit-sigsequence').val("25");
				$('#edit-sighit').val("22");
				$('#edit-reportsequence').val("7");
				$('#edit-reporthit').val("5");
			}
		});


		// let users know using dna sequence is at their own risk
		// also disable hmmsearch for dna sequences
		$("#edit-type").live("click",function (event) {
			if( $('input:radio[name="type"]:checked').val()=='DNA'){
				//DNA selected, display warning, select phmmer program
				$('#warning').css("display","inline");
				$('input:radio[name="program"]:[value="phmmer"]').attr('checked',true);
				$('#edit-program-hmmsearch').attr('disabled','disabled');
			}else{
				//peptide selected, hide warning, allow both programs to be selected
				$('#warning').css("display","none");
				$('#edit-program-hmmsearch').removeAttr('disabled');

			}
		});


	});
})(jQuery);