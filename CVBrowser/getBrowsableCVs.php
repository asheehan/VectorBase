<?

require( "dbFunctions.php" );
$db = connectToDb();

$q = "SELECT * FROM cv WHERE state > 0 ORDER BY name ASC";
$qr = mysql_query( $q );
$row = mysql_fetch_array( $qr );

$n = 0;

while( $row != FALSE )
{
	if( $n > 0 )
	{
		print "÷";
	}
	
	print $row['id']."¸".$row['name']."¸".$row['namespace']."¸".$row['browsing_mode']."¸".$row['terms']."¸".$row['relationships']."¸".$row['root_terms']."¸".$row['nodes'];
	$row = mysql_fetch_array( $qr );
	$n++;
}

?>