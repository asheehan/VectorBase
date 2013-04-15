<?

require( "dbFunctions.php" );

$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET[ 'cvId' ] );
$text = mysql_real_escape_string( $_GET[ 't' ] );

$q = "SELECT * FROM (SELECT xref_id, id, name FROM cv_term WHERE cv_id='$cvId' AND (name LIKE '$text%' OR name LIKE '%$text%') UNION
SELECT xref_id, id, id AS name FROM cv_term WHERE cv_id='$cvId' AND (id LIKE '$text%' OR id LIKE '%$text%')) AS t ORDER BY t.name ASC";

$qr = mysql_query( $q );

$row = mysql_fetch_array( $qr );

$n = 0;

while( $row !== FALSE )
{
	if( $n > 0 )
	{
		print "<br>";
	}

	print $row['xref_id']."|".trim( $row['name'] )."|".getPathId( $cvId, $row['xref_id'] );

	$row = mysql_fetch_array( $qr );
	
	$n++;
}

$q = "SELECT xref_id, name, synonym FROM cv_term, cv_term_synonym 
	WHERE synonym LIKE '%$text%' AND cv_term.xref_id=cv_term_synonym.term_xref_id AND cv_term_synonym.cv_id='$cvId'
	ORDER BY name ASC";

$qr = mysql_query( $q );

$row = mysql_fetch_array( $qr );

while( $row !== FALSE )
{
	if( $n > 0 )
	{
		print "<br>";
	}

	print $row['xref_id']."|".trim( $row['name'] )." (".trim( $row['synonym'] ).")"."|".getPathId( $cvId, $row['xref_id'] );

	$row = mysql_fetch_array( $qr );
	
	$n++;
}



function getPathId( $cvId, $xrefId )
{
	$q = "SELECT id FROM cv_path WHERE cv_id=$cvId AND term_xref_id='$xrefId' LIMIT 1";
	
	$qr = mysql_query( $q );
	
	if( mysql_num_rows( $qr) > 0 )
	{
		$row = mysql_fetch_array( $qr );
		return $row['id'];
	}
	else
	{
		return "-1";
	}
}
?>