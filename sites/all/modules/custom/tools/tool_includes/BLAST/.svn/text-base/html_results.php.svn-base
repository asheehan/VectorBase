<?
// Turn off all error reporting
error_reporting (0);
//error_reporting(E_ALL);
include_once("blast_results.php");
ini_set("include_path",(".:" . $_SERVER["DOCUMENT_ROOT"] . "/includes"));
include_once("Jobs.php");
include_once("static_vars.php");
include_once("db_connect.php");

if($_GET['error']){
  print "Error in submission. Please select some sequences.";
}

if(!$_GET['dispNum']){
  $_GET['dispNum'] = 50;
}
$result = getResult($_GET['job_id'], $_GET['resNum'], DB::getJOB_DB());
if(!$_GET['header']){

  ?>
  <script type="text/javascript" src="/includes/blast_floater.js"></script>
  <script type="text/javascript" src="/includes/blaster_functions.js"></script> 
  <form id="blast_form" onsubmit="if(!checkForm()){ return false;}">
  <script type="text/javascript" src="/includes/blast_results.js"></script>
  <?
  // Initializing more variables
  $sortNameArray = array(
    "evalue" => "E-Value",
    "length" => "Length",
    "score" => "Score",
    "identity" => "Identity",
    "querystart" => "Query Start",
    "queryend" => "Query End",
    "start" => "Hit Start",
    "end" => "Hit End"
  );
  
  // Checking the Download Job
}

// DOWNLOAD
if($_GET['getSequences']){
  if(!$_GET['header']){
    $boxesStr = "";
    foreach($_GET as $key => $value){
      preg_match("(\d+n0)", $key, $match);
      if($match){
        //array_push($boxes, $key);
        $boxesStr .= "&" . $key . "=on";
      }
    }
    if($_GET['actionMenu'] == 'download'){
      //print_r($_GET);//$_SERVER['QUERY_STRING'] . " <><><br />";
      ?>
      <META HTTP-EQUIV="Refresh" CONTENT="5; URL=http://<?=$_SERVER["HTTP_HOST"]?>/sections/Tools/tool_includes/BLAST/html_results.php?result=html_results<?=$boxesStr;?>&job_id=<?=$_GET['job_id']?>&page=fetch&getSequences=<?=$_GET['getSequences']?>&resNum=<?=$_GET['resNum']?>&actionMenu=<?=$_GET['actionMenu']?>&header=1">
      <table border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td style="padding-left: 10px; padding-top: 10x;">
      <span style="color:blue; font-weight:bold;">Sequences fetch complete.</span>
      Your results should being downloading in 5 seconds.  If they don't, <a href="http://<?=$_SERVER["HTTP_HOST"]?>/sections/Tools/tool_includes/BLAST/html_results.php?result=html_results<?=$boxesStr;?>&job_id=<?=$_GET['job_id']?>&page=fetch&getSequences=<?=$_GET['getSequences']?>&resNum=<?=$_GET['resNum']?>&actionMenu=<?=$_GET['actionMenu']?>&header=1">click here.</a>
      </span>
      </td>
      </tr>
      </table>
      <?
      $_GET['getSequences'] = null;
      $_GET['header'] = null;
    }
    elseif($_GET['actionMenu'] == 'clustal') {
        $query = "select value from job_params where job_id = ".$_GET['job_id'] . " and argument='program';";
        $rs = pg_query(DB::getJOB_DB(), $query);
        $row = pg_fetch_assoc($rs);
      ?>
      <META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://<?=$_SERVER['HTTP_HOST']?>/Tools/ClustalW/?type=<?=$row['value'];?>&resNum=<?=$_GET['resNum'];?>&blast_id=<?=$_GET['job_id'];?><?=$boxesStr;?>">
      <?
    }
  } else {
    header("Content-type:appliation/octet-stream");
    header("Content-Disposition: attachment; filename=\"vbBLASTsequences_".$_GET['job_id']."\"");
	$count=0;
    foreach($result->getHits() as $hit){
      if($_GET[$hit->getId() . 'n0'] == "on"){
        preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(), $db);
        //if($db[3] == 'agambiae.CHROMOSOMES-PEST.AgamP3.fa'){
          //preg_match("/^(\w+)\W+/", $hit->getName(), $tHit);
          //$sql = "select primary_id, description, sequence from raw_sequences where filename = '" . $db[3] . "' and primary_id = '" . $tHit[1] . "'";
        //} else {
          $sql = "select primary_id, description, sequence from raw_sequences where filename = '" . $db[3] . "' and primary_id = '" . $hit->getName() . "'";
        //}
        //error_reporting(E_ALL);
        $res = pg_query(DB::getBD_DB(), $sql);
        $row = pg_fetch_assoc($res);
        //print_r($row);
	if($count==0)
        	print ">" . $row['primary_id'] . " " . $row['description'];
	else
		print "\r\n>" . $row['primary_id'] . " " . $row['description'];

        $i = 0;
        while($i < strlen($row['sequence'])){
          print "\r\n" . substr($row['sequence'], $i, 70);
          $i+= 70;
          #$row['sequence'];
        }
	$count++;
      }
    }
    exit;
  }
}

  // NO JOB - SUBMIT ONE


  /*$dlStr = "";
  $hI = 0;
  $dlStr .= " \"" . $result->getDb() . "\"";
  foreach($result->getHits() as $hit){
    if($_GET[$hit->getId().'n0'] == "on"){
      $dlStr .= " \"" . $hit->getName() . "\""; 
    }
    $hI++;
  }
  $seq_params_array = array("parameters"=>$dlStr);
  try{
    $seq = new seqJob($seq_params_array);
    $jobResult = $seq->submit();
  } catch (JobException $e) {
    $error_rdir = "http://" . $_SERVER['HTTP_HOST'] . "/Tools/BLAST/?result=html_results&error=1&job_id=";
    $error_rdir .= $_GET['job_id'] . "&page=" . $_GET['page'];
    header("Location: " . $error_rdir);
    print "Error! Please see the error message <a href=\"$error_rdir\"here</a>.";
    exit();
  }
  ?>
  <META HTTP-EQUIV="Refresh" CONTENT="0; URL=?result=html_results&job_id=<?=$_GET['job_id'];?>&page=fetch&xj=<?=$jobResult['id'];?>&getSequences=<?=$_GET['getSequences'];?>&resNum=<?=$_GET['resNum'];?>&actionMenu=<?=$_GET['actionMenu'];?>">
  <?
  */
  // We have a job, check the status
// NOT A DOWNLOAD
  ?>
  <table border="0" cellpadding="0" cellspacing="8" <?if($_GET['view'] != "align"){ print "width=\"100%\""; }?> >
    <?
    preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(), $db);
    $blastQ = "select o.full_name,o.display_name,b.display_id from organism o, blast_databases b where b.file_name = '" . $db[3] . "' and b.organism_id = o.organism_id";
    $bqResults = pg_query(DB::getUI_DB(), $blastQ);
    $bqRow = pg_fetch_assoc($bqResults);

	if(!$bqRow){
	//this is an est db
		$blastQ = "select species, short_name from blast_est where filename = '" . $db[3] . "'";
		$bqResults = pg_query(DB::getUI_DB(), $blastQ);
		$bqRow = pg_fetch_assoc($bqResults);
		$bqRow["display_name"] = ORG::$DN[ORG::$LTS[$bqRow["species"]]];
		$bqRow["display_id"]= $bqRow["short_name"];
	}


    ?>
    <tr>
      <td valign="top" width="800">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <?
          /* For Now! */
          $hit = $result->getHits();
          $hit = $hit[0];
          $hsp = $hit->getHsps();

        // ALIGNMENT VIEW
        if($_GET['view'] == "align"){
          $hit = $result->getHitByHspId($_GET['hsp_id']);
          $hsp = $result->getHspById($_GET['hsp_id']);
          $ret = displayAlignment($result, $hit, $hsp);
          print $ret;
        } 
        // Looking at Hits or Hsps
        else {
          if($_GET['view'] != "hit"){
            $_GET['view'] = "hsp";
          }
          ?>
          <tr>
            <td class="services_title">
              <?=$result->getQueryString() . " vs. <i>" . $bqRow["display_name"] . "</i> " . $bqRow["display_id"];?>&nbsp;&raquo;
            </td>
          </tr>
          <tr>
            <td style="padding:6px;" valign="top" bgcolor="#ffffff">
              <input type="hidden" name="result" value="html_results">
              <input type="hidden" name="resNum" value="<?=$_GET['resNum'];?>">
              <input type="hidden" name="job_id" value="<?=$_GET['job_id'];?>">
              <input type="hidden" name="getSequences" value="1">
              <!--<input type="hidden" name="sort" value="<?=$_GET['sort'];?>">-->
              <input type="hidden" name="page" value="fetch">
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td>
                    <table width="100%" bgcolor="#e3e3e3" cellspacing="1" cellpadding="1" border="0"> 
                      <tr>
                        <td bgcolor="#ffffff" align="center">
                          <input type="checkbox" name="all_check" id="Web:Misc_Help#check_all_blast_result_sequences" onclick="toggleCheckboxes();" class="hashelp"/>
                        </td>
                        <td bgcolor="#e8e8e8" style="width:150px;font-weight:bold;padding-left:3px;">
                          Hit Sequence
                        </td>
                        <?
                        if(!$_GET['sort']){
                          $_GET['sort'] = "evalue";
                          $_GET['by'] = "asc";
                        }
                        foreach($sortNameArray as $s1 =>$s2){
                          if($_GET['view'] == "hit"){
                            print "<td bgcolor=\"#eeeeee\" align=\"center\"><b>" . $s2 . "</b></td>";
                          } else {
                            if($_GET['sort'] == $s1){
                              print "<td align=\"center\" bgcolor=\"#d3d3d3\" width=\"60\"><a class=\"hashelp\" name=\"Web:Misc_Help#blast_column_order\" style=\"font-weight:bold;\" href=\"?by=";
                              if($_GET['by'] == "asc"){
                                print "desc";
                              } else {
                                print "asc";
                              }
                              print "&sort=" . $s1 . "&dispNum=".$_GET['dispNum']."&result=html_results&job_id=".$_GET['job_id']."&view=".$_GET['view']."&page=res&resNum=" . $_GET['resNum'] . "\">" . $s2 . "</td>";
                            } else {
                              print "<td bgcolor=\"#d3d3d3\" align=\"center\" width=\"60\"><a class=\"hashelp\" name=\"Web:Misc_Help#blast_column_order\" style=\"font-weight:bold;\" href=\"?by=";
                              if($s1 == "evalue"){
                                print "asc";
                              } else {
                                print "desc";
                              }
                              print "&sort=" . $s1 . "&dispNum=".$_GET['dispNum']."&page=res&result=html_results&job_id=".$_GET['job_id']."&view=".$_GET['view']."&resNum=" . $_GET['resNum'] . "\">" . $s2 . "</td>";
                            }
                          }
                        }
                        ?>
                      </tr>
                      <?
                        // HIT VIEW
                        if($_GET['view'] == "hit"){
                          $hits = $result->getHits();
                          $hitCount = 0;
                          foreach($hits as $hit){
                            if(sizeof($hit->getHsps()) != 0){
                              if($_GET['dispNum'] != 'all'){
                                if($hitCount >= $_GET['dispNum']){
                                  break;
                                }
                              }
                              ?>
                              <tr>
                              <td height="4" colspan="10" bgcolor="#fefefe">
                              </td>
                              </tr>
                              <tr>
                              <td align="center" valign="top" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][5];?>" rowspan="<?=sizeof($hit->getHsps())+1;?>">
                              <input class="small hashelp" id="Web:Misc_Help#blast_result_sequence_checkbox" type="checkbox" name="<?=$hit->getId()."n0";?>"/>
                              </td>
                              <td colspan="9" bgcolor="#fefefe" style="padding-left:3px;">
                              <?=$hit->getName();?>
                              </td>
                              </tr>
                              <?
//print_r($hit);
                              $hsps = $hit->getHsps();
                              $localHit = 1;
                              foreach($hsps as $hsp){
                                $hsp->setDisplayed( 1 );
                                $j = 0;
                                ?>
                                <tr>
                                <td bgcolor="#f4f4f4" style="padding-left:3px;" id="seq<?=$hsp->getId();?><?=$j++;?>">
                                <?
                                $dispString = "<a style=\'color:#0000ff\' href=\'/Tools/BLAST/?result=html_results&view=align";
                                $dispString .= "&job_id=" . $_GET['job_id'] . "&hsp_id=" . $hsp->getId() . "&resNum=" . $_GET['resNum'];
                                $dispString .= "\'>View Raw Alignment</a>";
                                preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(), $db);
                                clearstatcache();
                                $additional_dd_entries = "sections/Tools/tool_includes/BLAST/result_includes/" . $db[3] . ".php";
                                if(file_exists($additional_dd_entries)){
                                  //$querystart = $hsp->getQueryStart();
                                  //$queryend = $hsp->getQueryEnd();
                                  $start = $hsp->getHitStart();
                                  $end = $hsp->getHitEnd();
                                  $region = $hit->getName();
                                  $job_id = $_GET['job_id'];
                                  $rNum = $_GET['resNum'] -1;
                                  include("sections/Tools/tool_includes/BLAST/result_includes/".$db[3].".php");
                                }
                                ?>
                                <div class="seqName hashelp" style="color:#0000aa;" onclick="displayBlast(event, '<?=$dispString;?>');" id="Web:Misc_Help#blast_sequence_alignment_res">Hit <?=$localHit++;?></div>
                                <?
                                $i = true;
                                foreach($sortNameArray as $s1 => $s2){
                                  print "<td align=\"center\" bgcolor=\"#";
                                  if($i){
                                    print "fefefe";
                                  } else {
                                    print "f8f8f8";
                                  }
                                  $i = !$i;
                                  print "\" id=\"seq".$hsp->getId().$j++."\">";
                                  switch ($s1){
                                    case "querystart":
                                      print $hsp->getQueryStart();
                                      break;
                                    case "queryend":
                                      print $hsp->getQueryEnd();
                                      break;
                                    case "evalue":
                                      print $hsp->getEvalue();
                                      break;
                                    case "end":
                                      print $hsp->getHitEnd();
                                      break;
                                    case "start":
                                      print $hsp->getHitStart();
                                      break;
                                    case "score":
                                      print $hsp->getScore();
                                      break;
                                    case "length":
                                      print $hsp->getLength();
                                      break;
                                    case "identity":
                                      printf('%0.2f', $hsp->getIdentity());
                                      print "%";
                                      break;
                                    }
                                    print "</td>";
                                  }
                                  ?>
                                  </tr>
                                  <?
                                }
                                $hitCount++;
                              }
                          }
                        }
                        // HSP VIEW
                        else {
                          $hsps = $result->getSortedHsps($_GET['sort'], $_GET['by']);
                          $i = 0;
                          $hits = $result->getHits();
                          $hspNum = array();
                          foreach($hits as $hit){
                            $hspNum[$hit->getId()] = 0;
                          }
                          $hspCount = 0;
                          foreach($hsps as $hsp){
                            if($_GET['dispNum'] != 'all'){
                              if($hspCount >= $_GET['dispNum']){
                                break;
                              }
                            }
                            $hsp->setDisplayed( 1 );
                            $hit = $result->getHitByHspId( $hsp->getId() );
                            $dispString = "<a style=\'color:#0000ff\' href=\'/Tools/BLAST/?result=html_results&view=align";
                            $dispString .= "&job_id=" . $_GET['job_id'] . "&hsp_id=" . $hsp->getId() . "&resNum=" . $_GET['resNum'];
                            $dispString .= "\'>View Raw Alignment</a>";
                            preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(),$db);
                            clearstatcache();
                            // Check if file for database exists.  If yes, include file to concat to disp string
                            if(file_exists('sections/Tools/tool_includes/BLAST/result_includes/'.$db[3].'.php')){
                              $start = $hsp->getHitStart();
                              $end = $hsp->getHitEnd();
                              $region = $hit->getName();
                              $job_id = $_GET['job_id'];
                              $rNum = $_GET['resNum'] -1;
                              include("sections/Tools/tool_includes/BLAST/result_includes/".$db[3].".php");
                            }
                            $j=0;
                            ?>
                            <tr>
                              <td align="center" bgcolor="#ffffff">
                                <input class="small hashelp" type="checkbox" id="Web:Misc_Help#blast_result_sequence_checkbox" name="<?=$hit->getId()."n".$hspNum[$hit->getId()]++;?>" onclick="Javascript: checkSame(this, <?=$hit->getid();?>);"/>
                              </td>
                              <td style="padding-left:3px;" bgcolor="#f8f8f8" id="seq<?=$hsp->getId();?><?=$j++;?>">
                                <div style="color:#0000AA;" class="seqName hashelp" id="Web:Misc_Help#blast_sequence_alignment_res" onclick="displayBlast(event, '<?=$dispString;?>');" title="<?=$hsp->getId();?>">
                                  <?=$hit->getName();?>
                                </div>
                              </td>
                            <?
                            $i = true;
                            foreach($sortNameArray as $s1 => $s2){
                              print "<td align=\"center\" style=\"background-color:#";
                              if($i){
                                print "fefefe";
                              } else {
                                print "f8f8f8";
                              }
                              $i = !$i;
                              print ";\" id=\"seq".$hsp->getId().$j++."\">";
                              switch ($s1){
                                case "querystart":
                                  print $hsp->getQueryStart();
                                  break;
                                case "queryend":
                                  print $hsp->getQueryEnd();
                                  break;
                                case "evalue":
                                  print $hsp->getEvalue();
                                  break;
                                case "end":
                                  print $hsp->getHitEnd();
                                  break;
                                case "start":
                                  print $hsp->getHitStart();
                                  break;
                                case "score":
                                  print $hsp->getScore();
                                  break;
                                case "length":
                                  print $hsp->getLength();
                                  break;
                                case "identity":
                                  printf('%0.2f', $hsp->getIdentity());
                                  print "%";
                                  break;
                              }
                              print "</td>";
                            }
                            print "</tr>";
                            $hspCount++;
                          }
                        }
                      ?>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <?
        }
        ?>
        </table>
      </td>
      <!--
    </tr>
  </table>
  -->

  <?
// RIGHT SIDE VIEW
if(($_GET['view'] == "hsp") || ($_GET['view'] == "hit")){
  ?> 
  <!--
  <table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
    -->
      <td valign="top" width="200">
        <table cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr>
            <td class="services_title" style="font-size:11px;">
              Results Display
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff">
              <table border="0" width="100%" cellspacing="6" cellpadding="0">
                <tr>
                  <td>
                    <table border="0" cellspacing="1" cellpadding="1" width="100%">
                      <tr>
                        <td>
                          <b>
                            Sorting by:&nbsp;
                            <?
                              if($_GET['sort']){
                                print $sortNameArray[$_GET['sort']];
                              } else {
                                print "E-Value";
                              }
                              if($_GET['by'] == "desc"){
                                print ", descending";
                              } else {
                                print ", ascending";
                              }
                            ?>
                          </b>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="/sections/Tools/tool_includes/BLAST/raw_results.php?job_id=<?=$_GET['job_id'];?>" class="hashelp" name="Web:Misc_Help#view_raw_blast_results">&bull;&nbsp;View Raw Results&nbsp;&raquo;</a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="hashelp" id="Web:Misc_Help#group_blast_hits_by_hit"><input <?if($_GET['view']=="hit"){print "checked=\"checked\" ";}?>class="small" name="sortBox" id="sorBox" type="checkbox" onclick="sortResults('?result=html_results&page=res&job_id=<?=$_GET['job_id']?>&<?if(!$_GET['view']||$_GET['view']=='hsp'){ print "view=hit"; } else { print "view=hsp"; }?>&dispNum=<?=$_GET['dispNum']?>&resNum=<?=$_GET['resNum'];?>');"/>Group Results By Hit Sequence</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Display
                          <select name="Web:Misc_Help#blast_num_results_select" onchange="javascript:updateDspNum(this);" id="Web:Misc_Help#blast_num_results_select" class="small hashelp">
                          <?
                            $vals = array(5,10,50,100,500);
                            $selected = false;
                            foreach($vals as $val){
                              if(($_GET['view']=="hit" && $val < $result->getNumHits()) || ($_GET['view']=="hsp" && $val < $result->getNumHsps())){
                                print "<option value=\"" . $val . "\"";
                                if($val == $_GET['dispNum']){
                                  print " selected=\"SELECTED\"";
                                  $selected=true;
                                }
                                print ">" . $val . "</option>\n";
                              }
                            }
                            print "<option value=\"all\"";
                            if(!$selected){
                              print " selected=\"SELECTED\"";
                            }
                            print ">All (";
                            if($_GET['view']=="hit"){
                              print $result->getNumHits();
                            } else {
                              print $result->getNumHsps();
                            }
                            print ")</option>";
                          ?>
                          </select> Results
                        </td>
                      </tr>
                      <tr>
                        <td height="5">
                        </td>
                      </tr>
                      <tr>
                        <td align="center" style="padding: 5px;" bgcolor="#<?=DV::$OCS[$_SESSION["organism_id"]][3];?>">
                          <select type="submit" id="Web:Misc_Help#download_blast_result_sequences"  name="actionMenu" class="small hashelp" onchange="submitSequences(this)" >
                            <option value="default" selected="SELECTED" />--Select Action--</option>
                            <option value="download" />Download Checked Hit Sequences</option>
                            <?
                            preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(), $db);
                            if($db[3] != 'agambiae.CHROMOSOMES-PEST.AgamP3.fa' && $db[3] != 'aaegypti.SUPERCONTIGS-Liverpool.AaegL1.fa'){
                            ?>
                            <option value="clustal" />Pass Checked Sequences to ClustalW</option>
                            <?
                            }
                            ?>
                          </select>
                          <!--<input id="Web:download_blast_result_sequences" type="submit" value="Download Checked Hit Sequences" class="small hashelp"/>
                          -->
                        </td>
                      <tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <?
          if($result->getDb() == 'agambiae.CHROMOSOMES-PEST.AgamP3.fa' ){
            ?>
          <!-- Chromosome Boxes -->
          <tr>
            <td>
            </td>
          </tr>
          <tr>
            <td class="services_title" style="font-size:11px;">
              Chromosome
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff">
              <table border="0" width="100" cellspacing="1" cellpadding="0">
                <tr>
                  <td>
                    <table border="0" cellspacing="1" cellpadding="1" width="100%">
                      <tr>
                        <td>
                          <?
                          $imgs = array(array("name"=>"3R"), array("name"=>"3L"), array("name"=>"2R"), array("name"=>"2L"), array("name"=>"X"));
                          $imgIter = 0;
                          $hitIter = 1;
                          $total = 0;
                          $sort = 'evalue';
                          $by = 'asc';

                          if($_GET['sort']){
                            $sort = $_GET['sort'];
                          }
                          if($_GET['by']){
                            $by=$_GET['by'];
                          }
                          if($result->getDb() == 'agambiae.CHROMOSOMES-PEST.AgamP3.fa' ){
                            foreach($result->getSortedHsps($sort, $by) as $hsp){
                              if($hsp->getDisplayed() == 1){
                                if($total < 50){
                                  for($imgIter = 0; $imgIter < count($imgs) && $imgs[$imgIter]["name"] != $hsp->getParent()->getName(); $imgIter++){
                                  }
                                  if(($hsp->getParent()->getName() != 'UNKN') && ($hsp->getParent()->getName() != 'Y')){
                                    array_push($imgs[$imgIter], 
                                      array("start"=>$hsp->getHitStart(), "end"=>$hsp->getHitEnd(), "name"=>$hsp->getParent()->getName, "hsp_id"=>$hsp->getId())
                                    );
                                    $total++;
                                  }
                                }
                              }
                            }
                          }
                          ?>
                          <?
                          require_once("searching.php");
                          $num = 0;
                          $organism = new Organism("Anopheles", "gambiae");
                          print "<table><tr>";
                          foreach($imgs as $img){
                            $chr = new Chromosome($img['name'], $organism);
                            print "<td style=\"padding-left:11px; padding-right:11px;\"><img id=\"img_hit" . $num . "\" src=\"/imgs/blank.gif\" alt=\"testing\" usemap=\"#map_hit" . $num . "\" />";
                            print "\n<map name=\"map_hit" . $num . "\">";
                            $hit_objects = array();
                            for($i = 0; $i < count($img)-1; $i++){
                              array_push($hit_objects, new Hit($img["name"], $organism, $img[$i]['start'], $img[$i]['end']));
                            }
                            $imgMap = new HitsMap($chr, $hit_objects, 400);
                            $i = 0;
                            foreach($imgMap->getMap() as $coords){
                              print "\n<area shape=\"rect\" coords=\"";
                              preg_match("/([^\.]*)\..*/", $coords[0][0], $coord);
                              print ($coords[0][1]-13) . "," . ($coord[1]-6) . ",";
                              print ($coords[0][1]+8) . "," . ($coord[1]+6);
                              // the href - change it
                              $dispString = "<a style=\'color:#0000ff\' href=\'/Tools/BLAST/?result=html_results&view=align&job_id=";
                              $dispString .= $_GET['job_id'] ."&hsp_id=" . $img[$i]['hsp_id'] . "&resNum=" . $_GET['resNum'] . "\'>View Raw Alignment</a>";
                              preg_match("/((\/.*)*\/)*(.+)/", $result->getDb(), $db);
                              clearstatcache();
                              $additional_dd_entries = "sections/Tools/tool_includes/BLAST/result_includes/" . $db[3] . ".php";
                              if(file_exists($additional_dd_entries)){
                                $start = $img[$i]['start'];
                                $end = $img[$i]['end'];
                                $region = $img['name'];
                                $job_id = $_GET['job_id'];
                                include($additional_dd_entries);
                              }
                              print "\" class=\"chromName hashelp\" onclick=\"displayBlast(event, '" . $dispString . "');\" id=\"Web:Misc_Help#blast_sequence_alignment_res\" title=\"" . $img[$i]['hsp_id'] . "\" href=\"#\">";
                              $i++;
                            }
                            print "\n</map></td>";
                            $num++;
                          }
                          print "</tr></table>";
                          ?>
                          <script language="JavaScript" type="text/javascript">
                            function addListener(element, event, listener, bubble) {
                              if(element.addEventListener) {
                                // Firefox
                                if(typeof(bubble) == "undefined") bubble = false;
                                element.addEventListener(event, listener, bubble);
                              } else if(this.attachEvent) {
                                // IE
                                element.attachEvent("on" + event, listener);
                              } else if(element.onload == null) {
                                // Safari
                                element.onload = listener;
                              }
                            }
                          <?
                          $num = 0;
                          //print "<pre>";
                          //print_r($imgs);
                          //print "</pre>";
                          //exit;
                          foreach( $imgs as $img ){
                              $imgsrc = "/imgs/dynamic/ChromosomeHits.php?display=vert&chr=" . $img["name"] . "&organism=" . $organism->dataName();
                              for($i = 0; $i < count($img)-1; $i++){
                                $imgsrc .= "&hits[" . $i . "][start]=" . $img[$i]["start"] . "&hits[" . $i . "][end]=" . $img[$i]["end"] . "&hits[" . $i . "][name]=" . $img[$i]["name"];
                                }
                              //print "\nvar hit" . $num . " = new Image(400, 17);";
                              //print "\nhit" . $num . ".src = '" . $imgsrc . "';";
                              print "\ndocument.getElementById('img_hit" . $num . "').src = '" . $imgsrc . "';\n";
                              //print "\naddListener(hit" . $num . ", 'load', function() {document.getElementById('img_hit" . $num . "').src = '" . $imgsrc . "'; });\n";
                              $num++;
                          }
                          ?>
                          </script>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- End Chromosome Boxes -->
          <?
          }
          ?>
        </table>
      </td>

  <?
}
if(!$_GET['header']){
    print "</tr>";
  print "</table>";
print "</form>";
}

function getResult($job_id, $res_id, $db){
  //$_GET['hr'] = basename($_GET['hr']);
  $query = "select hash from blast_hashes where blast_id = " . $job_id . " and result_id = " . $res_id;
  $rs = pg_query($db,$query);
  $row = pg_fetch_assoc($rs);
  return unserialize(pg_unescape_bytea(stripslashes($row['hash'])));
}


function displayAlignment($res, $hit, $hsp){
  $ret = "<tr>\n<td class=\"services_title\">\n";
  $ret .= "Alignment for Result&nbsp;&raquo;\n";
  $ret .= "</td>\n</tr>\n<tr>\n<td valign=\"top\" bgcolor=\"#ffffff\">\n";
  $ret .= "<table border=\"0\" cellspacing=\"6\" cellpadding=\"0\">\n";
  $ret .= "<tr>\n<td>\n";
  $ret .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";
  $ret .= "<tr>\n<td>\nQuery Sequence:\n</td>\n<td>\n" . $res->getQueryString() . "\n</td>\n</tr>\n";
	preg_match("/((\/.*)*\/)*(.+)/", $res->getDb(), $db);
	$blastQ = "select o.full_name,o.display_name,b.display_id from organism o, blast_databases b where b.file_name = '" . $db[3] . "' and b.organism_id = o.organism_id";
	$bqResults = pg_query(DB::getUI_DB(), $blastQ);
	$bqRow = pg_fetch_assoc($bqResults);
	if(!$bqRow){
	//this is an est db
		$blastQ = "select species, short_name from blast_est where filename = '" . $db[3] . "'";
		$bqResults = pg_query(DB::getUI_DB(), $blastQ);
		$bqRow = pg_fetch_assoc($bqResults);
		$bqRow["display_name"] = ORG::$DN[ORG::$LTS[$bqRow["species"]]];
		$bqRow["display_id"]= $bqRow["short_name"];
	}

  $ret .= "<tr>\n<td>\nTarget Database:\n</td>\n<td>\n<i>" . $bqRow["display_name"] . "</i> " . $bqRow["display_id"] . "\n</td>\n</tr>\n";
  $ret .= "<tr>\n<td>\nDatabase Hit:\n</td>\n<td>\n" . $hit->getName() . "\n</td>\n</tr>\n";
  $ret .= "<tr>\n<td>\nAlignment Score:\n</td>\n<td>\n" . $hsp->getScore() . "\n</td>\n</tr>\n";
  $ret .= "<tr>\n<td>\nE-Value:\n</td>\n<td>\n" . $hsp->getEvalue() . "\n</td>\n</tr>\n";
  $ret .= "<tr>\n<td>\nAlignment Length:\n</td>\n<td>\n" . $hsp->getLength() . "\n</td>\n</tr>\n";
  $ret .= "<tr>\n<td>\nSequence Identity:\n</td>\n<td>\n" . round((float)$hsp->getIdentity(), 3) . " %\n</td>\n</tr>\n";


 // find out what kind of blast job was being run, display frame for translated jobs, strand for non-translated ones
    $sql="select value from job_params where argument='program' and job_id=".$_GET['job_id'];
    $rs = pg_query( DB::getJOB_DB(),$sql);
    $row = pg_fetch_assoc($rs);
    if($row["value"]=="tblastn" ){
	$ret .= "<tr>\n<td>\nFrame:\n</td>\n<td>\n";
        if(($hsp->getHitFrame()+1)*$hsp->getHitStrand()>0) $ret.="+";
	$ret.= ($hsp->getHitFrame()+1)*$hsp->getHitStrand();
	$ret.="\n</td>\n</tr>\n";
	$transBlastFactor=3;
    }elseif( $row["value"]=="tblastx" ){
	$ret .= "<tr>\n<td>\nFrame:\n</td>\n<td>\n";
        if($hsp->getQueryStrand()>0) $ret.="+";
	$ret.= $hsp->getQueryStrand() ." / ";
	if( ($hsp->getHitFrame()+1)*$hsp->getHitStrand() >0) $ret.="+";

	$ret.=($hsp->getHitFrame()+1)*$hsp->getHitStrand();
	$ret.="\n</td>\n</tr>\n";
	$transBlastFactor=3;
    }elseif( $row["value"]=="blastx" ){
	// GAAAHHHH!!! this doesn't work!!! will return same query/strand info for 2 differnet blasts but will have different frames in the raw output...leave out for now
/*
	$ret .= "<tr>\n<td>\nFrame:\n</td>\n<td>\n";
        if(($hsp->getQueryFrame()+1)*$hsp->getQueryStrand()>0) $ret.="+";
	$ret.= ($hsp->getQueryFrame()+1)*$hsp->getQueryStrand();
	$ret.="\n</td>\n</tr>\n";
*/
	//just display strand info instead
	$ret .= "<tr>\n<td>\nStrand:\n</td>\n<td>\n";
	if($hsp->getQueryStrand() == -1)
		$ret.= "Minus";
	else
		$ret.= "Plus";

	$ret.=" \ ";
	if($hsp->getHitStrand() == -1)
		$ret.= "Minus";
	else
		$ret.= "Plus";
	$ret.="\n</td>\n</tr>\n";

	$transBlastFactor=3;
    }else{
	  $ret .= "<tr>\n<td>\nStrand:\n</td>\n<td>\n";

	  if($hsp->getQueryStrand() == 1)
		$ret.="Plus / ";
	  elseif($hsp->getQueryStrand() == 0) // zero for peptide searches
		$ret.="Plus / ";
	  else
		$ret.="Minus / ";

	  if($hsp->getHitStrand() == 1){
		$ret .= "Plus";
		$hitStartIter = $hsp->getHitStart();
	  }elseif($hsp->getHitStrand() == 0){ // zero for peptide searches
		$ret.="Plus";
		$hitStartIter = $hsp->getHitStart();
	  } else {
		$ret .= "Minus";
		$hitStartIter = $hsp->getHitEnd();
	  }
	 
	  $ret .= "\n</td>\n</\tr>\n";

	$transBlastFactor=1;
  }


  //determine start position
	  if($hsp->getHitStrand() == 1 || $hsp->getHitStrand() == 0)// zero for peptide searches
		$hitStartIter = $hsp->getHitStart();
	  else
		$hitStartIter = $hsp->getHitEnd();


  $ret .= "</table>\n";
  $ret .= "<hr size=\"1\">\n";
  $ret .= "<table>\n";
  $ret .= "<tr>\n";
  $ret .= "<td>\n";
  $ret .= "<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"100%\" >\n";

  // Drawing our sequence
  $charsPerLine = 60;
   if($hsp->getQueryStrand() == -1)
	$queryStartIter = $hsp->getQueryEnd();
   else
	$queryStartIter = $hsp->getQueryStart();

  $done = 0;
  $i = 0;
  while($done != 1){
    $queryCount = substr_count(
      substr($hsp->getQueryString(), ($charsPerLine*$i), $charsPerLine),
      "-"
    );
    $hitCount = substr_count(
      substr($hsp->getHitString(), ($charsPerLine*$i), $charsPerLine),
      "-"
    );
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "Query:&nbsp;\n";
    $ret .= "</td>\n";
    $ret .= "<td align=\"right\">\n";
    $ret .= $queryStartIter;
    $ret .= "\n</td>\n";
    $ret .= "<td style=\"font-family: monospace;\">\n";
    $ret .= "&nbsp;";
    $ret .= substr($hsp->getQueryString(), $charsPerLine*$i, $charsPerLine);
    $qLen = strlen(substr($hsp->getQueryString(), $charsPerLine*$i, $charsPerLine));
    $ret .= "</td>\n";
    $ret .= "<td>\n";

    if($hsp->getQueryStrand() == -1)
	$queryStartIter = $queryStartIter + ($queryCount - $qLen)*$transBlastFactor + 1;
    else
	$queryStartIter = $queryStartIter + ($queryCount + $qLen)*$transBlastFactor - 1;

    $ret .= $queryStartIter;
    $ret .= "\n</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "<td style=\"font-family:monospace\">\n";
    $ret .= "&nbsp;" . preg_replace("/\s/", "&nbsp;", substr($hsp->getHomologyString(), $charsPerLine*$i, $charsPerLine)) . "&nbsp;\n";
    $ret .= "\n</td>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "Sbjct:&nbsp;\n";
    $ret .= "</td>\n";
    $ret .= "<td align=\"right\">\n";

    $ret .= $hitStartIter;
    $ret .= "\n</td>\n";
    $ret .= "<td style=\"font-family: monospace;\">\n";
    $ret .= "&nbsp;";
    $ret .= substr($hsp->getHitString(), $charsPerLine*$i, $charsPerLine);
    $hLen = strlen(substr($hsp->getHitString(), $charsPerLine*$i, $charsPerLine));
    $ret .= "</td>\n";
    $ret .= "<td>\n";




 // need to account for start/end values in the subject for peptide vs translated nucleotide searches
/*
$ret.=$queryCount;
$ret.="<br/>";
$ret.=$charsPerLine;
$ret.="<br/>";
$ret.=$qLen;
$ret.="<br/>";
//$ret.=;
*/
  //for minus strand subtract, for plus strand add
    if($hsp->getHitStrand() == 1){ //Plus
//       $ret .= ($hitStartIter + ($charsPerLine  - ($charsPerLine-$hLen) -1 )*$transBlastFactor - $hitCount);
       $ret .= ($hitStartIter + ($hLen-$hitCount)*$transBlastFactor -1 );
       $hitStartIter += ($charsPerLine - $hitCount)*$transBlastFactor;
    }elseif($hsp->getHitStrand() == 0){ // peptides are always +/+
       $ret .= ($hitStartIter + $charsPerLine - $hitCount - ($charsPerLine-$hLen) - 1);
       $hitStartIter += ($charsPerLine - $hitCount);
    }else{ //Minus
//       $ret .= ($hitStartIter - ($charsPerLine + $hitCount + ($charsPerLine-$hLen) + 1)*$transBlastFactor );
       $ret .= ($hitStartIter - ($hLen-$hitCount)*$transBlastFactor +1);
       $hitStartIter -= ($charsPerLine - $hitCount)*$transBlastFactor;
    }
 
    $ret .= "\n</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td height=\"10\">\n";
    $ret .= "</td>\n";
    $ret .= "</tr>\n";

   if($hsp->getQueryStrand() == -1){
		$queryStartIter--;
	    if($queryStartIter <= $hsp->getQueryStart() ){
	      $done = 1;
	    }
   }else{
		$queryStartIter++;
	    if($queryStartIter >= $hsp->getQueryEnd()){
	      $done = 1;
	    }
   }
    $i++;

if($i==10) $done=1;

  }
  /*
  // Drawing our sequence
  $aIter = 0;
  while( abs($aIter) < strlen($hsp->getQueryString()) && !$done ){
    if($hsp->getStrand() == 1){
      if( ($start + $aIter + $incValue) > $end ){
        $incValue = $end - ($start + $aIter);
        $done = 1;
      }
    } else {
      //if( ($start + $aIter + $incValue) < $end ){
      if( ($start + $aIter + $incValue) < $end ){
        $incValue = $end - ($start + $aIter);
        $done = 1;
      }
    }
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "Query:&nbsp;\n";
    $ret .= "</td>\n";
    $ret .= "<td align=\"right\">\n";
    $ret .= $hsp->getQueryStart()+abs($aIter);
    $ret .= "\n</td>\n";
    $ret .= "<td style=\"font-family: monospace;\">\n";
    $ret .= "&nbsp;" . preg_replace("/\s/", "&nbsp;", substr($hsp->getQueryString(),abs($aIter),abs($incValue))) . "&nbsp;\n";
    $ret .= "</td>\n";
    $ret .= "<td>\n";
    $ret .= $hsp->getQueryStart()+abs($aIter+$incValue);
    $ret .= "\n</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "<td style=\"font-family:monospace\">\n";
    $ret .= "&nbsp;" . preg_replace("/\s/", "&nbsp;", substr($hsp->getHomologyString(),abs($aIter),abs($incValue)));
    $ret .= "\n</td>\n";
    $ret .= "<td>\n";
    $ret .= "</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td>\n";
    $ret .= "Sbjct:&nbsp;\n";
    $ret .= "</td>\n";
    $ret .= "<td align=\"right\">\n";
    $ret .= $start+$aIter;
    $ret .= "</td>\n";
    $ret .= "<td style=\"font-family: monospace;\">\n";
    $ret .= "&nbsp;" . preg_replace("/\s/", "&nbsp;", substr($hsp->getHitString(),abs($aIter),abs($incValue)));
    $ret .= "\n</td>\n";
    $ret .= "<td>\n";
    $ret .= $start+$aIter+$incValue;
    $ret .= "\n</td>\n";
    $ret .= "</tr>\n";
    $ret .= "<tr>\n";
    $ret .= "<td height=\"10\">\n";
    $ret .= "</td>\n";
    $ret .= "</tr>\n";
    $aIter += $incValue;
  }
  */
  $ret .= "</table>\n";
  $ret .= "</td>\n";
  $ret .= "</tr>\n";
  $ret .= "</table>\n";
  $ret .= "</td>\n</tr>\n";
  $ret .= "</table>\n";
  $ret .= "</td>\n</tr>\n";
  return $ret;
}
?>
