<?
	$JOB_STATUS["status"]="Job Status";
	$JOB_STATUS["new"]="New BLAST";
	$JOB_STATUS["sequence"]="View Query Sequence";
	$JOB_STATUS["res"]="View Results";
	$JOB_STATUS["fetch"]="Download Hit Sequences";
//	if (!$_GET["page"]){
//		$_GET["page"] = "new";
//	}
	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="section_title" style="padding-top:10px;padding-left:10px;">
			BLAST @ VectorBase.org&nbsp;&raquo;
		</td>
		<td align="right" valign="bottom" style="padding-right:10px;">
			<?
				//if ($_GET["job_id"]){
				//	print "<a class=\"hashelp\" name=\"Web:view_job_summary\" href=\"/Tools/BLAST/?page=status&job_id=" . $_GET["job_id"] . "\">Job " . $_GET["job_id"] . " Report";
				//}
			?>
		</td>
	</tr>
	<?/* if ($_GET["e0"])
		print "<tr><td colspan=\"2\"><span style=\"font-weight:bold;color:red;\">Please report the following error to the webmaster:</span><span class=\"small\">" . stripslashes(urldecode($_GET["e0"])) . "</span></td></tr>";
	*/?>
	<tr>
		<td valign="top" colspan="2">
		<?
/*
    if($_GET["result"]){
			$blast_include_file='tool_includes/BLAST/'.$_GET['result'].'.php';
		}elseif($_GET["job_id"]){
			$blast_include_file="tool_includes/BLAST/separateResults.php";
		}else{
    */
			$blast_include_file="tool_includes/BLAST/input.php";
		//}

		@include($blast_include_file);
		?>
		</td>
	</tr>
</table>
