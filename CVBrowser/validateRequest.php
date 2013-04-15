<?

require( "dbFunctions.php" );
$db = connectToDb();

$cv = mysql_real_escape_string( $_GET[ 'cv' ] );
$termId = mysql_real_escape_string( $_GET[ 't' ] );

$q = "SELECT id FROM cv WHERE namespace='$cv'";
$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) < 1 )
{
	print "0";
	return;
}
else 
{
	$row = mysql_fetch_array( $qr );
	$cvId = $row[ 'id' ];	
}

$q = "SELECT xref_id FROM cv_term WHERE cv_id='$cvId' AND id='$termId'";
$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) < 1 )
{
	print "0";
	return;
}

$row = mysql_fetch_array( $qr );
$xrefId = $row[ 'xref_id' ];

print "$cvId,$xrefId";
?>