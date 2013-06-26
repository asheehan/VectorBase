<td class="cell_key">Resistance mechanism:</td>
<td class="cell_value">
	<div id="div_rm">
	<table>
	<tr>
	<td><div><select id="rm1" onchange="getchildren('rm',1,6)"><option value="---------">---------</option>
<?
	$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:00000021\" AND term_id=id ORDER BY name ASC";
	$result = mysql_query( $query, $dbConn );
	while( $myrow = mysql_fetch_array( $result ) )
		echo "			<option value=\"$myrow[id]\">$myrow[name]</option>";
?>
	</select></div></td>
	</tr>
	<tr><td><div id="div_rm2"><select id="rm2" onchange="getchildren('rm',2,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_rm3"><select id="rm3" onchange="getchildren('rm',3,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_rm4"><select id="rm4" onchange="getchildren('rm',4,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_rm5"><select id="rm5" onchange="getchildren('rm',5,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_rm6"><select id="rm6" disabled><option value="---------">---------</option></select></div></td>
	</table>
	<br>
	</div>
</td>