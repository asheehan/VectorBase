<?php

require( "dbFunctions.php" );
$db = connectToDb();

$cvId = mysql_real_escape_string( $_GET[ 'cvId' ] );
$pathId = mysql_real_escape_string( $_GET[ 'pathId' ] );
$termXrefId = mysql_real_escape_string( $_GET[ 'termXrefId' ] );


// Find all terms in the path up to the requested term
$q = "SELECT xref_id FROM cv_path, cv_term WHERE cv_path.cv_id='$cvId' AND cv_path.id='$pathId' AND term_xref_id=cv_term.xref_id ORDER BY distance_from_root ASC";

$qr = mysql_query( $q );

if( mysql_num_rows( $qr ) == 0 )
{
	exit();
}

$response = "";

$row = mysql_fetch_array( $qr );

$lastAncestorId = -1;

while( $row != FALSE && $searchTermFound == FALSE )
{
	
	$sq = "SELECT DISTINCT(descendant_xref_id), name FROM cv_term_relationship, cv_term WHERE ancestor_xref_id='".$row['xref_id']."' AND descendant_xref_id=xref_id";

	$sqr = mysql_query( $sq );
	
	$srow = mysql_fetch_array( $sqr ); 
	
	while( $srow != FALSE )
	{
		$response = $response.$row['xref_id']."|".$srow['descendant_xref_id']."|".$srow['name']."|".getChildrenCount( $srow['descendant_xref_id'] )."<br>";

		if( $srow['descendant_xref_id'] == $termXrefId )
		{
			$lastAncestorId = $row['xref_id'];
			$searchTermFound = TRUE;
		}
		$srow = mysql_fetch_array( $sqr );
	}
	
	$row = mysql_fetch_array( $qr );
}

print $response;



function getChildrenCount( $xrefId )
{
	$q = "SELECT DISTINCT(descendant_xref_id) FROM cv_term_relationship WHERE ancestor_xref_id='$xrefId'";
	$qr = mysql_query( $q );
	
	return mysql_num_rows( $qr );
}


?>