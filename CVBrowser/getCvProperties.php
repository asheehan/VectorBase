<?

require( "dbFunctions.php" );
$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET[ 'id' ] );

$q = "SELECT * FROM cv WHERE id=$cvId AND state=1";
$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) < 1 )
{
	return;
}

$row = mysql_fetch_array( $qr );

print $row[ 'browsing_mode' ]."÷";

print $row[ 'terms' ]."÷";

$q = "SELECT xref_id FROM cv_term WHERE cv_id='$cvId' AND root=1 ORDER BY name ASC";
$qr = mysql_query( $q );

$rootTermsCount = mysql_num_rows( $qr );

$n = 0;
for( $n = 0; $n < $rootTermsCount; $n++)
{
	if( $n > 0 )
	{
		print "¸";
	}

	$row = mysql_fetch_array( $qr );
	
	print $row[ 'xref_id' ];
}

?>