<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<?
		if($_GET['job_id']){
			
		} else {
			$num_jobs = $_GET['hist'];
			print "Viewing past " . $num_jobs . " jobs for " . $_SESSION['username'] . "<br /><br />";
		
		
			$job_query = "select * from user_jobs where user_id = '" . $_SESSION['user_id'] . "' order by job_submit desc";
			//print $job_query;
			$job_results = pg_query(DB::getUI_DB(), $job_query);
			$user_blast_num = 0;
			while ($jr_row = pg_fetch_assoc($job_results) and ($user_blast_num < $num_jobs)) {
				foreach($jr_row as $jr_key => $jr_value) {
					$user_blast_arr[$user_blast_num][$jr_key] = $jr_value;
					//print $jr_key . "=>" . $jr_value . "<br />";
				}
				$user_blast_num++;
			}
			if($user_blast_num) {
				for($i = 0; $i < $user_blast_num; $i++){
					print "<a onmouseover=\"diplay_help('Open html BLAST results.');\" onmouseout\=\"clear_help();\" href=\"http://" 
					. $_SERVER["HTTP_HOST"] . "/Tools/BLAST/?results=1&type=html_results&job_id=" . $user_blast_arr[$i]["job_id"] 
					. "\">Job " . $user_blast_arr[$i]["job_id"] 
					. " - Type: " . $user_blast_arr[$i]["job_type"] 
					. "<br />Submitted " . /*date("m-d-Y H:i:s", */$user_blast_arr[$i]["job_submit"]/*)*/ 
					. "<br />Finished " . $user_blast_arr[$i]["job_end"] . "<br /></a><br />\n";
				}
			} else {
				print "<br />No jobs found.  Contact webmaster with problems.<br />\n";
			}
		}
	?>
    </td>
  </tr>
</table>



<?/*elseif ($_GET["hist"]){
                                        $blast_include_file="tool_includes/BLAST/blast_history.php";*/?>

