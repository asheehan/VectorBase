<html>

<script language="javascript">
function selectAll( sequencesCount )
{
	if( document.getElementById("cbxSelectAll").checked )
	{
		for( n = 1; n <= sequencesCount; n++ )
			document.getElementById("cbx_"+n).checked = true;
	}	
	else
	{
		for( n = 1; n <= sequencesCount; n++ )
			document.getElementById("cbx_"+n).checked = false;
	}
}

function downloadSequences( sequencesCount )
{
        ids = "";
	for( n = 1; n <= sequencesCount; n++ ) 
	{
		if( document.getElementById("cbx_"+n).checked )
		{
			if( ids != "" )
			{
				ids = ids + ",";
			}		
			ids = ids + document.getElementById("cbx_"+n).value;
		}
	}

	while( ids.indexOf( ", " ) >= 0 )
        {
		ids = ids.replace( ", ", "," );
	}

	while( ids.indexOf( ",," ) >= 0 )
        {
		ids = ids.replace( ",,", "," );
	}

	url = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=nucleotide&rettype=fasta&retmode=text&id="+ids;
  
       this.window.location = url;
}
</script>
<?php

$sequencesCount = 0;

$form['#method'] = 'get';


function printPartialSequences($query, $db)
{ 
 $sequencesCount = 0;

  $res = mysql_query($query, $db);
  if($row = mysql_fetch_array($res))
{
    print "<tr><td>&nbsp;</td><td class=\"cell_key\">Ac. Num.</td><td class=\"cell_key\">Description</td>\n";
    print "<td class=\"cell_key\">Gene(s)</td><td align=\"center\" class=\"cell_key\">Sequence / <i>A. gambiae</i> match</tr>";
    do
 {
      $sequencesCount++;

     print "<tr><td><input type=\"checkbox\" id=\"cbx_".$sequencesCount."\" value=\"" . $row['acnum'] . "\"></td>";
      print "<td class=\"cell_value\"><a href=\"http://www.ncbi.nlm.nih.gov/entrez/viewer.fcgi?val=" . $row['acnum'] . "\"  target=\"_blank\">" . $row['acnum'] . " </a></td>";
      print "<td class=\"cell_value\">" . $row['definition'] . "</td><td class=\"cell_value\">" . $row['gene'] . "</td>";
      print "<td align=\"center\" class=\"cell_value\">" . $row['query_start'] . "-" . $row['query_end'] . "/" . $row['hit_start'] . "-" . $row['hit_end'];
      print "</td></tr>\n";

     }
    while($row = mysql_fetch_array($res));
  }
  else
  {
    print "<tr><td colspan=\"4\" class=\"cell_value\">No matches found.</td></tr>\n";
  }

return  $sequencesCount;
}

function printCompleteSequences($query, $db, $sequencesCount )
{ 
  $res = mysql_query($query, $db);
  if($row = mysql_fetch_array($res))
{
    print "<tr><td>&nbsp;</td><td class=\"cell_key\">Ac. Num.</td><td class=\"cell_key\">Description</td></tr>\n";

    do
 {
      $sequencesCount++;

     print "<tr><td><input type=\"checkbox\" id=\"cbx_".$sequencesCount."\" value=\"" . $row['acnum'] . "\"></td>";
      print "<td class=\"cell_value\"><a href=\"http://www.ncbi.nlm.nih.gov/entrez/viewer.fcgi?val=" . $row['acnum'] . "\"  target=\"_blank\">" . $row['acnum'] . " </a></td>";
      print "<td class=\"cell_value\">" . $row['definition'] . "</td></tr>\n";

     }
    while($row = mysql_fetch_array($res));
  }
  else
  {
    print "<tr><td colspan=\"4\" class=\"cell_value\">No matches found.</td></tr>\n";
  }

return  $sequencesCount;
}






/* Database Connection */
$mitoDB = mysql_connect ("localhost","mito","m1t0drUp@l");
if(!$mitoDB){die('Not Connected: ' . mysql_error());}
mysql_select_db("mitochondria", $mitoDB);


/* The main page */
if (!isset($_GET['ref'])) {

echo '<table width="600" cellpadding="0" cellspacing="10" border="0">';
?>
  <tr>
    <td>
This section provides the user with a compilation of mtDNA sequences for species of the genus <i>Anopheles</i>, as submitted to the NCBI nucleic acid sequence database by different authors. Although the lists are updated regularly, some species may be absent at the time of your search.</td></tr><tr><td>
You may click on a specific mitochondrial locus or on a species name 
to access a list of all available sequences.</td></tr><tr><td>
Last update: June 2013 - 308 species / 13340 GenBank entries
    </td>
  </tr>
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <b>Mitochondrial Genes List&nbsp;&raquo;</b>
          </td>
        </tr>
        <tr> 
           <td height="2"> 
          </td>
        </tr>
        <tr>
          <td height="4">
          </td>
        </tr>
        <tr>
          <td bgcolor="#ffffff">
            <table class="trace_table_collapse" width="600">
              <tr> 
            
  <?php
	$n = 0;
	$query1 = "SELECT DISTINCT name, synonym, sequences_count FROM ano_mitochondrial_genes ORDER BY name ASC";
	$result1 = mysql_query($query1, $mitoDB);

/* Retrieve list of mito Genes */
if($row = mysql_fetch_array($result1)){
  do{
    echo "<td class=\"value\"><a class=\"hashelp\" name=\"Web:mt_gene_list_gene\" href=\"anopheles-mitochondrial-genes?ref=seq&gene=" . $row["name"];
    if($row["synonym"] != ""){
      echo "&synonym=" . $row["synonym"];
         }
    echo "\">" . $row["name"] . "</a></td>";
    $n++;
    if($n == 6){
      $n = 0;
      echo "</tr><tr>";
        }
  }
  while($row = mysql_fetch_array($result1));
  
  for($m = $n; $m < 6; $m++){
    echo "<td class=\"value\"></td>";
  }
}
else{
  print "<td colspan=\"6\">No matches found.</td>";
}
?>
              </tr> 
            </table>
<!-- Map -->
          </td>
        </tr>
        <tr>
          <td>
            <table cellpadding="10">
              <tr>
                <td align="center">
            <img src="/images/mit_map.jpg" width="533" height="414" usemap=#mitoMap border="0" />
              <map name="mitoMap"> 
                <area shape="rect" coords="23,75,31,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Ile">
                <area shape="rect" coords="35,93,42,108" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Gln">
                <area shape="rect" coords="49,75,57,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Met">
                <area shape="rect" coords="58,74,181,88" href="anopheles-mitochondrial-genes?ref=seq&gene=ND2">
                <area shape="rect" coords="183,75,189,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Trp">
                <area shape="rect" coords="189,91,197,108" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Cys">
                <area shape="rect" coords="200,93,206,108" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Tyr">
                <area shape="rect" coords="204,74,268,88" href="anopheles-mitochondrial-genes?ref=seq&gene=COX1&synonym=COI">
                <area shape="rect" coords="269,75,277,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Leu">
                <area shape="rect" coords="278,76,356,88" href="anopheles-mitochondrial-genes?ref=seq&gene=COX2&synonym=COII">
                <area shape="rect" coords="357,75,365,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Lys">
                <area shape="rect" coords="365,75,373,88" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Asp">
                <area shape="rect" coords="374,75,497,88" href="anopheles-mitochondrial-genes?ref=seq&gene=ATP8">
                <area shape="rect" coords="23,161,37,173" href="anopheles-mitochondrial-genes?ref=seq&gene=ATP8">
                <area shape="rect" coords="40,161,118,173" href="anopheles-mitochondrial-genes?ref=seq&gene=ATP6">
                <area shape="rect" coords="119,161,212,173" href="anopheles-mitochondrial-genes?ref=seq&gene=COX3&synonym=COIII">
                <area shape="rect" coords="212,161,219,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Gly">
                <area shape="rect" coords="221,160,261,173" href="anopheles-mitochondrial-genes?ref=seq&gene=ND3">
                <area shape="rect" coords="262,162,269,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Arg">
                <area shape="rect" coords="270,162,278,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Ala">
                <area shape="rect" coords="279,162,286,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Asn">
                <area shape="rect" coords="287,163,294,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Ser">
                <area shape="rect" coords="295,162,303,173" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Glu">
                <area shape="rect" coords="304,178,314,193" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Phe">
                <area shape="rect" coords="313,179,497,193" href="anopheles-mitochondrial-genes?ref=seq&gene=ND5">
                <area shape="rect" coords="24,261,42,277" href="anopheles-mitochondrial-genes?ref=seq&gene=ND5">
                <area shape="rect" coords="43,260,53,277" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-His">
                <area shape="rect" coords="52,261,213,277" href="anopheles-mitochondrial-genes?ref=seq&gene=ND4">
                <area shape="rect" coords="214,261,249,277" href="anopheles-mitochondrial-genes?ref=seq&gene=ND4L">
                <area shape="rect" coords="248,244,255,257" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Thr">
                <area shape="rect" coords="257,260,264,277" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Pro">
                <area shape="rect" coords="265,244,325,257" href="anopheles-mitochondrial-genes?ref=seq&gene=ND6">
                <area shape="rect" coords="326,244,459,257" href="anopheles-mitochondrial-genes?ref=seq&gene=CYTB">
                <area shape="rect" coords="458,245,466,257" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Ser">
                <area shape="rect" coords="469,259,497,277" href="anopheles-mitochondrial-genes?ref=seq&gene=ND1">
                <area shape="rect" coords="24,340,106,358" href="anopheles-mitochondrial-genes?ref=seq&gene=ND1">
                <area shape="rect" coords="106,342,114,358" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Leu">
                <area shape="rect" coords="113,342,272,358" href="anopheles-mitochondrial-genes?ref=seq&gene=l-rRNA&synonym=16S rRNA">
                <area shape="rect" coords="269,342,280,358" href="anopheles-mitochondrial-genes?ref=seq&gene=tRNA-Val">
                <area shape="rect" coords="279,342,368,358" href="anopheles-mitochondrial-genes?ref=seq&gene=s-rRNA&synonym=12S rRNA">
                <area shape="rect" coords="370,335,495,345" href="anopheles-mitochondrial-genes?ref=seq&gene=AT-rich">
              </map>
                </td>
              </tr>
              <tr>
                <td width="600">
                  <table align="center" width="600" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td>
                  The clickable figure can also lead you directly to the respective gene 
                  (also found in the upper table) or to a list of complete genomes by 
                  clicking onto the yellow-black stripped AT-rich area. The map is a 
                  composite approximation for all anopheline mtDNAs and each line 
                  represents approximately 4000 base pairs. Turquoise: tRNA genes, dark 
                  blue: rDNA, red: other genes. The direction of transcription is 
                  indicated as from left to right (above the line) or from right to left 
                  (below the line).
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <b><i>Anopheles</i> species&nbsp;&raquo;</b>
          </td>
        </tr>
        <tr>
          <td height="2">
          </td>
        </tr>
        <tr>
          <td height="4">
          </td>
        </tr>
        <tr>
          <td bgcolor="#ffffff">
            <table class="trace_table_collapse" width="600">
              <tr>
<?php
$query2 = "SELECT name,  sequences_count FROM ano_species ORDER BY name ASC";
$result2 = mysql_query($query2, $mitoDB);
$n =0;
/* Pull out all Anopheles Species */

if ($row = mysql_fetch_array($result2))
{
//echo "There are $row['sequences_count'] different species...";
	do
	{
		if($row["sequences_count"] > 0)
		{
			print "<td class=\"value\"><a class=\"hashelp\" name=\"Web:mt_species_list_gene\" href=anopheles-mitochondrial-genes?ref=seq&species=" .str_replace( " ","_",$row["name"]) . ">";
			print $row["name"] . "</a></td>";
			$n++;
			if( $n == 3 )
			{
			        $n = 0;
			        echo "</tr><tr>";
			}
		}
	}
	while($row = mysql_fetch_array($result2));

	for($m = $n; $m < 3; $m++)
	{
		echo "<td>&nbsp;</td>";
  	}
}
else
{
	echo "<td colspan=\"3\">No matches found.</td>";
}
  ?>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<?php

















} 
else
{
	echo '<table width="600" cellpadding="0" cellspacing="10" border="0">';
	echo '<tr>';
	echo '<td>';
	echo '<table border="0" cellspacing="0" cellpadding="0">';
	echo '<tr>';
	echo '<td>';

	if( isset( $_GET['gene'] ) && ( $_GET['gene'] ) )
	{
		echo "<b>Anopheline sequences containing the " . $_GET['gene'] . " gene&nbsp;&raquo;</b>\n";

		$query = "SELECT * FROM ano_sequences, ano_blast_results WHERE (gene LIKE '%" . $_GET['gene'] . "%' OR gene='*'";

		if (isset($_GET['synonym']) && ($_GET['synonym'] != "") )
		{
			$query = $query." OR gene LIKE '" . $_GET['synonym'] . "'";
		}
	
		$query = $query.")  AND type LIKE '%rti%'  AND ano_sequences.acnum=ano_blast_results.acnum ORDER BY ano_sequences.species, ano_sequences.acnum ASC";
    print '<table class="trace_table_collapse" width="100%">';
    $sequencesCount = printPartialSequences($query,$mitoDB);

    print "</table>";

    print "<b>Complete genome sequences containing the " . $_GET['gene'] . " gene&nbsp;&raquo;</b>\n";

    $query = "SELECT DISTINCT(acnum), definition FROM ano_sequences WHERE type='complete' ORDER BY acnum ASC";

    print '<table class="trace_table_collapse" width="100%">';
    $sequencesCount = printCompleteSequences( $query, $mitoDB, $sequencesCount );

    print "<tr><td><input id=\"cbxSelectAll\" type=\"checkbox\" onclick=\"selectAll($sequencesCount)\"></td><td>Select all</td>";
    print "<td><input type=\"button\" value=\"Download selected\" onclick=\"downloadSequences($sequencesCount)\"></td></tr>";
    print "</table>";
	}

	if( isset($_GET["species"]) && ($_GET["species"]) )
	{
		echo "<b><i>" . str_replace( "_"," ",$_GET["species"] );
		echo "</i> - Mitochondrial DNA sequences&nbsp;&raquo;</b>\n";
   
		$query = " SELECT DISTINCT ano_sequences.acnum AS acnum, definition FROM ano_sequences, ano_blast_results WHERE species LIKE '%";
		$spec = str_replace("'","\'",$_GET["species"]);
		$query = $query . str_replace( "_"," ",$spec );
		$query = $query . "%' ORDER BY ano_sequences.acnum ASC";


	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td height="2">';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td height="4">';
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td bgcolor="#ffffff">';
	echo '<table class="trace_table_collapse" width="600">';

	$sequencesCount = printCompleteSequences($query, $mitoDB, 0 );

        print "<tr><td><input id=\"cbxSelectAll\" type=\"checkbox\" onclick=\"selectAll($sequencesCount)\"></td><td>Select all</td>";
        print "<td><input type=\"button\" value=\"Download selected\" onclick=\"downloadSequences($sequencesCount)\"></td></tr>";
        print "</table>";
}	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
}

mysql_close($mitoDB);

?>

</html>