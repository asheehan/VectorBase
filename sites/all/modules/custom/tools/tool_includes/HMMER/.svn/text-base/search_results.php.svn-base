<?
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	require_once($server_vars);
	require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/Jobs.php");
	header('Content-type: text/plain');
        //print "<pre>\n";
    try { 
        $results = Jobs::getResults($_GET["job_id"], "HMMSEARCH");
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
    
    if (!$results_error) {
        print $results->results();    
    }
    //print "</pre>\n";
?>
