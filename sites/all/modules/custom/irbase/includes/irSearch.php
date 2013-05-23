<?php include( "anobase.css" ); ?>

<?php 

function connectIRBase2( ) {
	$connection = mysql_connect( "localhost", "iradmin", "ir@dm1n" );
	if( !$connection )
		die( 'Could not connect to database server.' );
	$db_selected = mysql_select_db( "ir7", $connection );
	if( !$db_selected )
		die( 'Could not select database.' );
	return $connection;
}

function gettermname2( $db, $term_id )	{
	if( $term_id != "" )	{
		$result = mysql_query( "SELECT name FROM iro_term WHERE id='$term_id'", $db );
	
		if( $myrow = mysql_fetch_array( $result ) ) 
				return $myrow['name'];
		else
			return "";
	}
}


// Returns an array of assay_ids that match the $query
//
// Used in: search.php
//
function getIds2( $query, $db )	{

//echo $query;
	$n = 0;
	$myrs = mysql_query( $query, $db );
	$ids = array();	
	while( $myrow = mysql_fetch_array( $myrs ) ) {
		if(!empty($myrow)) {
			$ids[$n++]=$myrow['assay_id'];
		}
	}
	return $ids;
}

$assay_ids = array(); // Need the array to exist to further down the sizeof check doesn't error out.
$db = connectIRBase2();

if( isset( $_GET['s'] ) ) {
	$assay_ids = getIds2( "SELECT assay_id FROM population,assay WHERE species_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[s]') AND assay.population_id=population.population_id", $db );
}


if( isset( $_GET['l'] ) ) {
	$array_tmp = getIds2( "SELECT assay_id FROM collection_site,population,assay WHERE gaz_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[l]') AND population.collection_site_id=collection_site.collection_site_id AND assay.population_id=population.population_id", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}



if( isset( $_GET['i'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM assay WHERE insecticide_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[i]')", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}


if( isset( $_GET['insecticide_id'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM assay WHERE insecticide_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[insecticide_id]')", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}



if( isset( $_GET['rm'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM assay WHERE resistance_mechanism_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[rm]') OR resistance_mechanism_id='$_GET[rm]'", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}



if( isset( $_GET['a'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM assay WHERE assay_method_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[a]')", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}

if( isset( $_GET['mu'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM assay WHERE mosquitoes_used_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[mu]')", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}



if( isset( $_GET['cm'] ) )	{
	$array_tmp = getIds2( "SELECT assay_id FROM population,assay WHERE catch_method_id IN (SELECT descendant FROM iro_progeny WHERE ancestor='$_GET[cm]') AND assay.population_id=population.population_id", $db );
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 ) {
		$assay_ids = $array_tmp;
       }
}

if( isset( $_GET['y'] ) )	{
	if( isset( $_GET[y_to] ) ) {
		$array_tmp = getIds2( "SELECT assay_id FROM population,assay,study WHERE LEFT(collection_start_date,4)>=$_GET[y] AND LEFT(collection_start_date,4)<=$_GET[y_to] AND population.study_id=study.study_id AND assay.population_id=population.population_id", $db ); 
        }
	else   {
		$array_tmp = getIds2( "SELECT assay_id FROM population,assay,study WHERE LEFT(collection_start_date,4)=$_GET[y] AND population.study_id=study.study_id AND assay.population_id=population.population_id", $db );
        }
	if( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) > 0 )	{
		$array_cache = $assay_ids;
		$assay_ids = array_intersect( $array_cache, $array_tmp );
	}
	elseif( sizeof( $array_tmp ) > 0 && sizeof( $assay_ids ) == 0 )  {
		$assay_ids = $array_tmp;
       }
}

$assays_count = sizeof( $assay_ids );
//$sid='';
if (isset($_GET['sid'])) {
$mine= $_GET['sid'];
//echo "The sid is $mine\n";
$sid = mysql_real_escape_string( $mine );
}


if( $assays_count > 0 )		{
	mysql_query( "DROP TABLE IF EXISTS $sid" );
	mysql_query( "CREATE TABLE $sid (assay_id INT)", $db );

	reset( $assay_ids );
	for( $t = 0; $t < $assays_count; $t++ )	{
		$assay_id = current( $assay_ids );
		mysql_query( "INSERT INTO $sid VALUES($assay_id)" );
		next( $assay_ids );
	}
}




?>

<body>

<div id="select-result" style="display:none"></div>

<br>
<br>
<div align="center">
<table align="center">
<tr><td colspan="8" class="services_title">Insecticide Resistance Assays</td></tr>
<table>
<tr><td>
<table width="800" id="selectable">
<?php
if( $assays_count > 0 )	{
	
	reset( $assay_ids );
	echo "<tr id=\"-1\" class=\"ui-widget-content\">\n";
	echo "<td class=\"col_key\">Location</td><td class=\"col_key\">Year</td><td class=\"col_key\" width=\"20%\">Species</td>\n";
	echo "<td class=\"col_key\">Assay type</td><td class=\"col_key\">Insecticide</td>\n";
	echo "<td class=\"col_key\" width=\"20%\">Resistance mechanism</td>";
	echo "<td class=\"col_key\" align=\"center\">Details</td>";
	echo "</tr>\n";

	$n = 1;
	for( $t = 0; $t < $assays_count; $t++ )	{
		$assay_id = current( $assay_ids );
		if( $assay_id != "" )	{
			$query = "SELECT DISTINCT assay_id, assay_method_id, gaz_id, insecticide_id, resistance_mechanism_id, species_id, LEFT(collection_start_date,4) AS year
			FROM assay, population, collection_site, study
			WHERE assay.population_id=population.population_id
			AND population.study_id=study.study_id
			AND population.collection_site_id=collection_site.collection_site_id
			AND assay_id=$assay_id
			ORDER BY year DESC";

			$myrs = mysql_query( $query, $db );
			if( $myrow = mysql_fetch_array( $myrs ) )	{
/*
				echo "<tr id=\"$n\" class=\"ui-widget-content\"><td class=\"cell_key\"><input type=\"checkbox\" id=\"cbx_".$n++."\" value=\"$assay_id\"></td>";
				echo "<td class=\"cell_value\">".gettermname2( $db, $myrow['gaz_id'] )."</td>";
				echo "<td class=\"cell_value\">$myrow[year]</td>";
				echo "<td class=\"cell_value\">".gettermname2( $db, $myrow['species_id'] )."</td>";
				echo "<td class=\"cell_value\">".gettermname2( $db, $myrow['assay_method_id'] )."</td>";
				echo "<td class=\"cell_value\">";
*/
				echo "<tr id=\"$assay_id\" class=\"ui-widget-content\">";
				//<td><input type=\"checkbox\" id=\"cbx_".$n++."\" value=\"$assay_id\"></td>";
				echo "<td>".gettermname2( $db, $myrow['gaz_id'] )."</td>";
				echo "<td>$myrow[year]</td>";
				echo "<td>".gettermname2( $db, $myrow['species_id'] )."</td>";
				echo "<td>".gettermname2( $db, $myrow['assay_method_id'] )."</td>";
				echo "<td>";


				if( $myrow['insecticide_id']  == "Control" )
					echo "Control";
				else {
					if( strpos( $myrow['insecticide_id'], "MIRO" ) === false )
						echo $myrow['insecticide_id'];
					else
						echo gettermname2( $db, $myrow['insecticide_id'] );
				}
				echo "</td>";
				echo "<td>".gettermname2( $db, $myrow['resistance_mechanism_id'] )."</td>";
                                echo "<td align=\"center\"><a href=\"/content/ir-assay?id=$myrow[assay_id]\">";
				echo "<img border=\"0\" src=\"/images/report.png\" height=\"15\"></a></td>\n";
				echo "</tr>\n";
			}
		}
		next( $assay_ids );
	}
	
	echo "</table></td>";
	
/*	echo "<td><table><tr><td class=\"col_key\" align=\"center\"></td></tr>\n";

	$n = 1;
	reset( $assay_ids );
	for( $t = 0; $t < $assays_count; $t++ )	{

		$assay_id = current( $assay_ids );
		if( $assay_id != "" )	{
			         $kati = $myrow['assay_id'];
                                 echo "<tr><td align=\"center\"></td></tr>\n";
				//echo "<tr><td align=\"center\"><a href=\"/content/ir-assay?id=$kati\">";
				//echo "<img border=\"0\" src=\"/images/report.png\" height=\"15\"></a></td></tr>\n";
			}
		
		
		next( $assay_ids );
	}
	
	echo "</table></td>*/
        echo "</tr></table>\n";
	echo "<table  width=\"800\" align=\"center\">";
	echo "<tr><td class=\"plain\" colspan=\"3\">$assays_count records.</td>";
	print "<td colspan=\"3\" class=\"plain\" align=\"right\"><input type=\"button\" value=\"Map results\" onclick=\"mapResults()\"></td></tr>\n";
//	echo "<tr><td class=\"plain\" colspan=\"3\">";
//	echo "<input type=\"checkbox\" id=\"cbx_all\" onclick=\"markAll(".($n-1).")\">&nbsp;&nbsp;Select all";
 //	echo "</td>\n";
// 	echo "<td class=\"cell_key\" colspan=\"5\" align=\"right\">";
//	echo "Export selected assays as a tab separated values (.tsv) file&nbsp;&nbsp;&nbsp;&nbsp;";
//	echo "<input type=\"button\" value=\"Export\" onclick=\"exportResults(".$assays_count.")\">";
//	echo "</td></tr></table>\n";
        echo "</table>\n";
}
else
	echo "<tr><td colspan=\"5\" class=\"plain\">No matches found.</td></tr>";

?>
</table>
</div>

