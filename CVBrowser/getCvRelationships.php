<?

require( "dbFunctions.php" );

$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET[ 'id' ] );

$q = "SELECT descendant_serial_id, serial_id AS ancestor_serial_id FROM (SELECT serial_id AS descendant_serial_id, ancestor_xref_id
FROM cv_term, cv_term_relationship 
WHERE cv_term.cv_id='$cvId' 
AND cv_term.cv_id=cv_term_relationship.cv_id 
AND descendant_xref_id=cv_term.xref_id 
ORDER BY cv_term.name ASC) AS t
INNER JOIN cv_term
ON ancestor_xref_id=xref_id";

$qr = mysql_query( $q );

$row = mysql_fetch_array( $qr );

while( $row !== FALSE ) {
	
	print $row['ancestor_serial_id'].",".$row['descendant_serial_id']."-";
	
	$row = mysql_fetch_array( $qr );
}

?>