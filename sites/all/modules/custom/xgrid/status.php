<?php

$id=$_POST["id"];
if(!$id)
	$id=$_GET["id"];

if (!$id){
 echo "No job ID provided.";
}else{
 $xgridUrl="http://jobs.vectorbase.org/xgrid.wsdl";
 $soapClient = new SoapClient($xgridUrl, array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
 $statusOutput = $soapClient->getStatus($id);
 preg_match("#jobStatus = (.*?);#",$statusOutput,$match);
 if(!$match[1]) 
  echo "Sorry, we have no information for Job ID ".$id;
 else
  echo $match[1];
}
