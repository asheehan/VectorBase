<?php

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);



$fasta='';
foreach($_POST as $key => $value){
	if(strstr($key,'hsp')){
		$fasta.=clustalw_getFastaForHsp($value);
	}
}

if($fasta){
	$args['sequence']=$fasta;
	$id=clustalw_submit_xgrid($args);

	// should have either a look up id or submitted job id at this point
	if($id){

		// job has been submitted. continually get status updates until we're done
		while( !($status=="Finished" || $status=="Failed") ){
			$status=xgrid_status($id);
			sleep(2);
		}

		$out=file_get_contents('https://'.$_SERVER['SERVER_NAME'].'/'.drupal_get_path('module', 'xgrid').'/results.php?id='.$id);
		$out=preg_replace("#.*?====START OF ALIGNMENT====#s","",$out);
		$out=str_replace(" ","&nbsp;",trim($out));
		$out=str_replace("\n","<br />",$out);


	}else{
		$out="Error: could not submit seqeunces for alignment.";
	}
}else{
	$out="Error: Could not find hit sequences in our DB.";
}

echo '<div id="clustalResults">'.$out.'</div>';