<?php

$id = '';
if (isset($_POST['id'])) {
	$id = $_POST['id'];
} else if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

header("Content-type:text/plain");

if (empty($id)) {
	echo "No job ID provided.";
} else {
	$xgridUrl="http://jobs.vectorbase.org/xgrid.wsdl";
	$client = new SoapClient($xgridUrl, array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
	$statusOutput = $client->getStatus($id);
	$match = array();	
	preg_match("#jobStatus = (.*?);#",$statusOutput,$match);
	$status = '';
	if (!empty($match)) {
		$status = $match[1];
	}
	$results = '';
	if (empty($status)) {
		$results = "No data for job $id";
	} else if ($status=="Finished") {
		$results = $client->getResults($id);
	} else if ($status=="Failed" || $status=="Canceled") {
		$results = "Problem with job $id: $status";
	} else if ($status=="Started" || $status=="Running") {
		$results = "Job $id is still running";
	} else if ($status=="Pending") {
		$results = "Job $id is waiting in the queue";
	} else {
		$results = "Job $id status: $status";
	}
	echo $results;
}

