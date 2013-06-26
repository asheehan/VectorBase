<td class="cell_key">Mosquitoes used:</td>
<td class="cell_value">
	<div id="div_mu">
	<table>
	<tr>
	<td><div><select id="mu1" onchange="getchildren('mu',1,5)"><option value="---------">---------</option>
<?
	$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:30000006\" AND term_id=id ORDER BY name ASC";
	$result = mysql_query( $query, $dbConn );
	while( $myrow = mysql_fetch_array( $result ) )
		echo "<option value=\"$myrow[id]\">$myrow[name]</option>";
?>
	</select></div></td>
	</tr>
	<tr><td><div id="div_mu2"><select id="mu2" onchange="getchildren('mu',2,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_mu3"><select id="mu3" onchange="getchildren('mu',3,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_mu4"><select id="mu4" onchange="getchildren('mu',4,5)" disabled><option value="---------">---------</option></select></div></td></tr>
	<tr><td><div id="div_mu6"><select id="mu5" disabled><option value="---------">---------</option></select></div></td>
	</table>
	<br>
	</div>
</td>