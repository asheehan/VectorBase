<?php

/*
**	This script will index the BACs found in the folders mentioned below
**	We will generate a json file via this script for import into solr
*/

DEFINE('BAC_DIR', '/vectorbase/web/vbpre/data/BACs/');
DEFINE('BAC_WEB_DIR', '/data/BACs/');
DEFINE('BAC_DOMAIN', 'BACs');
//DEFINE('BAC_DESCRIPTION', 'BAC in the');
DEFINE('INVALID_FILES', serialize( array( '.', '..', '.svn' )) );

$subdomains = array_diff( scandir(BAC_DIR), unserialize( INVALID_FILES ));
$subdomains = array_values($subdomains);

// container to store data
$data = array();

// loop through node objects, collect desired data
//$data->add = new StdClass();
$count = 0;
foreach($subdomains as $subdomain){

  $files = array_diff( scandir(BAC_DIR.$subdomain), unserialize( INVALID_FILES ));
  $files = array_values($files);

  foreach( $files as $file ){
    
    $add = array();
    $doc = array();
    $n = new StdClass();

    // basic properties
    $n->site = BAC_DOMAIN;		// domain as it appears in the results
    $n->bundle = $subdomain;		// subdomain
    $n->bundle_name = $subdomain;	// subdomain as it appears in the results
    $cleanName = nameCleaner($file);
    $n->label = $cleanName;
    $n->entity_type = $cleanName;
    $n->id = $cleanName;
    $n->url = BAC_WEB_DIR . $subdomain . "/$file";
    $n->path = BAC_WEB_DIR . $subdomain . "/$file";
    $n->description = "BAC $cleanName in the $subdomain section";
    
    $add['doc'] = $n;
    //$add['add'] = $doc;
    $data[] = $add;
    $count++;
  }
}

// encode in json and snip the front/back to parse
$json = json_encode($data);
$json = jsonCleaner($json);
file_put_contents('/vectorbase/web/root/scripts/drupal-indexing/bac-export.json', $json);
print "$count objects indexed.\n";

// minor changes to the json file so that solr parses it correctly
function jsonCleaner($json){
  $json = substr($json, 1);
  $json = substr($json, 0, -1);
  $json = str_replace('{"doc":', '"add":{"doc":', $json);
  return '{' . $json . '}';
}

// strip .jpg and photo tags
function nameCleaner($photo){
  $photo = str_replace("photo_", "", $photo);
  $photo = str_replace("photo", "", $photo);
  $photo = str_replace(".jpg", "", $photo);
  return $photo;
}

?>
