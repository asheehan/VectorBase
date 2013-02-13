<?
//error_reporting(E_ALL);

function print_form()
{
	echo "<form method=\"GET\" action=\"AnoXcel.php\">";
	echo "<table align=\"center\" width=\"40%\">\n";
	echo "<tr><td style=\"font-size:12px; font-weight:bold;\">AnoXcel (build AgamP3)</td></tr>\n";
	echo "<tr><td bgcolor=\"#CCCCEE\" height=\"2\"></td></tr>";
	echo "<tr><td class=\"cell_key\">";
	echo "<br>AnoXcel is a database of the conceptually translated proteome of Anopheles gambiae developed by Dr. Jose Ribeiro (NIAID).";
	echo "<br><br>You may search the database using gene ID, proteinID, protein keywords, or GO terms.<br><br></td></tr></table>";
	echo "<br><br><table align=\"center\"><tr><td class=\"cell_key\">";
	echo "<select name=field>";
	echo "<option value=GENE>Gene ID</option>";
	echo "<option value=PEPTIDE>Peptide ID</option>";
	echo "<option value=DESC>Description</option>";
	echo "<option value=KW>Key words</option>";
	echo "<option value=GO>GO term</option>";
	echo "</select></td>";
	echo "<td><input type=text length=20 name=query></td>";
	echo "<td colspan=\"2\" align=\"right\"><input type=submit value=\"Search\">";
	echo "</td></tr></table>";
	echo "</form>";
}


function get_ensembl_id( $id )
{
	while( strlen( $id ) < 11 )
		$id = "0".$id;

	return $id;
}


function print_record( $myrow )
{
echo "<br><br>\n<table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">\n";
echo "<tr><td>Sequence name</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Seqname]\">$myrow[Seqname]</a></td></tr>\n";
echo "<tr><td>First residue</td><td class=\"cell_value\">$myrow[first_res]</td></tr>\n";
echo "<tr><td>Description</td><td class=\"cell_value\">$myrow[Descr]</td></tr>\n";
echo "<tr><td>CDS name and link to nucleotide data</td><td class=\"cell_value\"><a href=\"$myrow[HYP_CDS]\">$myrow[CDS]</a></td></tr>\n";
echo "<tr><td>Description</td><td class=\"cell_value\">$myrow[Descr_CDS]</td></tr>\n";
echo "<tr><td>ATG?</td><td class=\"cell_value\">$myrow[ATG]</td></tr>\n";
echo "<tr><td>Stop?</td><td class=\"cell_value\">$myrow[Stop]</td></tr>\n";
echo "<tr><td>Best match to AG-CDS </td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_AGCDS]\">$myrow[BM_to_AGCDS]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\">$myrow[Eval_AGCDS]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_AGCDS]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_AGCDS]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_BM_AGCDS]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_AGCDS]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_AGCDS]</td></tr>\n";
echo "<tr><td>First residue of match - UTR overhang</td><td class=\"cell_value\">$myrow[fist_res_UTR_AGCDS]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[fist_res_sequence_AGCDS]</td></tr>\n";
echo "<tr><td>Link to whole gene + 2000nt 5' + 200nt 3'</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Link_to_gene_AGCDS]\">$myrow[Link_to_gene_AGCDS]</a></td></tr>\n";
echo "<tr><td>Link to 5' 2,000 nt</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Link_to_2kb_upstream_AGCDS]\">$myrow[Link_to_2kb_upstream_AGCDS]</a></td></tr>\n";
echo "<tr><td>Link to 3' 200 nt</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Link_to_200bp_downstream_AGCDS]\">$myrow[Link_to_200bp_downstream_AGCDS]</a></td></tr>\n";
echo "<tr><td>Gene name and view at VectorBase</td><td class=\"cell_value\"><a href=\"$myrow[HYP_GeneView]\">$myrow[GeneView]</a></td></tr>\n";
echo "<tr><td>Protein view at VectorBase</td><td class=\"cell_value\"><a href=\"$myrow[HYP_ProteinView]\">$myrow[ProteinView]</a></td></tr>\n";
echo "<tr><td>Chromosome</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Chr]\">$myrow[Chr]</a></td></tr>\n";
echo "<tr><td>For or Rev</td><td class=\"cell_value\">$myrow[For_or_Rev]</td></tr>\n";
echo "<tr><td>Location</td><td class=\"cell_value\">$myrow[Location]</td></tr>\n";
echo "<tr><td>Exon locations</td><td class=\"cell_value\">$myrow[Exon_locations]</td></tr>\n";
echo "<tr><td>Number of introns and link to fasta file</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Number_of_introns]\">$myrow[Number_of_introns]</a></td></tr>\n";
echo "<tr><td>intron lengths</td><td class=\"cell_value\">$myrow[Intron_lengths]</td></tr>\n";
echo "<tr><td>Start</td><td class=\"cell_value\">$myrow[Start]</td></tr>\n";
echo "<tr><td>End</td><td class=\"cell_value\">$myrow[End]</td></tr>\n";
echo "<tr><td>Gene length</td><td class=\"cell_value\">$myrow[Gene_length]</td></tr>\n";
echo "<tr><td>Protein size</td><td class=\"cell_value\">$myrow[Protein_size]</td></tr>\n";
echo "<tr><td>Complexity index</td><td class=\"cell_value\">$myrow[Complexity_index]</td></tr>\n";
echo "<tr><td>Increased AA (fold over average usage)</td><td class=\"cell_value\">$myrow[Increased_AA_fold_over_average]</td></tr>\n";
echo "<tr><td>Cys number</td><td class=\"cell_value\">$myrow[Cys_number]</td></tr>\n";
echo "<tr><td>SigP Result</td><td class=\"cell_value\"><a href=\"$myrow[HYP_SigP_result]\">$myrow[SigP_result]</a></td></tr>\n";
echo "<tr><td>Cleavage Position</td><td class=\"cell_value\">$myrow[Cleavage]</td></tr>\n";
echo "<tr><td>MW</td><td class=\"cell_value\">$myrow[MW]</td></tr>\n";
echo "<tr><td>pI</td><td class=\"cell_value\">$myrow[pI]</td></tr>\n";
echo "<tr><td>Mature MW</td><td class=\"cell_value\">$myrow[Mature_MW]</td></tr>\n";
echo "<tr><td>pI</td><td class=\"cell_value\">$myrow[Mature_pI]</td></tr>\n";
echo "<tr><td>TMHMM result</td><td class=\"cell_value\">$myrow[TMHMM]</td></tr>\n";
echo "<tr><td>Predicted helices</td><td class=\"cell_value\">$myrow[Pred_helices]</td></tr>\n";
echo "<tr><td>% membrane</td><td class=\"cell_value\">$myrow[per_membrane]</td></tr>\n";
echo "<tr><td>% outside</td><td class=\"cell_value\">$myrow[per_outside]</td></tr>\n";
echo "<tr><td>% inside</td><td class=\"cell_value\">$myrow[per_inside]</td></tr>\n";
echo "<tr><td>Best match to NR protein database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_NR]\">$myrow[BM_to_NR]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_NR]\">$myrow[Eval_NR]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_NR]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_NR]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_NR]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_of_BM_NR]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_NR]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_NR]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[firstst_res_NR]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_NR]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_NR]</td></tr>\n";
echo "<tr><td>Species</td><td class=\"cell_value\">$myrow[Species]</td></tr>\n";
echo "<tr><td>Key words</td><td class=\"cell_value\">$myrow[Key_words]</td></tr>\n";
echo "<tr><td>Best match to SWISSP database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_SWISS]\">$myrow[BM_to_SWISS]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_SWISS]\">$myrow[Eval_SWISS]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_SWISS]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_SWISS]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_SWISS]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_SWISS]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_SWISS]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_SWISS]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_SWISS]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_SWISS]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_SWISS]</td></tr>\n";
echo "<tr><td>PROSITE motifs</td><td class=\"cell_value\">$myrow[PROSITE_motifs]</td></tr>\n";
echo "<tr><td>Non promiscuous prosite motifs</td><td class=\"cell_value\"><a href=\"$myrow[HYP_PROSITE_motifs]\">$myrow[Non_promiscuous_motifs]</a></td></tr>\n";
echo "<tr><td>Best match to GO database</td><td class=\"cell_value\">$myrow[BM_to_GO]</td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\">$myrow[Eval_GO]</td></tr>\n";
echo "<tr><td>Function descriptors</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_GO]\">$myrow[Function_descr]</a></td></tr>\n";
echo "<tr><td>Function parent</td><td class=\"cell_value\">$myrow[Function_parent]</td></tr>\n";
echo "<tr><td>Function second parent</td><td class=\"cell_value\">$myrow[Function_2nd_parent]</td></tr>\n";
echo "<tr><td>GO #</td><td class=\"cell_value\">$myrow[GO_num]</td></tr>\n";
echo "<tr><td>E value of functional GO</td><td class=\"cell_value\">$myrow[Eval_function_GO]</td></tr>\n";
echo "<tr><td>Component descriptors</td><td class=\"cell_value\">$myrow[CC_descr]</td></tr>\n";
echo "<tr><td>Component parent</td><td class=\"cell_value\">$myrow[CC_parent]</td></tr>\n";
echo "<tr><td>Component second parent</td><td class=\"cell_value\">$myrow[CC_2nd_parent]</td></tr>\n";
echo "<tr><td>GO #</td><td class=\"cell_value\">$myrow[GO_process_num]</td></tr>\n";
echo "<tr><td>E value of component GO</td><td class=\"cell_value\">$myrow[Eval_CC_GO]</td></tr>\n";
echo "<tr><td>Process descriptors</td><td class=\"cell_value\">$myrow[Process_descr]</td></tr>\n";
echo "<tr><td>Process parent</td><td class=\"cell_value\">$myrow[Process_parent]</td></tr>\n";
echo "<tr><td>Process second parent</td><td class=\"cell_value\">$myrow[Process_2nd_parent]</td></tr>\n";
echo "<tr><td>GO #</td><td class=\"cell_value\">$myrow[GO_proc_num]</td></tr>\n";
echo "<tr><td>E value of process GO</td><td class=\"cell_value\">$myrow[Eval_process_GO]</td></tr>\n";
echo "<tr><td>Best match to KOG database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_KOG]\">$myrow[BM_to_KOG]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_KOG]\">$myrow[Eval_KOG]</a></td></tr>\n";
echo "<tr><td>General class</td><td class=\"cell_value\">$myrow[General_class]</td></tr>\n";
echo "<tr><td>Best match to PFAM database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_PFAM]\">$myrow[BM_to_PFAM]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_PFAM]\">$myrow[Eval_PFAM]</a></td></tr>\n";
echo "<tr><td>Best match to SMART database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_SMART]\">$myrow[BM_to_SMART]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_SMART]\">$myrow[Eval_SMART]</a></td></tr>\n";
echo "<tr><td>Best match to AEGY-PEP database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_AEGYPEP]\">$myrow[BM_to_AEGYPEP]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\">$myrow[Eval_AEGYPEP]</td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_AEGYPEP]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_AEGYPEP]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_AEGYPEP]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_AEGYPEP]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_AEGYPEP]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_AEGYPEP]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_AEGYPEP]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_AEGYPEP]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_AEGYPEP]</td></tr>\n";
echo "<tr><td>Best match to DMPROT database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_DMPROT]\">$myrow[BM_to_DMPROT]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_DMPROT]\">$myrow[Eval_DMPROT]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_DMPROT]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_DMPROT]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_DMPROT]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_DMPROT]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_DMPROT]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_DMPROT]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_DMPROT]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_DMPROT]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_DMPROT]</td></tr>\n";
echo "<tr><td>Best match to CELEG database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_CELEG]\">$myrow[BM_to_CELEG]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_CELEG]\">$myrow[Eval_CELEG]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_CELEG]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_CELEG]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_CELEG]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_CELEG]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_CELEG]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_legth_CELEG]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_CELEG]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_CELEG]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_CELEG]</td></tr>\n";
echo "<tr><td>Best match to ARAB database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_ARAB]\">$myrow[BM_to_ARAB]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_ARAB]\">$myrow[Eval_ARAB]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_ARAB]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_ARAB]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_ARAB]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_ARAB]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_ARAB]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_ARAB]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_ARAB]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_ARAB]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_ARAB]</td></tr>\n";
echo "<tr><td>Best match to YEAST database</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_YEAST]\">$myrow[BM_to_YEAST]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Eval_YEAST]\">$myrow[Eval_YEAST]</a></td></tr>\n";
echo "<tr><td>Match</td><td class=\"cell_value\">$myrow[Match_YEAST]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_YEAST]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_YEAST]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_YEAST]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_YEAST]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_YEAST]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_YEAST]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_YEAST]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_YEAST]</td></tr>\n";
echo "<tr><td>Best match to clusterized An. gambiae ESTs from different libraries</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_AGEST]\">$myrow[BM_to_AGEST]</a></td></tr>\n";
echo "<tr><td>E value</td><td class=\"cell_value\">$myrow[Eval_AGEST]</td></tr>\n";
echo "<tr><td>Score</td><td class=\"cell_value\">$myrow[Score_AGEST]</td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\">$myrow[Extent_AGEST]</td></tr>\n";
echo "<tr><td>Length of best match</td><td class=\"cell_value\">$myrow[Length_AGEST]</td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_AGEST]</td></tr>\n";
echo "<tr><td>% Match length</td><td class=\"cell_value\">$myrow[per_Match_length_AGEST]</td></tr>\n";
echo "<tr><td>First residue of match</td><td class=\"cell_value\">$myrow[first_res_AGEST]</td></tr>\n";
echo "<tr><td>First residue of sequence</td><td class=\"cell_value\">$myrow[first_res_seq_AGEST]</td></tr>\n";
echo "<tr><td>Number of segments</td><td class=\"cell_value\">$myrow[Segments_AGEST]</td></tr>\n";
echo "<tr><td>Orientation of output</td><td class=\"cell_value\">$myrow[Orientation_of_output]</td></tr>\n";
echo "<tr><td>Satisfied 95% id on length 100</td><td class=\"cell_value\">$myrow[ninetyfive_id_on_100]</td></tr>\n";
echo "<tr><td>Number of sequences on assembled contig</td><td class=\"cell_value\">$myrow[Seqs_on_contig]</td></tr>\n";
echo "<tr><td>ESTs coming from from all-instars library</td><td class=\"cell_value\">$myrow[All_instars]</td></tr>\n";
echo "<tr><td>Blood-abdomen library</td><td class=\"cell_value\">$myrow[Blood_abdomen]</td></tr>\n";
echo "<tr><td>Sugar-abd library</td><td class=\"cell_value\">$myrow[Sugar_abdomen]</td></tr>\n";
echo "<tr><td>Infected blood-abd library</td><td class=\"cell_value\">$myrow[Infected_blood_abdomen]</td></tr>\n";
echo "<tr><td>Big blood fed library</td><td class=\"cell_value\">$myrow[Big_blood_fed]</td></tr>\n";
echo "<tr><td>Big non blood fed library</td><td class=\"cell_value\">$myrow[Big_non_blood_fed]</td></tr>\n";
echo "<tr><td>Head library</td><td class=\"cell_value\">$myrow[Head]</td></tr>\n";
echo "<tr><td>Immune cells</td><td class=\"cell_value\">$myrow[Immune_cells]</td></tr>\n";
echo "<tr><td>Normalized-fatbody</td><td class=\"cell_value\">$myrow[Normalized_fat_body]</td></tr>\n";
echo "<tr><td>Female salivary glands</td><td class=\"cell_value\">$myrow[Female_salivary_glands]</td></tr>\n";
echo "<tr><td>Male salivary glands</td><td class=\"cell_value\">$myrow[Male_salivary_glands]</td></tr>\n";
echo "<tr><td>Best match to Affymetrix chip</td><td class=\"cell_value\"><a href=\"$myrow[HYP_BM_to_AFFY]\">$myrow[BM_to_AFFY]</a></td></tr>\n";
echo "<tr><td>Extent of match</td><td class=\"cell_value\"><a href=\"$myrow[HYP_Exntent_AFFY]\">$myrow[Exntent_AFFY]</a></td></tr>\n";
echo "<tr><td>% identity</td><td class=\"cell_value\">$myrow[identity_AFFY]</td></tr>\n";
echo "<tr><td>Larva-mean</td><td class=\"cell_value\">$myrow[Larvamean]</td></tr>\n";
echo "<tr><td>Males-mean</td><td class=\"cell_value\">$myrow[Malesmean]</td></tr>\n";
echo "<tr><td>Sugar-fed females-mean</td><td class=\"cell_value\">$myrow[Sugarfed_femalesmean]</td></tr>\n";
echo "<tr><td>Blood-fed 3h-mean</td><td class=\"cell_value\">$myrow[Bloodfed_females_3h_mean]</td></tr>\n";
echo "<tr><td>24h-mean</td><td class=\"cell_value\">$myrow[twentyfourh_mean]</td></tr>\n";
echo "<tr><td>48h-mean</td><td class=\"cell_value\">$myrow[fortyeighth_mean]</td></tr>\n";
echo "<tr><td>72h-mean</td><td class=\"cell_value\">$myrow[seventytwoh_mean]</td></tr>\n";
echo "<tr><td>15d-mean</td><td class=\"cell_value\">$myrow[fifteend_mean]</td></tr>\n";
echo "<tr><td>Fat bodies-mean</td><td class=\"cell_value\">$myrow[Fat_bodies_mean]</td></tr>\n";
echo "<tr><td>Midgut-mean</td><td class=\"cell_value\">$myrow[Midgut_mean]</td></tr>\n";
echo "<tr><td>Ovaries-mean</td><td class=\"cell_value\">$myrow[Ovaries_mean]</td></tr>\n";
echo "<tr><td>Clustered at 35%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\">$myrow[thirtyfive_sim_on_60_length_clusters]</td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_35_on_60]\">$myrow[num_seqs_35_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 45%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_45_sim_on_60_length_clusters]\">$myrow[fortyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_45_on_60]\">$myrow[num_seqs_45_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 55%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_55_sim_on_60_length_clusters]\">$myrow[fiftyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_55_on_60]\">$myrow[num_seqs_55_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 65%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_65_sim_on_60_length_clusters]\">$myrow[sixtyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_65_on_60]\">$myrow[num_seqs_65_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 75%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_75_sim_on_60_length_clusters]\">$myrow[seventyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_75_on_60]\">$myrow[num_seqs_75_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 85%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_85_sim_on_60_length_clusters]\">$myrow[eightyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_85_on_60]\">$myrow[num_seqs_85_on_60]</a></td></tr>\n";
echo "<tr><td>Clustered at 95%-Sim- on 60% of length - - Cluster#</td><td class=\"cell_value\"><a href=\"$myrow[HYP_95_sim_on_60_length_clusters]\">$myrow[ninetyfive_sim_on_60_length_clusters]</a></td></tr>\n";
echo "<tr><td>Number of sequences</td><td class=\"cell_value\"><a href=\"$myrow[HYP_num_seqs_95_on_60]\">$myrow[num_seqs_95_on_60]</a></td></tr>\n";
echo "</table>\n<br><br>\n";

}

function print_list( $anoxcel_rs )
{
	echo "<br><br><table border=\"1\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
	while( ( $myrow = mysql_fetch_assoc( $anoxcel_rs ) ) == true )
	{
		echo "<tr><td><a href=\"AnoXcel.php?field=PEPTIDE&query=".$myrow[ProteinView];
		echo "\">$myrow[ProteinView]</a><br>";
		echo "$myrow[link_to_ensembl_gene]</td>";
		echo "<td>$myrow[BM_to_NR]</td>";
		echo "<td>$myrow[Key_words]</td>";
		echo "<td>$myrow[BM_to_GO]</td></tr>\n";
	}
	echo "</table>\n<br><br>\n";
}


function get_results( $sql )
{

	$db = mysql_connect ( "db.vectorbase.org", "db_public", "limecat" );
	mysql_select_db ( "anobase", $db );

	$sql = "SELECT * FROM AnoXcel_v45 WHERE ".$sql;

	$anoxcel_rs = mysql_query( $sql, $db );
	
	$rows = mysql_num_rows( $anoxcel_rs );


	switch( $rows )
	{
		case 0:
			echo "No records found.";
			print_form();
			return;
		case 1:
			$myrow = mysql_fetch_array( $anoxcel_rs );
			print_record( $myrow );
			return;
		case $rows>1:
			print_list( $anoxcel_rs );
			return;
	}
	
}





$sql = "";

if ( isset ( $_GET[ 'field' ], $_GET[ 'query' ] ) )

	switch( $_GET[ 'field' ] )	{

		case 'PEPTIDE':
			$sql .= "ProteinView='".strtoupper( $_GET['query'])."'";
			break;
		
		case 'GENE':
			$sql .= "GeneView='".strtoupper( $_GET['query'])."'";
			break;
		
		case 'DESC':
			$sql .= "BM_to_NR LIKE '%".$_GET['query']."%'";
			break;
		
		case 'KW':
			$sql .= "Key_words LIKE '%".$_GET['query']."%'";
			break;
	
		case 'GO':
			$sql .= "BM_to_GO LIKE '%".$_GET['query']."%'";
			break;
	}

if ( $sql != "" )
	get_results( $sql );
else
	print_form();
?>
