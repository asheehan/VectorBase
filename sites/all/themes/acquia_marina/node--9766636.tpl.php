<html>

<script language="javascript">
function selectAll( sequencesCount )
{
	if( document.getElementById("cbxSelectAll").checked )
		for( n = 1; n <= sequencesCount; n++ )
			document.getElementById("cbx_"+n).checked = true;
	else
		for( n = 1; n <= sequencesCount; n++ )
			document.getElementById("cbx_"+n).checked = false;
}

function downloadSequences( sequencesCount )
{
        ids = "";
	for( n = 1; n <= sequencesCount; n++ ) 
{

	
if( document.getElementById("cbx_"+n).checked )
                {
			if( ids != "" )
				ids = ids + ",";
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

/* Database Connection */
$mitoDB = mysql_connect ("localhost","mito","m1t0drUp@l");
if( !$mitoDB)
{
die('Not Connected: ' . mysql_error());
}
mysql_select_db("mitochondria", $mitoDB);


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



function show_genes_species( $db, $family_id )	{

echo "<table width=\"100%\" align=\"center\" class=\"std_table\">\n";
echo "<tr>";

$query = "SELECT DISTINCT name, synonym, sequences_count
						FROM ".$family_id."_mitochondrial_genes
						ORDER BY name ASC";

$result = mysql_query( $query, $db );
$n=0;
if( $myrow = mysql_fetch_array ( $result ) ) {
	do	{
		echo "<td class=\"cell_value\"><a href=\"?family=".$family_id."&gene=$myrow[name]";
		if( $myrow['synonym'] != "" )
			echo "&synonym=$myrow[synonym]\">";
		else
			echo "\">";
		echo "$myrow[name]</a>&nbsp;</td>";
		$n++;
		if( $n == 6 )		{
			$n = 0;
			echo "</tr>\n<tr>";
		}
	}
	while( $myrow = mysql_fetch_array( $result ) );

	for( $m = $n; $m < 6; $m++)
		echo "<td class=\"cell_value\">&nbsp;</td>";
}
else
	echo "<tr><td colspan=\"6\" class=\"cell_value\">No matches found.</td>";

echo "</tr></table>\n";
?>
          </td>
        </tr>
        <tr>
          <td>
<table cellpadding="10">
              <tr>
                <td align="center">
            <img src="/images/mit_map_ixodes.jpg" width="533" height="414" usemap=#mitoMapIxodes border="0" />
              <map name="mitoMapIxodes"> 
                <area shape="rect" coords="23,75,31,88" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Met">
                <area shape="rect" coords="33,75,155,88" href="ixodes-mitochondrial-genes?family=ixo&gene=ND2">
                <area shape="rect" coords="159,75,164,88" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Trp">
                <area shape="rect" coords="165,91,170,108" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Cys">
                <area shape="rect" coords="172,93,181,108" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Tyr">
                <area shape="rect" coords="183,75,257,88" href="ixodes-mitochondrial-genes?family=ixo&gene=COX1&synonym=COI">
                <area shape="rect" coords="259,76,337,88" href="ixodes-mitochondrial-genes?family=ixo&gene=COX2&synonym=COII">
                <area shape="rect" coords="339,75,345,88" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Lys">
                <area shape="rect" coords="348,75,355,88" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Asp">
                <area shape="rect" coords="357,75,497,88" href="ixodes-mitochondrial-genes?family=ixo&gene=ATP8">
                <area shape="rect" coords="23,161,37,173" href="ixodes-mitochondrial-genes?family=ixo&gene=ATP8">
                <area shape="rect" coords="40,161,118,173" href="ixodes-mitochondrial-genes?family=ixo&gene=ATP6">
                <area shape="rect" coords="119,161,212,173" href="ixodes-mitochondrial-genes?family=ixo&gene=COX3&synonym=COIII">
                <area shape="rect" coords="212,161,219,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Gly">
                <area shape="rect" coords="221,160,261,173" href="ixodes-mitochondrial-genes?family=ixo&gene=ND3">
                <area shape="rect" coords="262,162,269,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Ala">
                <area shape="rect" coords="270,162,278,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Arg">
                <area shape="rect" coords="279,162,286,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Asn">
                <area shape="rect" coords="287,163,294,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Ser">
                <area shape="rect" coords="295,162,303,173" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Glu">
                <area shape="rect" coords="304,178,314,193" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Phe">
                <area shape="rect" coords="313,179,497,193" href="ixodes-mitochondrial-genes?family=ixo&gene=ND5">
                <area shape="rect" coords="24,261,42,277" href="ixodes-mitochondrial-genes?family=ixo&gene=ND5">
                <area shape="rect" coords="43,260,53,277" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-His">
                <area shape="rect" coords="52,261,213,277" href="ixodes-mitochondrial-genes?family=ixo&gene=ND4">
                <area shape="rect" coords="214,261,249,277" href="ixodes-mitochondrial-genes?family=ixo&gene=ND4L">
                <area shape="rect" coords="248,244,255,257" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Thr">
                <area shape="rect" coords="257,260,264,277" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Pro">
                <area shape="rect" coords="265,244,325,257" href="ixodes-mitochondrial-genes?family=ixo&gene=ND6">
                <area shape="rect" coords="326,244,459,257" href="ixodes-mitochondrial-genes?family=ixo&gene=CYTB">
                <area shape="rect" coords="458,245,466,257" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Ser">
                <area shape="rect" coords="469,259,497,277" href="ixodes-mitochondrial-genes?family=ixo&gene=ND1">
                <area shape="rect" coords="24,340,174,358" href="ixodes-mitochondrial-genes?family=ixo&gene=ND1">
                <area shape="rect" coords="175,342,180,358" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Leu">
                <area shape="rect" coords="182,342,320,358" href="ixodes-mitochondrial-genes?family=ixo&gene=l-rRNA&synonym=16S rRNA">
                <area shape="rect" coords="322,342,327,358" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Leu">
                <area shape="rect" coords="329,342,335,358" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Val">
                <area shape="rect" coords="337,342,475,358" href="ixodes-mitochondrial-genes?family=ixo&gene=s-rRNA&synonym=12S rRNA">
                <area shape="rect" coords="476,320,481,332" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Ile">
                <area shape="rect" coords="486,342,493,358" href="ixodes-mitochondrial-genes?family=ixo&gene=tRNA-Gln">
              </map>
                </td>
              </tr>
</table>
              <tr>
                <td width="600">
     <!--             <table align="center" width="600" cellpadding="0" cellspacing="0" border="0">  -->
                    <tr>
                      <td>
                  The clickable figure can also lead you directly to the respective gene 
                  (also found in the upper table). The map is a 
                  composite approximation for all anopheline mtDNAs and each line 
                  represents approximately 4000 base pairs. Turquoise: tRNA genes, dark 
                  blue: rDNA, red: other genes. The direction of transcription is 
                  indicated as from left to right (above the line) or from right to left 
                  (below the line).
          </td>
        </tr>
<?php
echo "<br><table width=\"800\" align=\"center\" class=\"std_table\">\n";
echo "<tr><td class=\"services_title\" colspan=\"3\">Species</td></tr>\n";
echo "<tr>";

$n = 0;
$result = mysql_query( "SELECT name,sequences_count
						FROM ".$family_id."_species
						ORDER BY name ASC", $db );

if( $myrow = mysql_fetch_array( $result ) ) {
	do	{
		if( $myrow['sequences_count'] > 0 )		{
			echo "<td class=\"cell_value\"><a href=\"?family=".$family_id."&species=$myrow[name]\">";
			echo "<i>$myrow[name]</i></a></td>\n";
			$n++;
			if( $n == 3 )			{
				$n = 0;
				echo "</tr><tr>\n";
			}
		}
	}
	while( $myrow = mysql_fetch_array( $result ) );
	if( $n > 0)
		for( $m = $n; $m < 3; $m++ )
			echo "<td class=\"cell_value\">&nbsp;</td>";
}
else
	echo "<tr><td colspan=\"3\" class=\"cell_value\">No matches found.</td>\n";
echo "</tr></table>\n";
}


function show_main_page( $mitoDB )
{
?>
<table><tr><td>
<table width="800" align="center" class="std_table">
<tr><td ><font size="2">
This section provides the user with a compilation of mtDNA sequences for species of the subfamilies <i>Ixodidae</I> and <i>Argasidae</i>, as submitted to the NCBI nucleic acid sequence database by different authors. Although this list is updated regularly, some species may be absent at the time of your search.<br><br>
You may click on a specific mitochondrial locus or on a species name
to access a list of all available sequences.</td></tr><tr>
<td class="cell_value"><font size="2">Last update: April 2013 - 327 species / 6328 GenBank entries</td></tr>
</table>
<br>
<br>
<h3 align="center">Family <i>Ixodidae</i></h3>
<br>
<?
$n = 0;

show_genes_species( $mitoDB, "ixo" );
echo "<br><br><h3 align=\"center\">Family <i>Argasidae</i></h3><br>";
show_genes_species( $mitoDB, "arg" );
print "</td></tr></table>";
}


function show_sequences( $mitoDB ) 
{
	echo "<br><table width=\"800\" align=\"center\" class=\"std_table\">\n";
	echo "<tr><td colspan=\"4\" class=\"services_title\" align=\"center\">\n";

	if( isset( $_GET[ 'family' ], $_GET['gene'] ) ) 
        {
		echo "<b>Mitochondrial sequences containing the $_GET[gene] gene</b></td></tr>\n";

		$query = "SELECT *
				FROM ".$_GET['family']."_sequences, ".$_GET['family']."_blast_results
				WHERE (gene LIKE '%$_GET[gene]%'
				OR gene='*'";

		if( isset( $_GET['synonym'] ) )
                {
			if ( $_GET['synonym'] != "" )
				$query = $query." OR gene LIKE '".$_GET['synonym']."'";
                }

		$query = $query.") AND type LIKE '%rti%' AND ".$_GET['family']."_sequences.acnum=".$_GET['family']."_blast_results.acnum
					ORDER BY ".$_GET['family']."_sequences.species,  ".$_GET['family']."_sequences.acnum ASC";

    print '<table class="trace_table_collapse" width="100%">';
    $sequencesCount = printPartialSequences($query,$mitoDB);

    print "</table>";

    print "<b>Complete genome sequences</b>\n";

    $query = "SELECT DISTINCT(acnum), definition FROM ".$_GET['family']."_sequences WHERE type='complete' ORDER BY acnum ASC";

    print '<table class="trace_table_collapse" width="100%">';
    $sequencesCount = printCompleteSequences( $query, $mitoDB, $sequencesCount );

    print "<tr><td><input id=\"cbxSelectAll\" type=\"checkbox\" onclick=\"selectAll($sequencesCount)\"></td><td>Select all</td>";
    print "<td><input type=\"button\" value=\"Download selected\" onclick=\"downloadSequences($sequencesCount)\"></td></tr>";
    print "</table>";

	}
	elseif( isset( $_GET[ 'family' ], $_GET['species'] ) ) 
        {
		echo "<b>Mitochondrial sequences from <i>".$_GET['species']."</i></b></td></tr>\n";

		$query = "SELECT DISTINCT acnum, definition
	    			FROM ".$_GET['family']."_sequences
				WHERE species LIKE '%$_GET[species]%'
		                ORDER BY species, acnum ASC";
	
		$sequencesCount = printCompleteSequences($query, $mitoDB, 0 );

		print "<tr><td><input id=\"cbxSelectAll\" type=\"checkbox\" onclick=\"selectAll($sequencesCount)\"></td><td>Select all</td>";
		print "<td><input type=\"button\" value=\"Download selected\" onclick=\"downloadSequences($sequencesCount)\"></td></tr>";
		print "</table>";

?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?



 }

}


if( isset( $_GET[ 'family' ], $_GET[ 'gene' ] ) || isset( $_GET[ 'family' ], $_GET[ 'species' ] ) )
	show_sequences( $mitoDB );
else
	show_main_page( $mitoDB );
?>
<br>
<br>

</html>