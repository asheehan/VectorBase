<?
	$blast_programs["blastn"]["query"]="NUCLEOTIDE";
	$blast_programs["blastn"]["database"]="NUCLEOTIDE";
	$blast_programs["blastn"]["description"]="Nucleotide vs. Nucleotide";

	$blast_programs["tblastn"]["query"]="PEPTIDE";
	$blast_programs["tblastn"]["database"]="NUCLEOTIDE";
	$blast_programs["tblastn"]["description"]="Peptide vs. Translated Nucleotide";
	
	$blast_programs["tblastx"]["query"]="NUCLEOTIDE";
	$blast_programs["tblastx"]["database"]="NUCLEOTIDE";
	$blast_programs["tblastx"]["description"]="Translated Nucleotide vs. Translated Nucleotide";

	$blast_programs["blastp"]["query"]="PEPTIDE";
	$blast_programs["blastp"]["database"]="PEPTIDE";
	$blast_programs["blastp"]["description"]="Peptide vs. Peptide";
	
	$blast_programs["blastx"]["query"]="NUCLEOTIDE";
	$blast_programs["blastx"]["database"]="PEPTIDE";
	$blast_programs["blastx"]["description"]="Translated Nucleotide vs. Peptide";
?>