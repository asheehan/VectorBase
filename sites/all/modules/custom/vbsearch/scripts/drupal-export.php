<?php

// define data format
DEFINE('EXPORT_DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

// fetch desired node data
$sql = "select nid from {node} order by nid asc";
$resource = db_query($sql);
$nodes = array();
foreach ($resource as $row) {
  $node = node_load($row->nid);
  if (is_object($node)) {
    $nodes[] = $node;
  }
}

// create a container to store all data
$data = new StdClass();

// loop through node objects, collect desired data
$data->add = new StdClass();
$count = 0;
foreach ($nodes as $nid => $node) {
  
  $n = new StdClass();
  // check published and archived status
  if ($node->status != 0){

    $fieldStatus = $node->field_status[und][0][value];
    if ( strcmp($fieldStatus, "Archived") != 0 && strcmp($fieldStatus, "Deprecated") != 0 ){

	// basic properties
	$n->site = "General";				// domain as it appears in the results
	$n->bundle = $node->type;			// subdomain
	$n->bundle_name = nameCleaner($node->type);	// subdomain as it appears in the results
	$n->label = $node->title;
	$n->entity_type = $node->type;
	$n->id = $node->nid;
	$n->timestamp = date(EXPORT_DATE_FORMAT, $node->created);
	$n->content = $node->body[und][0][value];

	// url translation
	$drupal_url = "node/".$node->nid;
	$n->url = "/" . drupal_lookup_path('alias', $drupal_url);
	$n->path = "/" . drupal_lookup_path('alias', $drupal_url);

	// description creation 	TODO update this when no longer necessary (once proper teaser is in the index)
	if( $n->content ){
	  $n->description = substr(strip_tags($n->content), 0, 125);
	  $n->description .= "...";
	}

	// downloadable files 
	// this serves to pull associate a downloadable file with a species
	if (strcmp($node->type, "downloadable_file") == 0) {
	  $tid = $node->field_organism_taxonomy[und][0][tid];		// the tid as it exists in the node
	  $nameResult = db_query("select name from taxonomy_term_data where tid = :tid", array(':tid' => $tid));
	  $name = $nameResult->fetchField(0);
	  if ($name) {
	    $n->species = $name;
	  }
	  $n->description = $node->field_description[und][0][value];
	}

	// append node to our data array
	$data->add->{$node->nid}['doc'] = $n;
	$count++;
    }
  }
}

// encode in json and snip the front/back to parse
$json = json_encode($data);
$json = jsonCleaner($json);
file_put_contents('./drupal-export.json', $json);
print "$count objects indexed.\n";

// reformat the type to make it presentable for search results
function nameCleaner(string $name){
  $name = ucfirst($name);
  $name = str_replace("_", " ", $name);
  return $name;
}

// minor changes to the json file so that it parses correctly
function jsonCleaner(string $json){
  $json = substr($json, 7);
  $json = substr($json, 0, -1);
  // replace id with "doc"
  $pattern = '#"\d+":\{"doc":\{#';
  $replace = '"add":{"doc":{';
  return preg_replace($pattern, $replace, $json);
}

?>
