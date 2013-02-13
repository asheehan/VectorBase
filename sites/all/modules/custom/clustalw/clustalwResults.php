<?php

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

header("Content-type:text/plain");

$id=$_GET["id"];
$type=$_GET["type"];


if(!$id){
  echo "No job ID provided.";
}else if(!($type=='align' || $type=='guide' || $type=='stdout')){
  echo "Incorect result type";
}else{
    if($type=='align')
      $results=clustalw_getAlignOut($id);
    elseif($type=='stdout')
      $results=clustalw_getStdOut($id);
    else
      $results=clustalw_getGuideTree($id);

  echo $results;
}

