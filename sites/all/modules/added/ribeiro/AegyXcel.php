<?

//error_reporting(E_ALL);

function print_form()
{
	echo "<br><form method=\"GET\" action=\"AegyXcel.php\">\n";
	echo "<table align=\"center\" width=\"40%\">\n";
	echo "<tr><td style=\"font-size:12px; font-weight:bold;\">AegyXcel (build AaegL1)</td></tr>\n";
	echo "<tr><td bgcolor=\"#CCCCEE\" height=\"2\"></td></tr>";
	echo "<tr><td class=\"cell_key\">";
	echo "AegyXcel is a database of the conceptually translated proteome of Aedes aegypti developed by Dr. Jose Ribeiro (NIAID).";
	echo "<br><br>You may search the database using ENSANGG, ENSANGP, protein keywords, and GO terms.<br><br></td></tr></table>";
	echo "<table align=\"center\" width=\"40%\">";
	echo "<tr><td><select name=field>";
	echo "<option value=G>Gene ID</option>";
	echo "<option value=DESC>Description</option>";
	echo "<option value=KW>Key words</option>";
	echo "<option value=GO>GO term</option>";
	echo "</select></td>";
	echo "<td><input type=text length=20 name=query></td>";
	echo "<td colspan=\"2\" align=\"right\"><input type=submit value=\"Search\">";
	echo "</td></tr></table>";
	echo "</form>";
}



function get_gene_id( $id )
{
	if ( strpos( $id, "AAEL" ) !== 0 )	
	{ 
		while( strlen( $id ) < 6 )
			$id = "0".$id;
		$id = "AAEL".$id;
	}

	return $id;
}


function print_record( $myrow )
{

echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
echo "<tr><td class=\"cell_key\" width=\"30%\">Sequence name</td><td class=\"cell_value\">";
echo "<a href=\"http://aaegypti.vectorbase.org/Genome/GeneView/?gene=".substr( $myrow[Seq_name], 0, 10 ). "\">$myrow[Seq_name]</a></td></tr>";
echo "<tr><td class=\"cell_key\">Match to CDS                                   </td><td class=\"cell_value\">$myrow[Match_to_CDS]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Link to CDS                                    </td><td class=\"cell_value\">$myrow[Link_to_CDS]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Aedes aegypti genome match                     </td><td class=\"cell_value\">$myrow[Ae_aegypti_genome_match]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Start                                          </td><td class=\"cell_value\">$myrow[Start]</td></tr>\n";
echo "<tr><td class=\"cell_key\">End                                            </td><td class=\"cell_value\">$myrow[End]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to assembled EST database           </td><td class=\"cell_value\">$myrow[Best_match_to_assembled_EST_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value est                                    </td><td class=\"cell_value\">$myrow[E_value_est]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Extent of match est                            </td><td class=\"cell_value\">$myrow[Extent_of_match_est]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity est                               </td><td class=\"cell_value\">$myrow[per_identity_est]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length est                           </td><td class=\"cell_value\">$myrow[per_Match_length_est]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Corpora Allata ESTs                            </td><td class=\"cell_value\">$myrow[Corpora_Allata_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Antennal ESTs                                  </td><td class=\"cell_value\">$myrow[Antennal_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Normalized fat bodyESTs                        </td><td class=\"cell_value\">$myrow[Normalized_fat_bodyESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Fat body                                       </td><td class=\"cell_value\">$myrow[Fat_body]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Midgut ESTs                                    </td><td class=\"cell_value\">$myrow[Midgut_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">PsortMidgutESTs                                </td><td class=\"cell_value\">$myrow[PsortMidgutESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Hemocytes                                      </td><td class=\"cell_value\">$myrow[Hemocytes]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Salivary ESTs from RWV                         </td><td class=\"cell_value\">$myrow[Salivary_ESTs_from_RWV]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Brugia infected ESTs                           </td><td class=\"cell_value\">$myrow[Brugia_infected_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Dengue infected ESTs                           </td><td class=\"cell_value\">$myrow[Dengue_infected_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Plasmodium infected ESTs                       </td><td class=\"cell_value\">$myrow[Plasmodium_infected_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Whole shebang                                  </td><td class=\"cell_value\">$myrow[Whole_shebang]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Resequencing gamish ESTs                       </td><td class=\"cell_value\">$myrow[Resequencing_gamish_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Larval stage 1                                 </td><td class=\"cell_value\">$myrow[Larval_stage_1]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Early pupal ESTs                               </td><td class=\"cell_value\">$myrow[Early_pupal_ESTs]</td></tr>\n";
echo "<tr><td class=\"cell_key\">First residue of protein                       </td><td class=\"cell_value\">$myrow[First_residue_of_protein]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Protein size                                   </td><td class=\"cell_value\">$myrow[Protein_size]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Sum of residues                                </td><td class=\"cell_value\">$myrow[Sum_of_residues]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Increased AA fold above average                </td><td class=\"cell_value\">$myrow[Increased_AA_fold_above_average]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Cys number                                     </td><td class=\"cell_value\">$myrow[Cys_number]</td></tr>\n";
echo "<tr><td class=\"cell_key\">SigP Result                                    </td><td class=\"cell_value\">$myrow[SigP_Result]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Cleavage Position                              </td><td class=\"cell_value\">$myrow[Cleavage_Position]</td></tr>\n";
echo "<tr><td class=\"cell_key\">MW                                             </td><td class=\"cell_value\">$myrow[MW]</td></tr>\n";
echo "<tr><td class=\"cell_key\">pI                                             </td><td class=\"cell_value\">$myrow[pI]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Mature MW                                      </td><td class=\"cell_value\">$myrow[Mature_MW]</td></tr>\n";
echo "<tr><td class=\"cell_key\">pI mature                                      </td><td class=\"cell_value\">$myrow[pI_mature]</td></tr>\n";
echo "<tr><td class=\"cell_key\">TMHMM result                                   </td><td class=\"cell_value\">$myrow[TMHMM_result]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Length                                         </td><td class=\"cell_value\">$myrow[Length]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Predicted helices                              </td><td class=\"cell_value\">$myrow[Predicted_helices]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per membrane                                   </td><td class=\"cell_value\">$myrow[per_membrane]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per outside                                    </td><td class=\"cell_value\">$myrow[per_outside]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per inside                                     </td><td class=\"cell_value\">$myrow[per_inside]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to NR protein database              </td><td class=\"cell_value\">$myrow[Best_match_to_NR_protein_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value nr                                     </td><td class=\"cell_value\">$myrow[E_value_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match nr                                       </td><td class=\"cell_value\">$myrow[Match_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Extent of match NR                             </td><td class=\"cell_value\">$myrow[Extent_of_match_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Length of best match NR                        </td><td class=\"cell_value\">$myrow[Length_of_best_match_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity NR                                </td><td class=\"cell_value\">$myrow[per_identity_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length NR                            </td><td class=\"cell_value\">$myrow[per_Match_length_nr]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Species                                        </td><td class=\"cell_value\">$myrow[Species]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Key words                                      </td><td class=\"cell_value\">$myrow[Key_words]</td></tr>\n";
echo "<tr><td class=\"cell_key\">EC                                             </td><td class=\"cell_value\">$myrow[EC]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to GO database                      </td><td class=\"cell_value\">$myrow[Best_match_to_GO_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value go                                     </td><td class=\"cell_value\">$myrow[E_value_go]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Function descriptors                           </td><td class=\"cell_value\">$myrow[Function_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Function parent                                </td><td class=\"cell_value\">$myrow[Function_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Function second parent                         </td><td class=\"cell_value\">$myrow[Function_second_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">GO num function                                </td><td class=\"cell_value\">$myrow[GO_num_function]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of functional GO                       </td><td class=\"cell_value\">$myrow[E_value_of_functional_GO]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Component descriptors                          </td><td class=\"cell_value\">$myrow[Component_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Component parent                               </td><td class=\"cell_value\">$myrow[Component_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Component second parent                        </td><td class=\"cell_value\">$myrow[Component_second_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">GO num comp                                    </td><td class=\"cell_value\">$myrow[GO_num_comp]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of component GO                        </td><td class=\"cell_value\">$myrow[E_value_of_component_GO]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Process descriptors                            </td><td class=\"cell_value\">$myrow[Process_descriptors]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Process parent                                 </td><td class=\"cell_value\">$myrow[Process_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Process second parent                          </td><td class=\"cell_value\">$myrow[Process_second_parent]</td></tr>\n";
echo "<tr><td class=\"cell_key\">GO num proc                                    </td><td class=\"cell_value\">$myrow[GO_num_proc]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value of process GO                          </td><td class=\"cell_value\">$myrow[E_value_of_process_GO]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to KOG database                     </td><td class=\"cell_value\">$myrow[Best_match_to_KOG_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value kog                                    </td><td class=\"cell_value\">$myrow[E_value_kog]</td></tr>\n";
echo "<tr><td class=\"cell_key\">General class                                  </td><td class=\"cell_value\">$myrow[General_class]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to PFAM database                    </td><td class=\"cell_value\">$myrow[Best_match_to_PFAM_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value pfam                                   </td><td class=\"cell_value\">$myrow[E_value_pfam]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to SMART database                   </td><td class=\"cell_value\">$myrow[Best_match_to_SMART_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value smart                                  </td><td class=\"cell_value\">$myrow[E_value_smart]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to CDD database                     </td><td class=\"cell_value\">$myrow[Best_match_to_CDD_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value cdd                                    </td><td class=\"cell_value\">$myrow[E_value_cdd]</td></tr>\n";
echo "<tr><td class=\"cell_key\">All CDD domains                                </td><td class=\"cell_value\">$myrow[All_CDD_domains]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to COG database                     </td><td class=\"cell_value\">$myrow[Best_match_to_COG_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value cog                                    </td><td class=\"cell_value\">$myrow[E_value_cog]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to YEAST database                   </td><td class=\"cell_value\">$myrow[Best_match_to_YEAST_database]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value yeast                                  </td><td class=\"cell_value\">$myrow[E_value_yeast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match yeast                                    </td><td class=\"cell_value\">$myrow[Match_yeast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity yeast                             </td><td class=\"cell_value\">$myrow[per_identity_yeast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length yeast                         </td><td class=\"cell_value\">$myrow[per_Match_length_yeast]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to Arabidopsis proteome             </td><td class=\"cell_value\">$myrow[Best_match_to_Arabidopsis_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value ara                                    </td><td class=\"cell_value\">$myrow[E_value_ara]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity ara                               </td><td class=\"cell_value\">$myrow[per_identity_ara]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length ara                           </td><td class=\"cell_value\">$myrow[per_Match_length_ara]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to C elegans proteome               </td><td class=\"cell_value\">$myrow[Best_match_to_C_elegans_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value worm                                   </td><td class=\"cell_value\">$myrow[E_value_worm]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Match worm                                     </td><td class=\"cell_value\">$myrow[Match_worm]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity worm                              </td><td class=\"cell_value\">$myrow[per_identity_worm]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length worm                          </td><td class=\"cell_value\">$myrow[per_Match_length_worm]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to An gambiae proteome              </td><td class=\"cell_value\">$myrow[Best_match_to_An_gambiae_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value agam                                   </td><td class=\"cell_value\">$myrow[E_value_agap]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity agam                              </td><td class=\"cell_value\">$myrow[per_identity_agap]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length agam                          </td><td class=\"cell_value\">$myrow[per_Match_length_agap]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Best match to D melanogaster proteome          </td><td class=\"cell_value\">$myrow[Best_match_to_D_melanogaster_proteome]</td></tr>\n";
echo "<tr><td class=\"cell_key\">E value dmel                                   </td><td class=\"cell_value\">$myrow[E_value_dmel]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per identity dmel                              </td><td class=\"cell_value\">$myrow[per_identity_dmel]</td></tr>\n";
echo "<tr><td class=\"cell_key\">per Match length dmel                          </td><td class=\"cell_value\">$myrow[per_Match_length_dmel]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Clustered at 40% similarity on 50% of length Clusternum </td><td class=\"cell_value\">$myrow[Clustered_at_40Id_on_50_of_length___Clusternum]</td></tr>\n";
echo "<tr><td class=\"cell_key\">num seqs 40                                    </td><td class=\"cell_value\">$myrow[num_seqs_40]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Clustered at 60% similarity on 50% of length Clusternum </td><td class=\"cell_value\">$myrow[Clustered_at_60Id_on_50_of_length___Clusternum]</td></tr>\n";
echo "<tr><td class=\"cell_key\">num seqs 60                                    </td><td class=\"cell_value\">$myrow[num_seqs_60]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Clustered at 80% similarity on 50% of length Clusternum </td><td class=\"cell_value\">$myrow[Clustered_at_80Id_on_50_of_length___Clusternum]</td></tr>\n";
echo "<tr><td class=\"cell_key\">num seqs 80                                    </td><td class=\"cell_value\">$myrow[num_seqs_80]</td></tr>\n";
echo "<tr><td class=\"cell_key\">Clustered at 90% similarity on 50% of length Clusternum </td><td class=\"cell_value\">$myrow[Clustered_at_90Id_on_50_of_length___Clusternum]</td></tr>\n";
echo "<tr><td class=\"cell_key\">num seqs 90                                    </td><td class=\"cell_value\">$myrow[num_seqs_90]</td></tr>\n";

echo "</table>\n<br>\n";

}

function print_list( $anoxcel_rs )
{
	echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
	echo "<tr><td class=\"cell_key\">Gene ID</td>";
	echo "<td class=\"cell_key\">Key words</td><td class=\"cell_key\">Best match to NR database</td>";
	echo "<td class=\"cell_key\">Best match to GO</td></tr>";
	
	while( ( $myrow = mysql_fetch_assoc( $anoxcel_rs ) ) == true )
	{
		echo "<tr>";
		echo "<td class=\"cell_value\" valign=\"top\"><a href=AegyXcel.php?field=G&query=";
		echo substr( $myrow[Seq_name], 0, 10 ).">$myrow[Seq_name]</a></td>";
		echo "<td class=\"cell_value\" valign=\"top\">$myrow[Key_words]</td>";
		echo "<td class=\"cell_value\" valign=\"top\">$myrow[Best_match_to_NR_protein_database]</td>";
		echo "<td class=\"cell_value\" valign=\"top\">$myrow[Best_match_to_GO_database]</td></tr>\n";
	}
	echo "</table>";
}


function get_results( $sql )
{
	$db = mysql_connect ( "db.vectorbase.org", "db_public", "limecat" );
	mysql_select_db ( "AnoXcel", $db );

	$sql = "SELECT * FROM Aegy_AaegL1 WHERE ".$sql;
//	echo $sql;
	$xcel_rs = mysql_query( $sql, $db );
	
	$rows = mysql_num_rows( $xcel_rs );


	switch( $rows )                                                                                                                               
	{
		case 0:
			echo "<br><table align=\"center\"><tr><td><b>No matches found.</b></td></tr></table><br><br>";
			print_form();
			return;
		case 1:
			$myrow = mysql_fetch_array( $xcel_rs );
			print_record( $myrow );
			return;
		case $rows>1:
			if ( $rows >= 20 ) {
				echo "<br><table border=\"0\" cellspacing=\"0\" cellpadding=\"10\" width=\"100%\">";
				echo "<tr><td class=\"cell_value\">Your search returned a large number of results. Only the first twenty are displayed.";
				echo "</td></tr></table>";
			}			print_list( $xcel_rs );
			return;
	}
}


$sql = "";

if ( isset ( $_GET[ 'field' ], $_GET[ 'query' ] ) )

	switch( $_GET[ 'field' ] )	{

		case 'G':
			$sql .= "Seq_name LIKE '".get_gene_id( $_GET['query'])."-%' LIMIT 20";
			break;
		
		case 'DESC':
			$sql .= "Best_match_to_NR_protein_database LIKE '%".$_GET['query']."%' LIMIT 20";
			break;
		
		case 'KW':
			$sql .= "Key_words LIKE '%".$_GET['query']."%' LIMIT 20";
			break;
	
		case 'GO':
			$sql .= "Best_match_to_GO_database LIKE '%".$_GET['query']."%' LIMIT 20";
			break;
	}

if ( $sql != "" )
	get_results( $sql );
else
	print_form();



/*
	<td><td class=\"cell_value\">$myrow[	$QSTRING = $QUERY_STRING; 
	while (list ($header, $value) = each ($_POST)) 
	{ 
		$QSTRING = $QSTRING.'&'.$header.'='.$value; 
	} 
	$QSTRING = urlencode($QSTRING);
	
	if ($_GET["action"] == "uni"){
		$url = "http://localhost/cgi-bin/uniaegyxcel.pl?contigname=" . $_GET["contigname"] . "&menu_bg_over=" . DV::$OCS[$_SESSION["organism_id"]][5];
		if ($_GET["type"]){
			$url .= "&type=" . $_GET["type"];
		}
	} else {
		$url = "http://localhost/cgi-bin/aegyxcel.pl?menu_bg_over=" . DV::$OCS[$_SESSION["organism_id"]][5] . "$QSTRING";
	}

	print file_get_contents($url);
*/	
?>
