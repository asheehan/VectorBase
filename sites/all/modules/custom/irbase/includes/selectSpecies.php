<?php
echo <<<END
<td class="cell_key">Species:</td>
<td class="cell_value">
<div id="div_s">
<table>
<tr>
<td><div><select id="s1" onchange="getchildren('s',1,7)">
	<option value="---------" selected>---------</option>
END;

$query = "SELECT id, name FROM iro_term, iro_relationship WHERE to_term_id=\"MIRO:40003818\" AND term_id=id ORDER BY name ASC";
$result = mysql_query( $query, $dbConn );
while ( $myrow = mysql_fetch_array ( $result ) )
	echo "				<option value=\"$myrow[id]\">$myrow[name]</option>\n";
echo <<<END2
</select></div></td>
<td><div id="div_s2"><select id="s2" onchange="getchildren('s',2,7)" disabled><option value="---------">---------</option></select></div></td>
<td><div id="div_s3"><select id="s3" onchange="getchildren('s',3,7)" disabled><option value="---------">---------</option></select></div></td>
<td><div id="div_s4"><select id="s4" onchange="getchildren('s',4,7)" disabled><option value="---------">---------</option></select></div></td>
</tr>
</table>
<table>
<tr>
<td><div id="div_s5"><select id="s5" onchange="getchildren('s',5,7)" disabled><option value="---------">---------</option></select></div></td>
<td><div id="div_s6"><select id="s6" onchange="getchildren('s',6,7)" disabled><option value="---------">---------</option></select></div></td>
<td><div id="div_s7"><select id="s7" disabled><option value="---------">---------</option></select></div></td>
</tr>
</table>
<br>
<input type="text" id="s" size="40" value="" onkeypress="autoComplete(this,event)">
<input type="hidden" id="ac_s" value="">
</div>
</td>
END2;

?>