<?
	$HMMSEARCH_FORM_NAME="hmmsearch_input_form";
	//include("blast_programs.php");
	include("hmmer_errors.php");
?>
<script language="JavaScript" type="text/javascript">
<!--

function toggle_hmmsearch_parameters(param_tr_count,option_string,param_status,hmmsearch_div){

  var hmmsearch_option_string = document.getElementById(option_string);
  var hmmsearch_param_status = document.getElementById(param_status);
  var hmmsearch_divide = document.getElementById(hmmsearch_div);
  <?
  if (!preg_match("/MSIE/i",$_SERVER["HTTP_USER_AGENT"])){
    $table_style = "table-row";
  }
  ?>
  if (hmmsearch_option_string && hmmsearch_param_status && hmmsearch_divide){			
    if (hmmsearch_divide.style.display == "none"){
      hmmsearch_divide.style.display='<?=$table_style;?>';
      for (var i=1; i <= param_tr_count; i++){
        var hmmsearch_param_id = "hmmsearch_options_" + i;
        var hmmsearch_param_tr = document.getElementById(hmmsearch_param_id);
        hmmsearch_param_tr.style.display='<?=$table_style;?>';
      }
      hmmsearch_option_string.innerHTML = '[Use Defaults]';
      hmmsearch_param_status.innerHTML = 'Custom Settings&nbsp;&raquo;';

    } else {
      hmmsearch_divide.style.display="none";
      for (var i=1; i <= param_tr_count; i++){
        var hmmsearch_param_id = "hmmsearch_options_" + i;
        var hmmsearch_param_tr = document.getElementById(hmmsearch_param_id);
        hmmsearch_param_tr.style.display="none";
      }
      hmmsearch_option_string.innerHTML ='[More Options]';
      hmmsearch_param_status.innerHTML =  'Default';
    }			

  }
}

function enforce_blast_constraints(residue_type){
  var ok=1;
  var blast_programs = new Object();
  var rbs = new Object();
  var names = new Object();
  var descs = new Object();
  <?foreach (array_keys($blast_programs) as $program){?>
  blast_programs["<?=$program;?>"]="<?=$blast_programs[$program]["database"];?>";								
  <?}?>
  for (var program in blast_programs){
    var radio_button = document.getElementById((program + '_rb'));
    rbs[program] = radio_button;
    var program_name_td = document.getElementById((program + '_name'));
    names[program] = program_name_td;
    var program_desc_td = document.getElementById((program + '_desc'));
    descs[program] = program_desc_td;
    if (!(radio_button && program_name_td && program_desc_td)){
      ok=0;
    }
  }

  if (ok){

    var db_type;	
    if (residue_type == 'n'){
      db_type='PEPTIDE';
      rbs['blastn'].checked=true;
      setWordSize('blastn');
    } else {
      db_type='NUCLEOTIDE';
      rbs['blastp'].checked=true;
      setWordSize('blastp');
    } 

    for (var program in blast_programs){
      if (blast_programs[program] == db_type){
        rbs[program].disabled=true;
        names[program].style.color="#cccccc";
        descs[program].style.color="#cccccc";
      }
    }
  }
}

function reset_blast_constraints(){
  var ok=1;
  var blast_programs = new Object();
  <?foreach (array_keys($blast_programs) as $program){?>
  blast_programs["<?=$program;?>"]="<?=$blast_programs[$program]["database"];?>";
  <?}?>
  var rbs = new Object();
  var names = new Object();
  var descs = new Object();
  for (var program in blast_programs){
    var radio_button = document.getElementById((program + '_rb'));
    rbs[program] = radio_button;
    var program_name_td = document.getElementById((program + '_name'));
    names[program] = program_name_td;
    var program_desc_td = document.getElementById((program + '_desc'));
    descs[program] = program_desc_td;
    if (!(radio_button && program_name_td && program_desc_td)){
      ok=0;
    }
  }

  if (ok){
    for (var program in blast_programs){
      rbs[program].disabled=false;
      names[program].style.color="#000000";
      descs[program].style.color="#000000";

    }
    rbs['blastn'].checked=true;
    setWordSize('blastn');
  }
}

function enforce_residue_constraints(residue_type){
  var bdbs = new Object();
  var checkboxes = new Object();
  var descs = new Object();
  var disable = 'none';
  var ok=1;
  <?
  $sql = "select * from blast_databases;";
  $bdb_rs = pg_query(DB::getUI_DB(),$sql);
  while ($bdb_row = pg_fetch_assoc($bdb_rs)){?>
  bdbs[<?=$bdb_row["display_id"];?>]="<?=$bdb_row["residue_type"];?>";	
  <?}
  ?>
  for (var display_id in bdbs){
    var checkbox = document.getElementById(('blastdb_checkbox_' + display_id));
    checkboxes[display_id] = checkbox;
    var desc = document.getElementById(('Web:HMMR:Data#' + display_id));
    descs[display_id] = desc;
    if (!(checkbox && desc)){
      ok=0;
    }

    if (checkboxes[display_id].checked){
      if (residue_type=='n'){
        disable='PEPTIDE';
      } else {
        disable='NUCLEOTIDE';
      }
      enforce_blast_constraints(residue_type);
    }
  }

  if (ok){
    for (var display_id in bdbs){
      if (bdbs[display_id]==disable){
        checkboxes[display_id].disabled=true;
        descs[display_id].style.color="#cccccc";
      } else {
        checkboxes[display_id].disabled=false;
        descs[display_id].style.color="#000000";
      }
    }
    if (disable=='none'){
      reset_blast_constraints();
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
<form method="post" enctype="multipart/form-data" action="/sections/Tools/tool_includes/HMMER/search_submit.php" name="<?=$HMMSEARCH_FORM_NAME;?>">
  <table border="0" cellpadding="0" cellspacing="10" >
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
              <ol>
                <li>Choose appropriate databases to search against.</li>
                <li>Paste, select or upload HMMER model.</li>
                <li><i>Optional:</i> Set additional HMMSEARCH properties.</li>
                <li>Submit your HMMER Search.</li>
              </ol>
            </td>
          </tr>
          <tr>
            <td height="10">
              <img src="/imgs/blank.gif" alt="blank"/>
            </td>
          </tr>
          <?
            if ($_GET["e10"]){
              print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[10] . "</td></tr>";
            }
            if ($_GET["e11"]){
              print "<tr><td style=\"color:red;font-weight:bold;\">" . $hmmer_errors[11] . "</td></tr>";
            }
          ?>
          <tr>
            <td bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>" class="services_title">
              Available Databases:
            </td>
          </tr>
          <?
          $sql = "select distinct o.organism_id,o.display_name,o.short_name, dv.* from organism o, blast_databases bdbs, display_vars dv where o.short_name !='all' and o.organism_id=dv.organism_id and o.organism_id=bdbs.organism_id order by o.organism_id;";
          $org_rs = pg_query(DB::getUI_DB(),$sql);
          print "<tr><td bgcolor=\"#ffffff\">\n";
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
          while ($org_row = pg_fetch_assoc($org_rs)){
            //Outer Cell Padding for each organism database table 
            print "<tr><td style=\"border:1px solid #" . $org_row["menu_bg_over"] . ";\">";

            print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
            print "<tr><td>";
            print "&nbsp;<a class=\"hashelp\" name=\"Web:BLAST#databases\" href=\"#\" style=\"text-decoration:none;color:#" . $org_row["status_bg"] . ";\" onclick=\"database_toggle('" . $org_row["short_name"] . "');\">&nbsp;" . $org_row["display_name"] . "&nbsp;Databases&nbsp;&raquo;</a>";
            print "</td></tr>";
            print "<tr id=\"" . $org_row["short_name"] . "_divider\" style=\"display:";
            if ($_SESSION["organism_id"] == $org_row["short_name"]){
              print "table-row";
            } else {
              print "none";
            }
            print ";\" bgcolor=\"#" . $org_row["menu_bg_over"] . "\"><td height=\"2\"></td></tr>\n";

            $db_row=0;
            $sql = "select * from blast_databases where organism_id=" . $org_row["organism_id"] . " and residue_type='NUCLEOTIDE' order by display_id;";
            $dna_rs = pg_query(DB::getUI_DB(),$sql);
            $sql = "select * from blast_databases where organism_id=" . $org_row["organism_id"] . " and residue_type='PEPTIDE' order by display_id;";
            $peptide_rs = pg_query(DB::getUI_DB(),$sql);

            //encaspulate database list in a table for easy colapsability
            print "<tr id=\"" . $org_row["short_name"] . "_databases\" style=\"display:";
            if ($_SESSION["organism_id"] == $org_row["short_name"]){
              print "table-row";
            } else {
              print "none";
            }
            print ";\"><td><table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"1\">";
            while (($db_row < pg_num_rows($peptide_rs))||($db_row < pg_num_rows($dna_rs))){
              $dna_row = pg_fetch_assoc($dna_rs,$db_row);
              $peptide_row = pg_fetch_assoc($peptide_rs,$db_row);
              print "<tr>\n<td class=\"db_entry\"";
              if ($dna_row["display_id"]){
                print " class=\"hashelp\" id=\"Web:HMMR:Data#" . $dna_row["display_id"] . "\" id=\"Web:HMMR:Data#" . $dna_row["display_id"] . "\"";
              }
              print ">";

              if ($dna_row["display_id"]){
                print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>";
                print "<input class=\"small\" type=\"checkbox\" name=\"display_id[]\" id=\"blastdb_checkbox_" . $dna_row["display_id"] . "\" value=\"" . $dna_row["file_name"] . "\" onclick=\"enforce_residue_constraints('n');";
                if (preg_match("/Trace/i",$dna_row["display_id"])){
                  print "setWordSize('trace');";
                }                                    
                print "\"/></td><td>";
                print "<b>N:</b>&nbsp;";
                print $dna_row["display_id"];
                print "</td></tr></table>\n";
              }

              print "</td>\n<td class=\"db_entry\"";
              if ($peptide_row["display_id"]){
                print " onmouseover=\"displayHelpCustom(event, 'HMMSEARCH Search against " . addslashes($peptide_row["description"]) . "', 'Check to HMMSEARCH Search against " . addslashes($peptide_row["description"]) . "');\" onmouseout=\"clearHelp();\" id=\"Web:HMMR:Data#" . $peptide_row["display_id"] . "\"";
              }
              print ">";
              if ($peptide_row["display_id"]){
                print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td>";
                print "<input type=\"checkbox\" class=\"small\" name=\"display_id[]\" id=\"blastdb_checkbox_" . $peptide_row["display_id"] . "\" value=\"" . $peptide_row["file_name"] . "\"	 onclick=\"enforce_residue_constraints('p');\"/>";
                print "</td><td>";
                print "<b>P:</b>&nbsp;" . $peptide_row["display_id"];
                print "</td></tr></table>";	
              }
              print "</td>\n</tr>\n";
              $db_row++;
            }

            // end database table
            print "</table></td></tr>";

            print "</table>";

            // End Organism Database Table

            // End Buffer table row
            print "</td></tr>";
          }
          // End Buffer Table
          print "</table>";
          print "</td></tr>";	
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
              <table border="0" width="100%" cellspacing="6" cellpadding="0">
                <tr>
                  <td>
                    <table border="0" width="100%" cellpadding="1" cellspacing="1">
                      <tr>
                        <td colspan="3">
                          <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                              <td align="left">
                                &nbsp;<b>Parameters:</b> <span id="param_status">Default</span>
                              </td>
                              <td align="right" class="small">
                                <a href="#options_string" class="hashelp" id="Web:HMMSEARCH#more_options" onclick="toggle_hmmsearch_parameters(13,'Web:HMMSEARCHW#more_options','param_status','hmmsearch_divide');">[More options]</a>&nbsp;
                              </td>
                            </tr>
                          </table>
                        </td>	
                      </tr>
                      <tr id="hmmsearch_divide" style="display:none;">
                        <td height="0" colspan="3" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                        </td>
                      </tr>
                        <tr id="hmmsearch_options_1" style="display:none;">
                          <td class="small" bgcolor="#f8f8f8">
                            Number of Results
                          </td>
                          <td bgcolor="#f8f8f8">
                            <select class="small hashelp" name="num_results" id="Web:HMMSEARCH#number_of_results">
                              <option value="1">1</option>
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option selected="selected" value="250">250</option>
                              <option value="500">500</option>
                            </select>
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
                            Input HMMER Model
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff">
                            <table border="0" cellpadding="8" cellspacing="0" width="100%">
                                <tr>
                                    <td>
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
                                                <td bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#f8f8f8">
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
                                                    &nbsp;<b>Paste in a HMMSEARCH Model:</b>
                                                </td>	
                                            </tr>
                                            <tr>
                                                <td bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#f8f8f8">
                                                    <textarea class="hashelp" id="Web:Misc_Help#paste" name="input_sequence" cols="60" rows="20" style="font-family:Courier New; font-size:11px;">
						    </textarea>
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
                        <td bgcolor="#ffffff">
                            <table border="0" cellpadding="6" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="2" cellspacing="1" width="100%">
                                            <tr>
                                                <td align="left" class="small" bgcolor="#f8f8f8">
                                                    &nbsp;Submit your HMMSEARCH job
                                                </td>
                                                <td align="right" bgcolor="#f8f8f8">
                                                    <input type="submit" name="submit_hmmsearch" value="Submit HMMSEARCH Job" class="small" id="Web:Misc_Help#submit"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="small" bgcolor="#f8f8f8">
                                                    &nbsp;Retrieve a previously run HMMSEARCH job
                                                </td>
                                                <td align="right" bgcolor="#f8f8f8">	
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
