<?
        header("Content-type: text/plain");
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	require_once($server_vars);
	require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/Jobs.php");

	//look up search id for given job id.
	$jobtype_insert_query = "SELECT value from job_params where argument='searchId' and job_id=".$_GET["job_id"];
	$result=pg_query(DB::getJOB_DB(), $jobtype_insert_query);
	while ($row = pg_fetch_assoc($result)) {
		$searchId=$row['value'];
	}

    try { 
        $results = Jobs::getResults($searchId, "BLAST");
    } catch (JobException $e) {
        $results_error=1;
        print "Results: ";
        if ($e->getJobCode() == JobException::NO_RESULTS) {
            print "No results for job " . $searchId . ".";
          } elseif ($e->getJobCode() == JobException::NO_JOB) {
            print "No job with id " . $searchId . ".";
          } else {
            print $e->getMessage();
          }
    }

    if (!$results_error){
    	if ($_GET["result"]){
                $result_array = preg_split("#(BLAST.*?])#", $results->results(), NULL, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		print(trim($result_array[ ($_GET['result'] -1 ) * 2]));	//prints line "BLAST version [date]"
		print($result_array[ ($_GET['result'] -1 ) * 2 + 1] );	//prints result
    	} else
	        print $results->results();
    }

?>
