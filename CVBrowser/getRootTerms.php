<?php

require( "dbFunctions.php" );
$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET['cvId' ] );

$q = "SELECT root_terms FROM cv WHERE id='$cvId'";
$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) == 0 )
{
	exit();
}

$row = mysql_fetch_array( $qr );

$rootTerms = explode( ",", $row['root_terms'] );
$rootTermsLength = count( $rootTerms );

$response = "";

for( $t = 0; $t < $rootTermsLength; $t++ )
{
	$q = "SELECT name FROM cv_term WHERE xref_id='".$rootTerms[$t]."'";
	$qr = mysql_query( $q );
	
	if( mysql_num_rows( $qr ) == 0 )
	{
		exit();
	}
	
	$row = mysql_fetch_array( $qr );
	$response = $response.$rootTerms[$t]."|".$row['name']."|";
	
	$q = "SELECT id FROM cv_term_relationship WHERE ancestor_xref_id='".$rootTerms[$t]."'";
	$qr = mysql_query( $q );
	
	$response = $response.mysql_num_rows( $qr )."<br>";
}

print $response;

?>
