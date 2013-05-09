<?php
require_once( "IRBaseConnect.php" );
$db = connectIRBase();

$aclid = mysql_real_escape_string( $_GET['oid'] );
$query = "SELECT * FROM auto_complete_list WHERE aclid='$aclid'";
if( $result = mysql_query( $query ) )	{
	$row = mysql_fetch_array( $result );
	$fieldId = $row[ 'field_id' ];
	$fieldName = $row[ 'field_name' ];
	$table = $row[ 'table' ];
	$idRestriction = $row[ 'id_restriction' ];
}
else
	exit (0);  


$q = mysql_real_escape_string( $_GET['q'] );

$query = "SELECT DISTINCT $fieldId,$fieldName FROM $table 
			WHERE $fieldName LIKE '%$q%'";

if( $idRestriction != "" )
	$query = $query." AND id LIKE '$idRestriction%'";

$query = $query." ORDER BY $fieldName ASC LIMIT 20";

$t=0;
if( $result = mysql_query( $query ) )	{
	while( $myrow = mysql_fetch_array( $result ) )	{
		$resultsList[$t][0] = $myrow[0];
		$resultsList[$t++][1] = $myrow[1];
	}
}
else
	exit (0);  


if( count( $resultsList ) > 0 )	{
	echo '<div style="background: #ffffff; border-style: solid; border-width: 1px; border-color: #000000;">';
	echo '<img align="right" style="position: relative; z-index: +1" src="/images/red.png" onclick="divAutoComplete.style.visibility = \'hidden\'">';
	
	for( $i = 0; $i < count( $resultsList ); $i++ )	{
		echo "<a href=\"javascript:setValue('".$_GET['oid']."','".$resultsList[$i][0]."','".$resultsList[$i][1]."');\" ";
		echo ' onmouseover="this.style.background=\'#eeeeee\'" onmouseout="this.style.background=\'#ffffff\'"';
		echo ">".$resultsList[$i][1]."</a><br>";
	}
    echo "</div>";
}
?>
