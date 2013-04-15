<?

function connectToDb() {
	
	$db = mysql_connect( "localhost","mito","m1t0drUp@l" );
	
	if( $db === FALSE )
		exit( "Cound not connect to db server.");
	
	if( mysql_select_db( "mitochondria", $db ) === FALSE )
		exit( "Cound not select db.");

	return $db;
}


function printDbError( $q )    {

	global $db;

	print "\nDatabase error! ".mysql_affected_rows( )."\n";
	print mysql_error( $db )."\n";
	print $q."\n";
	exit( 0 );
}


function getDbTermIdByTermId( $termId ) {
	
	$q = "SELECT id FROM cv_term WHERE term_id='$termId'";
	$qr = mysql_query( $q );
	
	$matchingRows = mysql_num_rows( $qr );
	
	if( $matchingRows < 1 || $matchingRows > 1 ) {
		
		dbAlert( $q );
	}
	
	$row = mysql_fetch_array( $qr );
	
	return $row[ 'id' ];
}


function getTermIdByDbTermId( $dbTermId ) {

	$q = "SELECT term_id FROM cv_term WHERE id='$dbTermId'";
	$qr = mysql_query( $q );

	$matchingRows = mysql_num_rows( $qr );

	if( $matchingRows < 1 || $matchingRows > 1 ) {

		dbAlert( $q );
	}

	$row = mysql_fetch_array( $qr );

	return $row[ 'term_id' ];
}

?>
