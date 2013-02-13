<?
//error_reporting(E_ALL);

function print_form()
{
	echo "<br><form method=\"GET\" action=\"ReAnoXcel.php\">\n";
	echo "<table align=\"center\" width=\"40%\">\n";
	echo "<tr><td style=\"font-size:12px; font-weight:bold;\">ReAnoXcel (build AgamP3)</td></tr>\n";
	echo "<tr><td bgcolor=\"#CCCCEE\" height=\"2\"></td></tr>";
	echo "<tr><td class=\"cell_key\">";
	echo "<br>ReAnoXcel is a database of the conceptually translated proteome of A. gambiae  developed by Dr. Jose Ribeiro (NIAID) using Ken Vernick's (University of Minnesota) annotation pipeline.";
	echo "<br><br>You may search the database using ENSANGP, sequence ID, and GO terms.<br><br></td></tr></table>";
	echo "<br><br><table align=\"center\" width=\"40%\"><tr><td class=\"cell_key\">";
	echo "<select name=field>";
	echo "<option value=P>ENSANGP</option>";
	echo "<option value=S>Sequence ID</option>";
	echo "<option value=GO>GO term</option>";
	echo "</select></td>";
	echo "<td><input type=text length=20 name=query></td>";
	echo "<td colspan=\"2\" align=\"right\"><input type=submit value=\"Search\">";
	echo "</td></tr></table>";
	echo "</form>";
}


function get_ensembl_id( $type, $id )
{
		if ( $type == "ENSANGP" && strpos( $id, $type ) !== 0 )	{
			while( strlen( $id ) < 11 )
				$id = "0".$id;
			$id = "ENSANGP".$id;
		}

	return $id;
}


function print_record( $myrow )
{

echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
echo "<tr><td class=\"cell_key\" width=\"30%\">Gene ID</td><td class=\"cell_value\">";
echo "<a href=\"http://agambiae.vectorbase.org/Genome/GeneView/?db=core;gene=".$myrow["Gene_and_link_to_Ensembl"]."\">" . $myrow["Gene_and_link_to_Ensembl"] . "</a></td></tr>";


echo "<tr><td class=\"cell_key\">CDS sequence</td><td class=\"cell_value\">$myrow[CDS_sequence]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Seq size</td><td class=\"cell_value\">$myrow[Seq_size]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Stop codon</td><td class=\"cell_value\">$myrow[Stop_codon_]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Description</td><td class=\"cell_value\">$myrow[Description]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to fragmented An gambiae genome</td><td class=\"cell_value\">$myrow[Best_match_to_fragmented_An_gambiae_genome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value faga</td><td class=\"cell_value\">$myrow[E_value_faga]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Extent of match faga</td><td class=\"cell_value\">$myrow[Extent_of_match_faga]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity faga</td><td class=\"cell_value\">$myrow[per_identity_faga]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Orientation of assembled output faga</td><td class=\"cell_value\">$myrow[Orientation_of_assembled_output_faga]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Chromosome and link to ENSEMBL</td><td class=\"cell_value\">$myrow[Chromosome_and_link_to_ENSEMBL]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Start of larger exon</td><td class=\"cell_value\">$myrow[Start_of_larger_exon]</td></tr>\n";
echo "<tr><td class=\"cell_key\">End of larger exon</td><td class=\"cell_value\">$myrow[End_of_larger_exon]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Protein sequence</td><td class=\"cell_value\">$myrow[Protein_sequence]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue</td><td class=\"cell_value\">$myrow[First_residue]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Seq size pr</td><td class=\"cell_value\">$myrow[Seq_size_pr]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Predicted TyrSO4 Prosite rules</td><td class=\"cell_value\">$myrow[Predicted_TyrSO4__Prosite_rules]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Sum of residues 0 is complex 1 is biased AA usage</td><td class=\"cell_value\">$myrow[Sum_of_residues_0_is_complex_1_is_biased_AA_usage]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Increased AA fold over average</td><td class=\"cell_value\">$myrow[Increased_AA_fold_over_average]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Cys number</td><td class=\"cell_value\">$myrow[Cys_number]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Ser_and_Thr</td><td class=\"cell_value\">$myrow[per_Ser_and_Thr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Pro</td><td class=\"cell_value\">$myrow[per_Pro]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Gly</td><td class=\"cell_value\">$myrow[per_Gly]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per GlyandPro</td><td class=\"cell_value\">$myrow[per_GlyandPro]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Cleavage_Position</td><td class=\"cell_value\">$myrow[Cleavage_Position]</td></tr>\n";

echo "<tr><td class=\"cell_key\">MW</td><td class=\"cell_value\">$myrow[MW]</td></tr>\n";
echo "<tr><td class=\"cell_key\">pI</td><td class=\"cell_value\">$myrow[pI]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Mature MW</td><td class=\"cell_value\">$myrow[Mature_MW]</td></tr>\n";
echo "<tr><td class=\"cell_key\">pI mature</td><td class=\"cell_value\">$myrow[pI_mature]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Predicted helices</td><td class=\"cell_value\">$myrow[Predicted_helices]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per membrane</td><td class=\"cell_value\">$myrow[per_membrane]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per outside</td><td class=\"cell_value\">$myrow[per_outside]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per inside</td><td class=\"cell_value\">$myrow[per_inside]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to NR_protein_database_including_ENSANGP_proteins</td><td class=\"cell_value\">$myrow[Best_match_to_NR_protein_database_including_ENSANGP_proteins]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value nri</td><td class=\"cell_value\">$myrow[E_value_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match nri</td><td class=\"cell_value\">$myrow[Match_nri]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Extent of match nri</td><td class=\"cell_value\">$myrow[Extent_of_match_nri]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Length of best match nri</td><td class=\"cell_value\">$myrow[Length_of_best_match_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity nri</td><td class=\"cell_value\">$myrow[per_identity_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length nri</td><td class=\"cell_value\">$myrow[per_Match_length_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of match nri</td><td class=\"cell_value\">$myrow[First_residue_of_match_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of sequence nri</td><td class=\"cell_value\">$myrow[First_residue_of_sequence_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Key words nri</td><td class=\"cell_value\">$myrow[Key_words_nri]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Species</td><td class=\"cell_value\">$myrow[Species]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to NR protein database excluding ENSANGP sequences</td><td class=\"cell_value\">$myrow[Best_match_to_NR_protein_database_excluding_ENSANGP_sequences]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value nre</td><td class=\"cell_value\">$myrow[E_value_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match nre</td><td class=\"cell_value\">$myrow[Match_nre]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Length of best match nre</td><td class=\"cell_value\">$myrow[Length_of_best_match_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity nre</td><td class=\"cell_value\">$myrow[per_identity_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length nre</td><td class=\"cell_value\">$myrow[per_Match_length_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of match nre</td><td class=\"cell_value\">$myrow[First_residue_of_match_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of sequence nre</td><td class=\"cell_value\">$myrow[First_residue_of_sequence_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Key words nre</td><td class=\"cell_value\">$myrow[Key_words_nre]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Taxonomic blast</td><td class=\"cell_value\">$myrow[Taxonomic_blast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">EC number and link to KEGG</td><td class=\"cell_value\">$myrow[EC_number_and_link_to_KEGG]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to GO database</td><td class=\"cell_value\">$myrow[Best_match_to_GO_database]</td></tr>\n";

echo "<tr><td class=\"cell_key\">E value go</td><td class=\"cell_value\">$myrow[E_value_go]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Function descriptors</td><td class=\"cell_value\">$myrow[Function_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of functional GO</td><td class=\"cell_value\">$myrow[E_value_of_functional_GO]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Component descriptors</td><td class=\"cell_value\">$myrow[Component_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of component GO</td><td class=\"cell_value\">$myrow[E_value_of_component_GO]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Process descriptors</td><td class=\"cell_value\">$myrow[Process_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of process GO</td><td class=\"cell_value\">$myrow[E_value_of_process_GO]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to KOG database</td><td class=\"cell_value\">$myrow[Best_match_to_KOG_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value kog</td><td class=\"cell_value\">$myrow[E_value_kog]</td></tr>\n";
echo "<tr><td class=\"cell_key\">General class kog</td><td class=\"cell_value\">$myrow[General_class_kog]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to CDD database</td><td class=\"cell_value\">$myrow[Best_match_to_CDD_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value cdd</td><td class=\"cell_value\">$myrow[E_value_cdd]</td></tr>\n";
echo "<tr><td class=\"cell_key\">All CDD domains</td><td class=\"cell_value\">$myrow[All_CDD_domains]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to PFAM database</td><td class=\"cell_value\">$myrow[Best_match_to_PFAM_database]</td></tr>\n";

echo "<tr><td class=\"cell_key\">E value pfam</td><td class=\"cell_value\">$myrow[E_value_pfam]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to SMART database</td><td class=\"cell_value\">$myrow[Best_match_to_SMART_database]</td></tr>\n";

echo "<tr><td class=\"cell_key\">E value smart</td><td class=\"cell_value\">$myrow[E_value_smart]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to A_gambiae_proteome_of_Sep2006</td><td class=\"cell_value\">$myrow[Best_match_to_A_gambiae_proteome_of_Sep2006]</td></tr>\n";

echo "<tr><td class=\"cell_key\">E value agap</td><td class=\"cell_value\">$myrow[E_value_agap]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity agap</td><td class=\"cell_value\">$myrow[per_identity_agap]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match length agap</td><td class=\"cell_value\">$myrow[per_Match_length_agap]</td></tr>\n";

echo "<tr><td class=\"cell_key\">First residue of match agap</td><td class=\"cell_value\">$myrow[First_residue_of_match_agap]</td></tr>\n";

echo "<tr><td class=\"cell_key\">First residue of sequence agap</td><td class=\"cell_value\">$myrow[First_residue_of_sequence_agap]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to Ae_aegypti proteome</td><td class=\"cell_value\">$myrow[Best_match_to_Ae_aegypti_proteome]</td></tr>\n";

echo "<tr><td class=\"cell_key\">E value aed</td><td class=\"cell_value\">$myrow[E_value_aed]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Match aed</td><td class=\"cell_value\">$myrow[Match_aed]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity aed</td><td class=\"cell_value\">$myrow[per_identity_aed]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length aed</td><td class=\"cell_value\">$myrow[per_Match_length_aed]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to D melanogaster proteome</td><td class=\"cell_value\">$myrow[Best_match_to_D_melanogaster_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value and link to FlyBase</td><td class=\"cell_value\">$myrow[E_value_and_link_to_FlyBase]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity dmel</td><td class=\"cell_value\">$myrow[per_identity_dmel]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match length dmel</td><td class=\"cell_value\">$myrow[per_Match_length_dmel]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Best match to A_thaliana database</td><td class=\"cell_value\">$myrow[Best_match_to_A_thaliana_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value and link to TAIR</td><td class=\"cell_value\">$myrow[E_value_and_link_to_TAIR]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match ara</td><td class=\"cell_value\">$myrow[Match_ara]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity ara</td><td class=\"cell_value\">$myrow[per_identity_ara]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match length ara</td><td class=\"cell_value\">$myrow[per_Match_length_ara]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to C. elegans database</td><td class=\"cell_value\">$myrow[Best_match_to_C_elegans_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value and link to WormBase</td><td class=\"cell_value\">$myrow[E_value_and_link_to_WormBase]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Match worm</td><td class=\"cell_value\">$myrow[Match_worm]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity worm</td><td class=\"cell_value\">$myrow[per_identity_worm]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match_length worm</td><td class=\"cell_value\">$myrow[per_Match_length_worm]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to S cerevisae proteome</td><td class=\"cell_value\">$myrow[Best_match_to_S_cerevisae_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value and link to Expasy</td><td class=\"cell_value\">$myrow[E_value_and_link_to_Expasy]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Match yeast</td><td class=\"cell_value\">$myrow[Match_yeast]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity yeast</td><td class=\"cell_value\">$myrow[per_identity_yeast]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match length yeast</td><td class=\"cell_value\">$myrow[per_Match_length_yeast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to Human proteome homo</td><td class=\"cell_value\">$myrow[Best_match_to_Human_proteome_homo]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value homo</td><td class=\"cell_value\">$myrow[E_value_homo]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Match homo</td><td class=\"cell_value\">$myrow[Match_homo]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity homo</td><td class=\"cell_value\">$myrow[per_identity_homo]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per Match length homo</td><td class=\"cell_value\">$myrow[per_Match_length_homo]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to affymetrix chip consensus sequences</td><td class=\"cell_value\">$myrow[Best_match_to_affymetrix_chip_consensus_sequences]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Length of best match affy</td><td class=\"cell_value\">$myrow[Length_of_best_match_affy]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity affy</td><td class=\"cell_value\">$myrow[per_identity_affy]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Larvae mean</td><td class=\"cell_value\">$myrow[Larvaemean]</td></tr>\n";

echo "<tr><td class=\"cell_key\">Males mean</td><td class=\"cell_value\">$myrow[Malesmean]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Sugar fed mean</td><td class=\"cell_value\">$myrow[Sugar_fedmean]</td></tr>\n";
echo "<tr><td class=\"cell_key\">3h Blood fed mean</td><td class=\"cell_value\">$myrow[Blood_fed__mean_3h]</td></tr>\n";

echo "<tr><td class=\"cell_key\">24h mean</td><td class=\"cell_value\">$myrow[hmean_24h]</td></tr>\n";

echo "<tr><td class=\"cell_key\">48h mean</td><td class=\"cell_value\">$myrow[mean_48h]</td></tr>\n";
echo "<tr><td class=\"cell_key\">72h mean</td><td class=\"cell_value\">$myrow[mean_72h]</td></tr>\n";
echo "<tr><td class=\"cell_key\">15d mean</td><td class=\"cell_value\">$myrow[mean_15d]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to 180000 clusterized A_gambiae ESTs</td><td class=\"cell_value\">$myrow[Best_match_to_180000_clusterized_A_gambiae_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value agaest</td><td class=\"cell_value\">$myrow[E_value_agaest]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Extent of match agaest</td><td class=\"cell_value\">$myrow[Extent_of_match_agaest]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Length of best match agaest</td><td class=\"cell_value\">$myrow[Length_of_best_match_agaest]</td></tr>\n";

echo "<tr><td class=\"cell_key\">per identity agaest</td><td class=\"cell_value\">$myrow[per_identity_agaest]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length agaest</td><td class=\"cell_value\">$myrow[per_Match_length_agaest]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of match agaest</td><td class=\"cell_value\">$myrow[First_residue_of_match_agaest]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of sequence agaest</td><td class=\"cell_value\">$myrow[First_residue_of_sequence_agaest]</td></tr>\n";

echo "<tr><td class=\"cell_key\">EST differs from prediction</td><td class=\"cell_value\">$myrow[EST_differs_from_prediction]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Orientation of assembled output</td><td class=\"cell_value\">$myrow[Orientation_of_assembled_output]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Satisfied 95 id on length of 100 nt</td><td class=\"cell_value\">$myrow[Satisfied_95_id_on_length_of_100_nt]</td></tr>\n";
echo "<tr><td class=\"cell_key\">all in stars</td><td class=\"cell_value\">$myrow[allinstars]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Blood abd</td><td class=\"cell_value\">$myrow[Bloodabd]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Sugar abd</td><td class=\"cell_value\">$myrow[Sugarabd]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Inf Blood abd</td><td class=\"cell_value\">$myrow[InfBloodabd]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Blood fed</td><td class=\"cell_value\">$myrow[Bloodfed]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Non Blood fed</td><td class=\"cell_value\">$myrow[NonBloodfed]</td></tr>\n";
echo "<tr><td class=\"cell_key\">head all</td><td class=\"cell_value\">$myrow[headall]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Immune cells</td><td class=\"cell_value\">$myrow[Immune_cells]</td></tr>\n";
echo "<tr><td class=\"cell_key\">normalized fat body</td><td class=\"cell_value\">$myrow[normalizedfatbody]</td></tr>\n";
echo "<tr><td class=\"cell_key\">SG female</td><td class=\"cell_value\">$myrow[SGfem]</td></tr>\n";
echo "<tr><td class=\"cell_key\">sg male</td><td class=\"cell_value\">$myrow[sgmale]</td></tr>\n";
echo "<tr><td class=\"cell_key\">SG Pasteur</td><td class=\"cell_value\">$myrow[SGPasteur]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Total salivary gland</td><td class=\"cell_value\">$myrow[Total_salivary_gland]</td></tr>\n";

echo "\n</table>\n<br>\n";
}


function print_list( $anoxcel_rs )
{
	echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
	echo "<tr><td class=\"cell_key\">Sequence ID</td><td class=\"cell_key\">Best match to GO</td></tr>";
	
	while( ( $myrow = mysql_fetch_assoc( $anoxcel_rs ) ) == true )
	{
		echo "<tr>";
		echo "<td class=\"cell_value\" valign=\"top\"><a href=ReAnoXcel.php?field=S&query=";
		echo "$myrow[CDS_sequence]>$myrow[CDS_sequence]</a></td>";
		echo "<td class=\"cell_value\" valign=\"top\">$myrow[Best_match_to_GO_database]</td></tr>\n";
	}
	echo "</table>";
}


function get_results( $sql )
{
	$db = mysql_connect ( "db.vectorbase.org", "db_public", "limecat" );
	mysql_select_db ( "AnoXcel", $db );

	$sql = "SELECT * FROM ReAno_AgamP3 WHERE ".$sql;
//	echo $sql;

	$anoxcel_rs = mysql_query( $sql, $db );
	
	$rows = mysql_num_rows( $anoxcel_rs );


	switch( $rows )
	{
		case 0:
			echo "<br><table align=\"center\"><tr><td><b>No matches found.</b></td></tr></table><br><br>";
			print_form();
			return;
		case 1:
			$myrow = mysql_fetch_array( $anoxcel_rs );
			print_record( $myrow );
			return;
		case $rows>1:
			if ( $rows >= 20 ) {
				echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
				echo "<tr><td class=\"cell_value\">Your search returned a large number of results. Only the first twenty are displayed.";
				echo "</td></tr></table>";
			}			print_list( $anoxcel_rs );
			return;
	}
}


$sql = "";

if ( isset ( $_GET[ 'field' ], $_GET[ 'query' ] ) )

	switch( $_GET[ 'field' ] )	{

		case 'P':
			$sql .= "Extent_of_match_nri='".get_ensembl_id( "ENSANGP", $_GET['query'])."' LIMIT 20";
			break;

		case 'S':
			$sql .= "CDS_sequence=".$_GET['query'];
			break;
	
		case 'GO':
			$sql .= "Best_match_to_GO_database LIKE '%".$_GET['query']."%' LIMIT 20";
			break;
	}

if ( $sql != "" )
	get_results( $sql );
else
	print_form();

?>
<br>
