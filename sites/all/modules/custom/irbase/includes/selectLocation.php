<td class="cell_key">Site location:</td>
<td class="cell_value">
<div id="div_l">
<table>
<tr>
<td>
<div>
<select id="l1" onchange="getchildren('l',1,7)">
		<option value="---------">---------</option>
<?
$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"GAZ:00000467\" AND term_id=id ORDER BY name ASC";
$result = mysql_query( $query, $dbConn );
while ( $myrow = mysql_fetch_array ( $result ) )
	echo "			<option value=\"$myrow[id]\">$myrow[name]</option>\n";
?>
</select>
</div>
</td>
</tr>
<tr><td><div id="div_l2"><select id="l2" onchange="getchildren('l',2,7)" disabled><option value="---------">---------</option></select></div></td></tr>
<tr><td><div id="div_l3"><select id="l3" onchange="getchildren('l',3,7)" disabled><option value="---------">---------</option></select></div></td></tr>
<tr><td><div id="div_l4"><select id="l4" onchange="getchildren('l',4,7)" disabled><option value="---------">---------</option></select></div></td></tr>
<tr><td><div id="div_l5"><select id="l5" onchange="getchildren('l',5,7)" disabled><option value="---------">---------</option></select></div></td></tr>
<tr><td><div id="div_l6"><select id="l6" onchange="getchildren('l',6,7)" disabled><option value="---------">---------</option></select></div></td></tr>
<tr><td><div id="div_l7"><select id="l7" disabled><option value="---------">---------</option></select></div></td>
</tr>
</table>
</div>
</td>