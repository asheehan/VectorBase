<td class="cell_key">Assay method:</td>
<td class="cell_value">
	<div id="div_a">
	<table>
	<tr>
	<td><div><select id="a1"  onchange="getchildren('a',1,6)"><option value="---------">---------</option>
<?
	$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:20000001\" AND term_id=id ORDER BY name ASC";
	$result = mysql_query( $query, $dbConn );
	while ( $myrow = mysql_fetch_array ( $result ) )
		echo "			<option value=\"$myrow[id]\">$myrow[name]</option>";
?>
	</select></div></td>
	</tr>
	<tr><td><div id="div_a2"><select id="a2" onchange="getchildren('a',2,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_a3"><select id="a3" onchange="getchildren('a',3,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_a4"><select id="a4" onchange="getchildren('a',4,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_a5"><select id="a5" onchange="getchildren('a',5,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_a6"><select id="a6" disabled><option value="---------">---------</option></select></div></td>
	</table>
	<br>
	</div>
</td>