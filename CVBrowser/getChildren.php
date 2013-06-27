<?php

require( "dbFunctions.php" );
$db = connectToDb();

$xrefId = mysql_real_escape_string( $_GET['xrefId' ] );

$q = "SELECT name, descendant_xref_id FROM cv_term, cv_term_relationship WHERE ancestor_xref_id='$xrefId' AND xref_id=descendant_xref_id ORDER BY NAME ASC";
$qr = mysql_query( $q );

$rowsCount = mysql_num_rows( $qr );

if( $rowsCount == 0 )
{
	exit();
}

$response = "";

$row = mysql_fetch_array( $qr );

while( $row != FALSE )
{
	$response = $response.$row['descendant_xref_id']."|".$row['name']."|";
	
	$tq = "SELECT DISTINCT(descendant_xref_id) FROM cv_term_relationship WHERE ancestor_xref_id='".$row['descendant_xref_id']."'";
	$tqr = mysql_query( $tq );
	
	$rowsCount = mysql_num_rows( $tqr ); 
	
	if( $rowsCount > 0 )
	{
		$response = $response.$rowsCount;
	}
	else
	{
		$response = $response."0";
	}

	$response = $response."<br>";

	$row = mysql_fetch_array( $qr );
}


print $response;

?>
