<?php
function connectIRBase( ) {
	$connection = mysql_connect( "localhost", "iradmin", "ir@dm1n" );
	if( !$connection )
		die( 'Could not connect to database server.' );
	$db_selected = mysql_select_db( "ir7", $connection );
	if( !$db_selected )
		die( 'Could not select database.' );
	return $connection;
}

function gettermname( $db, $term_id )	{
	if( $term_id != "" )	{
		$result = mysql_query( "SELECT name FROM iro_term WHERE id='$term_id'", $db );
	
		if( $myrow = mysql_fetch_array( $result ) ) 
				return $myrow['name'];
		else
			return "";
	}
}


function notifyDbError( $query, $error ) {
	echo "An error occured while accessing the database. The webmaster has been notified.";
	mail( "ed@imbb.forth.gr", "IRbase - db error", $error."\n\n".$query );
}


// Returns an array of assay_ids that match the $query
//
// Used in: search.php
//
function getIds( $query, $db )	{

//echo $query;
	$n = 0;
	$myrs = mysql_query( $query, $db );
	while( $myrow = mysql_fetch_array( $myrs ) )
			$ids[$n++]=$myrow['assay_id'];
	return $ids;
}
?>
