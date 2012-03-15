
function isFastaNucleotide(fastaObject){
	// lets make this easy: remove all the headers then see what we have left
	var fasta=fastaObject.value;
	var re = new RegExp("(>.*)","g");
	fasta=fasta.replace(re, "");

	// now if we only have atgcn-\s\r\n we've got ourselves some dna sequence
	re = RegExp("^[ACGTN-\s\r\n]+$","ig");

	// check the dna type if we have dna
	if(re.test(fasta)){
	 document.getElementById("edit-type-dna").checked=true;
	}
}

