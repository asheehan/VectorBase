<table border="0" width="<?=$SITE_WIDTH;?>" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding-left:10px;padding-right:10px;">
			<?
				$sequence_query = "select value from job_params where job_id = ".$_GET["job_id"] . " and argument='sequence';";
				$sequence_row = pg_fetch_assoc(pg_query(DB::getJOB_DB(),$sequence_query));
				preg_match_all("/(\>.*\n)((?:[^>]*\n*)*)/i",$sequence_row["value"],$sequences,PREG_SET_ORDER);
				if ($_GET["sequence"]){
					foreach ($sequences as $sequence){
						print "<pre>";
						if (substr(trim($sequence[1]),1)==urldecode($_GET["sequence"])){
							print $sequence[1];
							print wordwrap($sequence[2],60,"\n",1);
						}
						print "</pre>";
					}
				} else {
					print "<pre>" . wordwrap($sequence_row["value"],60,"\n",1) . "</pre>";
				}
			?>
		</td>
	</tr>
</table>
