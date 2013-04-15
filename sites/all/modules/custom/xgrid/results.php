<?php
$id=$_POST["id"];

// also allow gets for now
if(!$id)
  $id=$_GET["id"];

  header("Content-type:text/plain");

if(!$id){
  echo "No job ID provided.";
}else{
  $xgridUrl="http://jobs.vectorbase.org/xgrid.wsdl";
  $client = new SoapClient($xgridUrl, array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
  $statusOutput = $client->getStatus($id);
  preg_match("#jobStatus = (.*?);#",$statusOutput,$match);
  $status=$match[1];

  if (!$status)
    echo "No data for job $id";
  else if ($status=="Finished")
    $results = $client->getResults($id);
  else if ( $status=="Failed" || $status=="Canceled")
    $results = "Problem with job $id: $status";
  else if ($status=="Started" || $status=="Running")
    $results = "Job $id is still running";
  else if ($status=="Pending")
    $results = "Job $id is waiting in the queue";
  else
    $results = "Job $id status: $status";

  echo $results;
}

