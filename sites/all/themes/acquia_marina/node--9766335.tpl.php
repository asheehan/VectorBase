<?php

define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT . '/includes/bootstrap.inc');
$phase = drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$irPath = drupal_get_path('module', 'irbase');
$irPath .= '/includes';
$sid = "ses".substr( md5(session_id()), 0, 12);
//include_once("$irPath/IRBaseConnect.php");
require_once("$irPath/IRBaseConnect.php");
print '<script language="javascript">';
include("$irPath/ajax2.php");
print '</script>';
$dbConn = connectIRBase();
?>
<html>
<head>
<title>VectorBase - Insecticide Resistance</title>
<?php include($irPath . '/anobase.css'); ?>
</head>
<body>
<div id="divAutoComplete" class="autocomp" style="left:0px;top:0px;width: 200px"></div>
<!--<script language="javascript" src="<?php print "$irPath/ajax2.php";?>"></script>-->
<br>
<br>
<br>
<br>
<table width="800" align="center" class="std_table">
	<tr><td colspan="3" class="services_title">Insecticide Resistance Database Search</td></tr>
	<tr><td colspan="3" class="plain">
	You may use only one, or multiple criteria to query the database.<br><br>
	There are two ways to fill in the search parameters, the drop-down menus or the auto-complete text field. Both ways
	include exactly the same ontology-derived data.<br><br>
	For example, if you want to perform an insecticide based search using "malathion" then you can either use the drop-down
	menus and choose "acetylcholine esterase inhibition", then "organophosphates" and then "malathion". Alternatively, you may
	use the auto-complete text field and type "ma". A list of all the insecticides in the ontology that contain the syllable "ma" will
	appear and then you may	click on "malathion".
	</td></tr>
	<tr><td colspan="3" class="col_key"><br><b>Select query criteria</b><br><br></td></tr>
	<tr>
		<td class="cell_key" width="20"><input type="checkbox" id="cbxs" onclick="swapDivContent('s')"></td>
<?php include("$irPath/selectSpecies.php"); ?>
	</tr>
	<tr>
		<td class="cell_key"><input type="checkbox" id="cbxl" onclick="swapDivContent('l')"></td>
<?php include("$irPath/selectLocation.php"); ?>
	</tr>
	<tr>
		<td class="cell_key"><input type="checkbox" id="cbxy" onclick="swapDivContent('y')"></td>
		<td class="cell_key">Year:</td>
		<td class="cell_value">
		<div id="div_y">
		<select id="y" name="y">
			<option value="----">----</option>
<?
	$query = "SELECT DISTINCT(LEFT(collection_start_date ,4)) AS year FROM population WHERE LEFT(collection_start_date ,4)>0 ORDER BY year DESC";
	$result = mysql_query( $query, $dbConn );
	while( $row = mysql_fetch_array( $result ) )
		print "			<option value=\"$row[year]\">$row[year]</option>\n";

	print "</select>\n&nbsp;&nbsp;to (optional):&nbsp;\n";
	print "<select id=\"y_to\" name=\"y_to\">\n";
	print "<option value=\"----\">----</option>";

	$query = "SELECT DISTINCT(LEFT(collection_start_date ,4)) AS year FROM population WHERE LEFT(collection_start_date ,4)>0 ORDER BY year DESC";
	$result = mysql_query( $query, $dbConn );
	while( $row = mysql_fetch_array( $result ) )
		print "<option value=\"$row[year]\">$row[year]</option>\n";

	print "</select>\n";

	print '</div></td></tr>'; ?>
	<tr><td class="cell_key"><input type="checkbox" id="cbxi" onclick="swapDivContent('i')"></td>
<?php include("$irPath/selectInsecticide.php"); ?>
	</tr>
	<tr>
		<td class="cell_key"><input type="checkbox" id="cbxrm" onclick="swapDivContent('rm')"></td>
<?php include("$irPath/selectResistanceMechanism.php"); ?>
	</tr>
	<tr>
		<td class="cell_key"><input type="checkbox" id="cbxa" onclick="swapDivContent('a')"></td>
<?php include("$irPath/selectAssayMethod.php"); ?>
	</tr>
	<tr>
		<td class="cell_key"><input type="checkbox" id="cbxmu" onclick="swapDivContent('mu')"></td>
<?php include("$irPath/selectMosquitoesUsed.php"); ?>
	</tr>
<tr>
		<td class="cell_key"><input type="checkbox" id="cbxcm" onclick="swapDivContent('cm')"></td>
<?php
	include("$irPath/selectCatchMethod.php");

	print '</tr><tr><td colspan="2" class="cell_key" align="right">&nbsp;</td>';
	print '<td class="cell_key" align="right" width="80%"><input type="button" value=" Search " onclick="submitSearch()"></td></tr>';
?>
  
	<tr><td colspan="3" class="plain">Database statistics - Studies:144&nbsp;&nbsp;Mosquito population samples:1330&nbsp;&nbsp;Assays:5190</td></tr>
	<tr><td colspan="3"><div class="irbase_results"></div></td></tr>
</table>
<script language="javascript">
var sid='<?php print $sid; ?>';
document.getElementById("div_s5").style.visibility='hidden';
document.getElementById("div_s6").style.visibility='hidden';
document.getElementById("div_s7").style.visibility='hidden';
document.getElementById("div_s").value=document.getElementById("div_s").innerHTML;
document.getElementById("div_s").innerHTML="";
document.getElementById("div_l").value=document.getElementById("div_l").innerHTML;
document.getElementById("div_l").innerHTML="";
document.getElementById("div_y").value=document.getElementById("div_y").innerHTML;
document.getElementById("div_y").innerHTML="";
document.getElementById("div_i").value=document.getElementById("div_i").innerHTML;
document.getElementById("div_i").innerHTML="";
document.getElementById("div_rm").value=document.getElementById("div_rm").innerHTML;
document.getElementById("div_rm").innerHTML="";
document.getElementById("div_a").value=document.getElementById("div_a").innerHTML;
document.getElementById("div_a").innerHTML="";
document.getElementById("div_mu").value=document.getElementById("div_mu").innerHTML;
document.getElementById("div_mu").innerHTML="";
document.getElementById("div_cm").value=document.getElementById("div_cm").innerHTML;
document.getElementById("div_cm").innerHTML="";
</script>

</body>
</html>
