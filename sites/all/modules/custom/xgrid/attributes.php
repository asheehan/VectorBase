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
 return $statusOutput;
}
