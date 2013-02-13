<?php

// **** load drupal enviornment ****
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
require_once(DRUPAL_ROOT.'/includes/bootstrap.inc');
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$id=$_POST["id"];
$type=$_POST["type"];

// also allow gets for now
if(!$id)
  $id=$_GET["id"];
if(!$type)
  $type=$_GET["type"];


header("Content-type:appliation/octet-stream");
header("Content-Disposition: attachment; filename=\"clustalw_".$id."_".$type.".txt\"");


if(!$id){
  echo "No job ID provided.";
}else if(!($type=='align' || $type=='tree' || $type=='stdout')){
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

