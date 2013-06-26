<?php

$id='';
if (isset($_POST['id'])) {
	$id = $_POST['id'];
} else if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (empty($id)) {
	echo 'NO_ID';
} else {
	$xgridUrl="http://jobs.vectorbase.org/xgrid.wsdl";
	$soapClient = new SoapClient($xgridUrl, array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));
	$statusOutput = $soapClient->getStatus($id);
	$match = array();	
	preg_match('#jobStatus = (.*?);#',$statusOutput,$match);
	if(empty($match)) {
		echo 'NO_INFO';
	} else {
		echo $match[1];
	}
}

