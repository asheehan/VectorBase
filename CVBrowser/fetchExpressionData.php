<?
require( "dbFunctions.php" );

$db = connectToDb();

$xrefId = mysql_real_escape_string( $_GET[ 'xid' ] );

$q = "SELECT * FROM cv_term WHERE xref_id='$xrefId'";
$qr = mysql_query( $q );
$row = mysql_fetch_array( $qr );

if( $row === FALSE )
{
//	print "No data found for this ID.";
	return;
}


//$url = "http://127.0.0.1/~emmanuel/funcgen.xml";

$url = "funcgen.vectorbase.org/ExpressionData/das/sampleSearch/features?segment=".$row[ 'id' ];
$url = "http://".str_replace( ":", "%3B", $url );
//$url = "http://funcgen.vectorbase.org/ExpressionData/das/sampleSearch/features?segment=TGMA%3B0001036";

$conn = fopen( $url, "r" );
$response = "";

if( $url )
{
	while( $line = @fgets( $conn, 1024 ) )
	{
		$response .= $line;
	}
}

fclose( $conn );



try
{
	$xml = new SimpleXMLElement( $response );
}
catch( Exception $e ) 
{
	print $e;
	die();
}

$attributes = $xml->attributes();   // get all attributes
$children   = $xml->children();     // get all children

$attributes = $children->attributes();   // get all attributes
$children   = $children->children();     // get all children

$attributes = $children->attributes();   // get all attributes
$children   = $children->children();     // get all children

$n = 0;

if( count( $children ) )
{
	print "<table style='width: 100%'><tr><td colspan=\"2\" align='center' style='border-bottom: solid 3px black;'><b>Expression Data</b></td></tr>";
	print "<tr><td colspan=\"2\">&nbsp</td></tr>";
	
	foreach($children as $child)
	{
		parseExperiment( $child, $n );
		$n++;
	}
	
	print "</table>";
}






function parseExperiment(SimpleXMLElement $element, $n )
{
	if( $n > 0 )
	{
		print "<tr><td colspan=\"2\">&nbsp</td></tr>";
		print "<tr><td colspan=\"2\">&nbsp</td></tr>";
	}
	
	$attributes = $element->attributes();   // get all attributes
	$children   = $element->children();     // get all children

	$title = $attributes[ 0 ];
	$children = $element->children();     // get all children
	$attributes = $children[8]->attributes();
	
	print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Title</b></td><td valign='top' style='border-bottom: solid 1px black;'><a href=\"$attributes[0]\">$title</a></td></tr>";
	print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Type</b></td><td valign='top' style='border-bottom: solid 1px black;'>".$children[0]."</td></tr>";
	print "<tr><td valign='top' style='border-bottom: solid 1px black;'><b>Summary</b></td><td valign='top' style='border-bottom: solid 1px black;'>".$children[7]."</td></tr>";
}

?>
