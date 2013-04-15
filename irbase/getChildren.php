<?php
require_once ("IRBaseConnect.php");
$db = connectIRBase();

$term_id = trim( mysql_real_escape_string( $_GET['id'] ) );

$result = mysql_query( "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"$term_id\" AND term_id=id ORDER BY name ASC" );

if( $myrow = mysql_fetch_array( $result ) ) 	{
	echo "---------,---------\n";
	do {
		echo "$myrow[id],$myrow[name]\n";
	}
	while( $myrow = mysql_fetch_array( $result ) );
}
else
	echo "---------,---------\n";
?>
