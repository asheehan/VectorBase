<td class="cell_key">Catch method:</td>
<td class="cell_value">
	<div id="div_cm">
	<table>
	<tr>
	<td><div><select id="cm1" onchange="getchildren('cm',1,5)"><option value="---------">---------</option>
<?
	$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:30000044\" AND term_id=id ORDER BY name ASC";
	$result = mysql_query( $query, $dbConn );
	while ( $myrow = mysql_fetch_array ( $result ) )
		echo "			<option value=\"$myrow[id]\">$myrow[name]</option>";
?>
	</select></div></td>
	</tr>
	<tr><td><div id="div_cm2"><select id="cm2" onchange="getchildren('cm',2,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_cm3"><select id="cm3" onchange="getchildren('cm',3,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_cm4"><select id="cm4" onchange="getchildren('cm',4,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_cm6"><select id="cm5" disabled><option value="---------">---------</option></select></div></td>
	</table>
	<br>
	</div>
</td>