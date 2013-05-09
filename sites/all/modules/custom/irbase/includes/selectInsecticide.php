<td class="cell_key">Insecticide:</td>
<td class="cell_value">
	<div id="div_i">
	<table>
	<tr>
	<td><div><select id="i1" onchange="getchildren('i',1,6)"><option value="---------">---------</option>
<?
	$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:10000239\" AND term_id=id ORDER BY name ASC";
	$result = mysql_query( $query, $dbConn );
	while( $myrow = mysql_fetch_array( $result ) )
		echo "			<option value=\"$myrow[id]\">$myrow[name]</option>";
?>
	</select></div></td>
	</tr>
	<tr><td><div id="div_i2"><select id="i2" onchange="getchildren('i',2,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_i3"><select id="i3" onchange="getchildren('i',3,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_i4"><select id="i4" onchange="getchildren('i',4,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_i5"><select id="i5" onchange="getchildren('i',5,6)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_i6"><select id="i6" disabled><option value="---------">---------</option></select></div></td>
	</table>
	<br>
	<input type="text" id="i" size="40" value="" onkeypress="autoComplete(this,event)">
	<input type="hidden" id="ac_i" value="">
	</div>
</td>