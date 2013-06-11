<html>
<head>
<title>VectorBase - Insecticide Resistance - Assay</title>
</head>
<body>
<!-- <table width="800" align="center">
	<tr><td align="left"><a href="http://www.vectorbase.org" ><img src="http://www.anobase.org/images/VectorBase_sm.jpg" border="0"></a></td>
	<td valign="top" align="right"><b>Insecticide Resistance</b></td></tr>
</table> -->
<br><br></br>
<table width=750 align=center class="std_table">
<?php
$irPath2 = drupal_get_path('module', 'irbase');
$irPath2 .= '/includes';
require_once("$irPath2/IRBaseConnect.php");
//include("$irPath2/anobase.css");
$dbConn = connectIRBase();

if( isset( $_GET['id'] ) )
{
	echo "<tr><td colspan=\"6\" align=\"center\" class=\"services_title\">Assay details</td></tr>";
	$query = "SELECT *
				FROM assay
				WHERE assay_id = $_GET[id]";

	$result = mysql_query( $query, $dbConn );

	if( $myrow = mysql_fetch_array( $result ) )		{
			echo "<tr><td class=\"cell_value_r\">Collection ID*:</td><td class=\"cell_value\">";
			//$theBaseUrl3 = 'https://' . $_SERVER['HTTP_HOST'] . "/$irPath";
			//divAC.innerHTML=getDataFromServer("<?print $theBaseUrl2; ?>/autoComplete.php?oid="+tbxId+"&q="+tbxValue);

			echo "<a href=\"/content/ir-collection?id=$myrow[population_id]\">$myrow[population_id]</a></td></tr>\n";
			echo "<tr><td class=\"cell_key\">Assay ID:</td><td class=\"cell_value\" width=\"75%\">$myrow[assay_id]</td></tr>\n";
			echo "<tr><td class=\"cell_key\">Mosquitoes used:</td><td class=\"cell_value\">".gettermname( $dbConn, $myrow['mosquitoes_used_id'] )."</td></tr>\n";
			echo "<tr><td class=\"cell_key\">Age:</td><td class=\"cell_value\">$myrow[age]</td></tr>\n";
			echo "<tr><td class=\"cell_key\">Sample size:</td><td class=\"cell_value\">$myrow[sample_size]</td></tr>";
			echo "<tr><td class=\"cell_key\">Insecticide:</td><td class=\"cell_value\">";
			if( $myrow['insecticide_id']  == "Control" )
				echo "Control";
			else
				echo gettermname( $dbConn, $myrow['insecticide_id']);
			echo "</td></tr>";
			echo "<tr><td class=\"cell_key\">Insecticide concentration:</td><td class=\"cell_value\">$myrow[insecticide_concentration]</td></tr>\n";
			echo "<tr><td class=\"cell_key\">Method:</td><td class=\"cell_value\">".gettermname( $dbConn, $myrow['assay_method_id'] )."</td></tr>\n";
			$results = explode( ";", $myrow['result'] );
			for( $t=0; $t< count( $results ); $t++ )	{
                                // echo "<tr><td class=\"cell_key\">HEREEE:</td><td class=\"cell_value\">$results[0]</td></tr>\n";
				$res_line = explode( ":", $results[$t] );
				if( $res_line [0] != "" && $res_line[1] != " " )
					echo "<tr><td class=\"cell_key\">$res_line[0]:</td><td class=\"cell_value\">$res_line[1]</td></tr>\n";
			}
			echo "<tr><td class=\"cell_key\">Mechanism of resistance:</td><td class=\"cell_value\">".gettermname( $dbConn, $myrow['resistance_mechanism_id'] )."</td></tr>\n";
			echo "<tr><td class=\"cell_key\">Resistance gene frequency:</td><td class=\"cell_value\">$myrow[resistance_gene_frequency]</td></tr>\n";
			echo "<tr><td class=\"cell_key\" valign=\"top\">Submitter notes:</td><td class=\"cell_value\">$myrow[public_notes]</td></tr>";
			echo "<tr><td colspan=\"2\" class=\"plain\">&nbsp;</td></tr>";
			echo "<tr><td colspan=\"2\" class=\"plain\">* click on the collection ID to view more information about the mosquitoes used in this assay</td></tr>";
	}
	else
		echo "<tr><td colspan=\"6\">No matches found.</td></tr>";
}
?>
</table>
<script type="text/javascript">
         var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
         document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>

 <script type="text/javascript">
         try {
         var pageTracker = _gat._getTracker("UA-6417661-1");
         pageTracker._setDomainName(".vectorbase.org");
         pageTracker._trackPageview();
         } catch(err) {}
 </script>
</body>
</html>