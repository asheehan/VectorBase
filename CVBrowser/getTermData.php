<?

require( "dbFunctions.php" );

$db = connectToDb();

$xrefId = mysql_real_escape_string( $_GET[ 'xid' ] );

$q = "SELECT * FROM cv_term WHERE xref_id='$xrefId'";
$qr = mysql_query( $q );
$row = mysql_fetch_array( $qr );

if( $row === FALSE )
{
	print "No data found for this ID.";
	return;
}


$definition = $row['definition'];

$xrefSourceStartPos = strrpos( $definition, "[" );

if( $xrefSourceStartPos !== FALSE )
{
	$xrefSourceLastPos = strrpos( $definition, "]" ) - 1;
	
	$xrefSource = substr( $definition, $xrefSourceStartPos + 1, $xrefSourceLastPos - $xrefSourceStartPos );
	
	$definition = substr( $definition, 1, $xrefSourceStartPos - 3 );
}


print "<table style='width: 100%;'>";
print "<tr><td colspan=\"2\" align='center' style='border-bottom: solid 3px black;'><b>Term information</b></td></tr>";
print "<tr><td style='border-bottom: solid 1px black;'><b>ID</b></td><td style='border-bottom: solid 1px black;'>".$row['id']."</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Name</b></td><td style='border-bottom: solid 1px black;'>".$row['name']."</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Definition</b></td><td style='border-bottom: solid 1px black;'>$definition</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Source</b></td><td style='border-bottom: solid 1px black;'>$xrefSource</td></tr>";

$q = "SELECT synonym FROM cv_term_synonym WHERE term_xref_id='$xrefId'";
$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) > 0 )
{
	print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Synonym</b></td><td style='border-bottom: solid 1px black;'>";
	
	$n = 0;
	$row = mysql_fetch_array( $qr );
	
	while( $row != FALSE )
	{
		if( $n > 0 )
		{
			print ",";
		}
		print "$row[synonym]";
		$row = mysql_fetch_array( $qr );
		$n++;
	}
	
	print "</td></tr>";
}

print "</table>";

$namespace = substr( $row['id'], 0, strpos( $row['id'], ":") );

print "<br><table align=\"center\" style='width: 100%;'>";

$comment = $row['comment'];
$n = 0;
$offset = 0;
$figure = array();

$figureNameStartPos = strpos( $comment, "Fig. ", $offset );

while( strpos( $comment, "Fig. ", $offset ) !== FALSE ) 
{
	$figureNameStartPos = strpos( $comment, "Fig. ", $offset );
	$figureNameEndPos = strpos( $comment, ",", $figureNameStartPos + 4 );

	$figureName = substr( $comment, $figureNameStartPos, $figureNameEndPos - $figureNameStartPos );
	
	$offset = $figureNameEndPos + 1;

	$figure[] = $figureName;
	
	$n++;
}


$figure = array_unique( $figure );
$figureCount = count( $figure );

if( $figureCount > 0 ) 
{
	print "<tr><td colspan=\"3\" style='border-bottom: solid 3px black; width: 100%; text-align: center'><b>Images</b></td></tr>";
}

for( $t = 0; $t < $figureCount; )
{
	print "<tr>";
	
	$fileName = str_replace( "Fig. ", "Fig", $figure[ $t ] ).".jpg";
	
	print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";

	if( $figureCount > $t + 1 )
	{
		$fileName = str_replace( "Fig. ", "Fig", $figure[ $t + 1 ] ).".jpg";
	
		print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";
	}
	else 
	{
		print "<td align=\"center\">&nbsp;</td>";
	}
	
	if( $figureCount > $t + 2 )
	{
		$fileName = str_replace( "Fig. ", "Fig", $figure[ $t + 2 ] ).".jpg";
	
		print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";
	}
	else 
	{
		print "<td align=\"center\">&nbsp;</td>";
	}
	
	print "</tr>"; 
	$t = $t + 3;
}

print "</table>";

?>
