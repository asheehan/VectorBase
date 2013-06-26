<?php

$server = "https://dev.vectorbase.org/";

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

$cvId = $row['cv_id'];

$termId = $row['id'];

$definition = $row['definition'];

$xrefSourceStartPos = strrpos( $definition, "[" );

if( $xrefSourceStartPos !== FALSE )
{
	$xrefSourceLastPos = strrpos( $definition, "]" ) - 1;
	
	$xrefSource = substr( $definition, $xrefSourceStartPos + 1, $xrefSourceLastPos - $xrefSourceStartPos );
	
	$definition = substr( $definition, 1, $xrefSourceStartPos - 3 );
}

$comment = str_replace( "\\n", "\n", $row['comment'] );

print "<table style='width: 100%;'>";
print "<tr><td colspan=\"2\" align='center' style='border-bottom: solid 3px black;'><b>Term information</b></td></tr>";
print "<tr><td style='border-bottom: solid 1px black;'><b>ID</b></td><td style='border-bottom: solid 1px black;'>".$termId."</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Name</b></td><td style='border-bottom: solid 1px black;'>".$row['name']."</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Definition</b></td><td style='border-bottom: solid 1px black;'>$definition</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Source</b></td><td style='border-bottom: solid 1px black;'>$xrefSource</td></tr>";
print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Comment</b></td><td style='border-bottom: solid 1px black;'>".$comment."</td></tr>";

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

$namespace = substr( $termId, 0, strpos( $termId, ":") );

print "<br><table align=\"center\" style='width: 100%;'>";

$n = 0;
$offset = 0;
$figure = array();

if( $cvId == 2 )
{
	$figureQualifier = "Fig.";
}
else
{
	$figureQualifier = "Fig.";
}

$commentLines = explode( "\n", $comment );

for( $n = 0; $n < count( $commentLines ); $n++ )
{
	$offset = 0;
	$figureDelimeter = $figureQualifier;
	$figuresInThisLine = 0;

	while( strpos( $commentLines[ $n ], $figureDelimeter, $offset ) !== FALSE ) 
	{	
		if( $cvId == 2 )
		{
//			if( count( $figure ) == 0 )
			if( $figuresInThisLine == 0 )
			{
				$figureDelimeter = $figureQualifier;
			}
			else
			{
				$figureDelimeter = ",";	
			}
		}
		else
		{
			$figureDelimeter = $figureQualifier;
		}

		$figureNameStartPos = strpos( $commentLines[ $n ], $figureDelimeter, $offset );

		if( $cvId == 2 && $figuresInLine >= 0 )
		{
			$figureDelimeter = ",";	
		}
		
		if( $cvId == 3 )
		{
			$figureDelimeter = ",";
		}
		
		$figureNameEndPos = strpos( $commentLines[ $n ], $figureDelimeter, $figureNameStartPos + 1 );
		
		if( $cvId == 2 && $figureNameEndPos == FALSE && $figuresInThisLine == 0 )
		{
			$figureNameEndPos = strpos( $commentLines[ $n ], " ", $figureNameStartPos + 5 );
		}
		
		if( $cvId == 2 && $figureNameEndPos == FALSE && $figuresInThisLine >= 0 )
		{
			$figureNameEndPos = strpos( $commentLines[ $n ], " ", $figureNameStartPos + 1 );
		}
		
		$figureName = substr( $commentLines[ $n ], $figureNameStartPos, $figureNameEndPos - $figureNameStartPos );

		$figureName = str_replace( ",", "", $figureName );	
		$figureName = str_replace( " ", " ", $figureName );
		$figureName = trim( $figureName );
		
		if( $cvId == 2 && count( $figure ) == 0 )
		{
			$figureName = str_replace( "Fig. 0", "Fig. ", $figureName );	
			$figureName = str_replace( "Fig ", "Fig. ", $figureName );	
		}
		
		if( $cvId == 2 && count( $figure ) >= 0 )
		{
			if( substr( $figureName, 0 , 1 ) == "0" )
			{
				$figureName = "Fig. ".trim( substr( $figureName, 1 ) );
			}
			
			if( substr( $figureName, 0 , 1 ) != "F" )
			{
				$figureName = "Fig. ".trim( $figureName );
			}
		}
		
		if( $cvId == 2 )
		{
			if( $n == 0 )
			{
				$figureName = "$namespace/Anopheles|$figureName";
			}

			if( $n > 0 )
			{
				$figureName = "$namespace/Aedes|$figureName";
			}
		}
		else
		{
			$figureName = "$namespace|$figureName";
		}
			
		$figure[] = trim( $figureName );
		
		if( $cvId == 3 )
		{
			$offset = $figureNameEndPos + 1;
		}
		else
		{
			$offset = $figureNameEndPos ;
		}

		$figuresInThisLine++;
	}
}

$figure = array_unique( $figure );
$figureCount = count( $figure );
//print_r( $figure );
if( $figureCount > 0 ) 
{
	print "<tr><td colspan=\"3\" style='border-bottom: solid 3px black; width: 100%; text-align: center'><b>Images</b></td></tr>";

	for( $t = 0; $t < $figureCount; )
	{
		print "<tr>";
		
		$tok = explode( "|", str_replace( "Fig. ", "Fig", $figure[ $t ] ).".jpg" );
		$namespace = $tok[0];
		$fileName = $tok[1];
		
		print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";
	
		if( $figureCount > $t + 1 )
		{
		$tok = explode( "|", str_replace( "Fig. ", "Fig", $figure[ $t + 1] ).".jpg" );
		$namespace = $tok[0];
		$fileName = $tok[1];
					
			print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";
		}
		else 
		{
			print "<td align=\"center\">&nbsp;</td>";
		}
		
		if( $figureCount > $t + 2 )
		{
		$tok = explode( "|", str_replace( "Fig. ", "Fig", $figure[ $t + 2] ).".jpg" );
		$namespace = $tok[0];
		$fileName = $tok[1];
					
			print "<td align=\"center\"><a href=\"https://www.vectorbase.org/CVBrowser/images/$namespace/$fileName\" target=\"_blank\"><img src=\"https://www.vectorbase.org/CVBrowser/images/$namespace/tn/$fileName\" width=\"100\"></a></td>";
		}
		else 
		{
			print "<td align=\"center\">&nbsp;</td>";
		}
		
		print "</tr>"; 
		$t = $t + 3;
	}
}

print "</table>";

?>

