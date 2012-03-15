<?
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	require_once($server_vars);
	require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/Jobs.php");
	header('Content-type: text/plain');

    try { 
        $results = Jobs::getResults($_GET["job_id"], "ClustalW");
    } catch (JobException $e) {
        $results_error=1;
        print "<b>Results: </b>";
        if ($e->getJobCode() == JobException::NO_RESULTS) {
            print "No results for job " . $_GET["job_id"] . ".";
          } elseif ($e->getJobCode() == JobException::NO_JOB) {
            print "No job with id " . $_GET["job_id"] . ".";
          } else {
            print $e->getMessage();
          }
    }
    
    if (!$results_error){
    	if ($_GET["result"]){
                $result_array = preg_split("/(BLAST.\s\d\.\d\.\d+\s\[\w+-\d+-\d+\])/", $results->results(), -1, PREG_SPLIT_DELIM_CAPTURE);
    		for ($i=0;$i<=sizeof($result_array);$i++){
    			if ($i ==$_GET["result"]*2 || $i ==$_GET["result"]*2-1)
    				print $result_array[$i];
    		}
    	} else
		print $results->parsedResults();
    }

?>
