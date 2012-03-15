<?
	$server_vars = $_SERVER["DOCUMENT_ROOT"] . "/includes/index_header.php";
	require_once($server_vars);
	require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/Jobs.php");
	header('Content-type: text/plain');

    try { 
        $results = Jobs::getResults($_GET["job_id"], "HMMBUILD");
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

	$input = $results->results();
	$input_sequence = trim($input,"\r\n");
	//parse input file to remove hmmcalibrate garbage at begining
	$lines = split("\n",$input_sequence);

	$count = 0; $start = 0; $end = count($lines);
	foreach ($lines as $line) {
	  if ($line=="//\n" || $line=="//") {
	      $end = $count;
	  } 
	  $count++;
	}
	$newlines = array_slice($lines, $start, $end);
	// hmmsearch is stupid and looks for carriage returns, not new lines, to terminate every line on its input files
	$output = implode("\r",$newlines);
        print trim($output);
    }
?>
