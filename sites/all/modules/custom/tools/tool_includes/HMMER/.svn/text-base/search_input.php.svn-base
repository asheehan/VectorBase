<?

	$HMMSEARCH_FORM_NAME="hmmsearch_input_form";
	//include("blast_programs.php");
	include("hmmer_errors.php");
	include_once("Jobs.php");
        if($_GET['hmmsearch_id']){
          $job_query = "select * from job_params where job_id = " . $_GET['hmmsearch_id'];
          $job_rs = pg_query(DB::getJOB_DB(), $job_query);
          $redoDatabases = array();
          while($job_row = pg_fetch_assoc($job_rs)){
            if($job_row["argument"] == "sequence"){
              $redoSequence = $job_row['value'];
            }
            elseif($job_row["argument"] == "target_database"){
              array_push($redoDatabases, $job_row['value']);
            }
            elseif($job_row['argument'] == "evalue"){
              $redoEvalue = $job_row['value'];
            }
          }
        }

/*
	if($_GET['hmmbuild_id']) {
		$results = Jobs::getResults($_GET["hmmbuild_id"], "HMMBUILD");
		$results = trim($results->results(),"\r\n");
    		$lines = split("\n",$results);
		  for ($lineI = 0; $lineI < sizeof($lines); $lineI++) {
		    $words = preg_split("/\s+/", $lines[$lineI]);
		    if ($words[0] == "ALPH") {
		      if ($words[1] == "Amino") {
		        $db_type = 1;
		      } else {
		        $db_type = 2;
		      }
		      break;
		    }
		  }
	}
*/
?>

<script language="JavaScript" type="text/javascript">
	<!--
		function toggle_blast_parameters(param_tr_count,option_string,param_status,blast_div){

			var blast_option_string = document.getElementById(option_string);
			var blast_param_status = document.getElementById(param_status);
			var blast_divide = document.getElementById(blast_div);
			<?
      			if (!preg_match("/MSIE/i",$_SERVER["HTTP_USER_AGENT"])){
      				$table_style = "table-row";
      			}
      		?>
			if (blast_option_string && blast_param_status && blast_divide){			
				if (blast_divide.style.display == "none"){
					blast_divide.style.display='<?=$table_style;?>';
					for (var i=1; i <= param_tr_count; i++){
						var blast_param_id = "blast_options_" + i;
						var blast_param_tr = document.getElementById(blast_param_id);
						blast_param_tr.style.display='<?=$table_style;?>';
					}
					blast_option_string.innerHTML = '[Use Defaults]';
					blast_param_status.innerHTML = 'Custom Settings&nbsp;&raquo;';
					
				} else {
					blast_divide.style.display="none";
					for (var i=1; i <= param_tr_count; i++){
						var blast_param_id = "blast_options_" + i;
						var blast_param_tr = document.getElementById(blast_param_id);
						blast_param_tr.style.display="none";
					}
					blast_option_string.innerHTML ='[More Options]';
					blast_param_status.innerHTML =  'Default';
				}			
			
			}
		}
	
		
		function database_toggle(org_short_name){
			var blast_databases = document.getElementById((org_short_name + '_databases'));
			var blast_databases_div = document.getElementById((org_short_name + '_divider'));
			<?
      			if (!preg_match("/MSIE/i",$_SERVER["HTTP_USER_AGENT"])){
      				$table_style = "table-row";
      			}
      		?>

			if (blast_databases && blast_databases_div){
				if (blast_databases.style.display=="none"){
					blast_databases.style.display='<?=$table_style;?>';
					blast_databases_div.style.display='<?=$table_style;?>';
				} else {
					blast_databases.style.display="none";		
					blast_databases_div.style.display="none";			
				}
			}  
		}
		
	-->
</script>

<form method="post" enctype="multipart/form-data" action="/sections/Tools/tool_includes/HMMER/search_submit.php" name="<?=$HMMSEARCH_FORM_NAME;?>"><input type="hidden" name="hmmbuild_id" value="<?echo $_GET['hmmbuild_id'];?>"/>
    <table border="0" cellpadding="0" cellspacing="10" >
		<?
			if ($_GET["e10"]){
				print "<tr><td colspan=\"2\" style=\"color:red;font-weight:bold;\">" . $hmmer_errors[10] . "</td></tr>";
			}
			if ($_GET["e11"]){
				print "<tr><td colspan=\"2\" style=\"color:red;font-weight:bold;\">" . $hmmer_errors[11] . "</td></tr>";
			}
			if ($_GET["e14"]){
				print "<tr><td colspan=\"2\" style=\"color:red;font-weight:bold;\">" . $hmmer_errors[14] . "</td></tr>";
			}
		?>
        <tr>
            <td valign="top">
                <table border="0" width="310" cellspacing="0" cellpadding="0">
					<tr>
						<td bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>" class="services_title">
                            Directions:
                        </td>
					</tr>
					<tr>
						<td bgcolor="#ffffff">
							<ul>
                						<li>Choose appropriate databases to search against.</li>
                						<li>Paste or upload HMMER model.</li>
                						<li><i>Optional:</i> Set additional HMMSEARCH properties.</li>
                						<li>Submit your HMMER Search.</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td height="10">
							<img src="/imgs/blank.gif" alt="blank"/>
						</td>
					</tr>

                    <tr>
                        <td bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>" class="services_title">
                            Available Databases:
                        </td>
                    </tr>
                    <?
                        
                        print "<tr><td bgcolor=\"#ffffff\">\n";
                        
                        // Buffer Table
                        print "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"6\">";

                        if ($_GET["e1"]){
                            print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[1] . "</td></tr>";
                        }
                        if ($_GET["e3"]){
                            print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[3] . "</td></tr>";
                        }
                        print "<tr><td height=\"15\" class=\"small\">Click on an organism to see available databases.</td></tr>";
                        print "<tr><td height=\"15\" class=\"small\" bgcolor=\"#f4f4f4\">";
                        print "&nbsp;KEY:&nbsp;&nbsp;&nbsp;<b>N:</b>&nbsp;Nucleotide Database&nbsp;&nbsp;&nbsp;<b>P:</b>&nbsp;Peptide Database";
                        print "</td></tr>";

                        print "<div id=\"core_tab\" style=\"display: block;\">";
                        foreach (ORG::$ENDOWED as $organism){
                            if ($organism != "all"){
                                print "<tr><td style=\"border:1px solid #" . DV::$OCS[$organism][4] . ";\">";
                                
                                
                                // Begin inner organism database table
                                print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
                                print "<tr><td>";
                                print "&nbsp;<a class=\"hashelp\" name=\"Web:BLAST#databases\" style=\"text-decoration:none;color:#" . DV::$OCS[$organism][1] . ";\" href=\"javascript:database_toggle('" . $organism . "');\">&nbsp;" . ORG::$DN[$organism] . "&nbsp;Databases&nbsp;&raquo;</a>";
                                print "</td></tr>";
                                print "<tr id=\"" . $organism . "_divider\" style=\"display:";
                                if ($_SESSION["organism_id"] == $organism){
                                	print "table-row";
                                } else {
                                	print "none";
                                }
                                print ";\" bgcolor=\"#" . DV::$OCS[$organism][4] . "\"><td height=\"2\"></td></tr>\n";
                                // End inner organism_database_table

                                $db_row=0;
                                $sql = "select b.*,o.short_name from blast_databases b, organism o where b.organism_id=o.organism_id and o.short_name='" . $organism . "' and b.file_name like '%PEPTIDE%' order by b.order_by;";
                                $db_rs = pg_query(DB::getUI_DB(),$sql);


                                //encaspulate database list in a table for easy colapsability
                                print "<tr id=\"" . $organism . "_databases\" style=\"display:";
                                if ($_SESSION["organism_id"] == $organism){
                                	print "table-row";
                                } else {
                                	print "none";
                                }
                                print ";\"><td><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"1\">";
                                while ($db_row = pg_fetch_assoc($db_rs)){
                                    
                                    if ($db_row["residue_type"]=="NUCLEOTIDE"){
                                        $type_letter = 'n';
                                    } else {
                                        $type_letter = 'p';
                                    }
                                    
                                    //modified for HMMER3
                                    $display_tmp = str_replace("\"","&#34;",$db_row["display_id"]);
                                    print "<tr>\n<td  class=\"db_entry hashelp\" id=\"Web:BLAST#" . strtolower(str_replace(" ", "_", $db_row["short_name"] . " " . display_tmp)) . "\">\n";

                                	print "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n<tr><td width=\"15\">";
                                    print "<input class=\"small\" type=\"checkbox\" checked=\"yes\" name=\"blastdb_id[]\" id=\"blastdb_checkbox_" . $db_row["blastdb_id"] . "\" value=\"" . $db_row["file_name"] . "\" onclick=\"enforce_residue_constraints('" . $type_letter . "');";
                    				if ($db_row["sequence_type"]=="Trace Read"){
                    					print "setWordSize('trace');";
                    				}                                    
                                    print "\"";
                                    if($_GET['hmmer_id']){
                                        foreach($redoDatabases as $rdb){
                                            if($db_row["file_name"] == $rdb){
                                                print " checked=\"checked\" ";
                                                break;
                                            }
                                        }
                                    }
                                    print "/></td><td id=\"blastdb_desc_" . $db_row["blastdb_id"] . "\">";
                                    print "<span id=\"blastdb_type_" . $db_row["blastdb_id"] . "\" style=\"font-weight:bold;\">" . strtoupper($type_letter) . "</span>:&nbsp;";
                                    print $db_row["display_id"];
                                    print "</td></tr></table>\n";
                                }
                                print "</td></tr>";

                                // end database table
                                print "</table></td></tr>";
                                print "</table>";
                                print "</td></tr>";
                            }
                        }
                        print "</td></tr>";
                        print "</div>";                        
                        print "</table></td></tr>";
                    ?>
               		<tr>
						<td height="10">
							<img src="/imgs/blank.gif" alt="blank"/>
						</td>
					</tr>
                    <tr>
                        <td  class="services_title">
                            HMMSEARCH Options:
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff">
                            <table border="0" style="padding:3px;" width="100%">
                                <tr>
                                    <td>
                                        <table border="0" width="100%" style="border-spacing:1px;">
                                            <tr>
                                                <td colspan="3">
                                                    
                                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                        <tr>
                                                            <td align="left">
                                                                &nbsp;<b>Parameters:</b> <span id="param_status">Default</span>
                                                            </td>
                                                            <td align="right" class="small">
                                                                <a href="#options_string" id="Web:Misc_Help#blast_options_string" class="hashelp" onclick="toggle_blast_parameters(1,'Web:Misc_Help#blast_options_string','param_status','blast_divide');">[More options]</a>&nbsp;
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                </td>	
                                            </tr>
                                            <tr id="blast_divide" style="display:none;">
                                                <td height="2" colspan="3" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                                </td>
                                            </tr>
                                            <tr id="blast_options_1" style="display:none;">
                                                <td class="small" style="padding:3px;" bgcolor="#f8f8f8">
                                                    Maximum E-Value:
                                                </td>
                                                <td bgcolor="#f8f8f8">
                                                    <input type="text" size="10" name="evalue" class="small hashelp" id="Web:HMMSEARCH#maximum_e-value" value="0.1"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            
            <td rowspan="0" valign="top">
            
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td  class="services_title">
                            Input HMMER Model:
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="padding:8px;">
                                        <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                            <?	
                                                if ($_GET["e5"]){
                                                    print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[5] . "</td></tr>";
                                                }
                                                if ($_GET["e7"]){
                                                    print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[7] . "</td></tr>";
                                                }	
                                                if ($_GET["e8"]){
                                                    print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[8] . "</td></tr>";
                                                }
                                                if ($_GET["e9"]){
                                                    print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[9] . "</td></tr>";
                                                }
                                                if ($_GET["e12"]){
                                                    print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[12] . "</td></tr>";
                                                }
                                                if ($_GET["e13"]){
                                                  print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[13] . "</td></tr>";
                                                }
                                            ?>
                                            <tr>
                                                <td>
                                                    &nbsp;<b>Upload a file:</b>
                                                </td>	
                                            </tr>
                                            <tr>
                                                <td height="2px;" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#f8f8f8" style="padding:3px;">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="<?=$MAX_INPUT_SIZE;?>"/>
                                                   	<input size="30" type="file" class="small hashelp" name="input_file" id="Web:Misc_Help#upload"/>	
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="24">
                                                    &nbsp;<span style="font-weight:bold;">OR</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    &nbsp;<b>Paste in a HMMER model:</b>
                                                </td>	
                                            </tr>
                                            <tr>
                                                <td height="2" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#f8f8f8">
                                                    <textarea class="hashelp" id="Web:Misc_Help#paste" name="input_sequence" cols="60" rows="20" style="font-family:Courier New; font-size:11px;"><?
                                            if($_GET['hmmsearch_id'])
                                                print $redoSequence;

				if( isset($_GET['hmmbuild_id']) ) {
					$results = Jobs::getResults($_GET["hmmbuild_id"], "HMMBUILD");
					print trim($results->results(),"\r\n");
				} 
                                                    ?></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br/>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <?
                        if ($_GET["e6"]){
                            print "<tr><td height=\"20\" style=\"color:red;font-weight:bold;\">" . $hmmer_errors[6] . "</td></tr>";
                        }
                    ?>
                    <tr>
                        <td  class="services_title">
                            Job Control:
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding:6px;">
                            <table border="0" width="100%">
                                <tr>
                                    <td>
                                        <table border="0" style="border-spacing:1px;" width="100%">
                                            <tr>
                                                <td align="left" class="small" bgcolor="#f8f8f8">
                                                    &nbsp;Submit your HMMSEARCH
                                                </td>
                                                <td align="right" bgcolor="#f8f8f8" style="padding:3px;" >
                                                    <input type="submit" name="submit_hmmsearch" value="Submit HMMSEARCH Job" class="small" id="Web:Misc_Help#submit"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="small" bgcolor="#f8f8f8">
                                                    &nbsp;Retrieve HMMSEARCH job
                                                </td>
                                                <td align="right" bgcolor="#f8f8f8" style="padding:3px;" >	
                                                    <input type="text" size="10" name="job_id" class="small" value="Enter Job ID" onfocus="if(this.value=='Enter Job ID')this.value='';"/>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<input id="Web:Misc_Help#retrieve" name="get_hmmsearch" type="submit" value="Retrieve HMMSEARCH Job" class="small hashelp"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>

