<?

require( "dbFunctions.php" );

$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET[ 'id' ] );

$q = "SELECT xref_id,cv_term.name AS name FROM cv, cv_term WHERE cv.id='$cvId' AND cv.id=cv_term.cv_id ORDER BY serial_id ASC";
$qr = mysql_query( $q );

$row = mysql_fetch_array( $qr );

while( $row !== FALSE ) {
	
	print $row['xref_id']."|".trim( $row['name'] )."<br>";
	
	$row = mysql_fetch_array( $qr );
}

?>