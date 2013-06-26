<?php

function connectIRBase3( ) {
	$connection = mysql_connect( "localhost", "iradmin", "ir@dm1n" );
	if( !$connection )
		die( 'Could not connect to database server.' );
	$db_selected = mysql_select_db( "ir7", $connection );
	if( !$db_selected )
		die( 'Could not select database.' );
	return $connection;
}

$db = connectIRBase3();

$term_id = trim( mysql_real_escape_string( $_GET['id'] ) );

$result = mysql_query( "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"$term_id\" AND term_id=id ORDER BY name ASC" );
$out = '';
if( $myrow = mysql_fetch_array( $result ) ) 	{
	$out .= "---------,---------\n";
	do {
		$out .= "{$myrow['id']},{$myrow['name']}\n";
	}
	while( $myrow = mysql_fetch_array( $result ) );
} else {
	$out .= "---------,---------\n";
}

print $out;

?>

