<?php

/**
 * This script +1's the download counter on a particular drupal 
 * "downloadable_file" node.
 *
 * @package DataFiles 
 * @filesource
 */

define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DL_COUNT_TAG', 'download count');

require_once(DRUPAL_ROOT . '/includes/bootstrap.inc');
require_once('constants.php');

$phase = drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

if(isset($_GET[DATA_FILE_NODE_VIEW_BASENAME]) && 
		$_GET[DATA_FILE_NODE_VIEW_BASENAME] != 'undefined') {
	
	$basename = $_GET[DATA_FILE_NODE_VIEW_BASENAME];
	$node = false;
	if(!is_numeric($basename)) {
		$q = db_select('node', 'n');
		$q->addField('n', 'nid');
		$q->addField('n', 'vid');
		$q->addField('n', 'title');
		$q->condition('a.alias', "%$basename%", 'ilike');  
		$q->join('url_alias', 'a', 'n.nid = substring(a.source from 6)::integer');
		$results = $q->execute()->fetchAssoc();
		if($results !== FALSE) {
			$node = node_load($results['nid'], $results['vid']);
		} else {
			watchdog(DL_COUNT_TAG, 'Could not find a record for the file with url alias of %url_alias', array('%url_alias'=>$basename), WATCHDOG_INFO);
		}
	} else {
		watchdog(DL_COUNT_TAG, '%url_alias is not an integer', array('%url_alias'=>$basename), WATCHDOG_INFO);  
		$node = node_load($basename);
	}

	if($node !== FALSE) {
		if(empty($node->field_download_count)) {
			$node->field_download_count = array('und' => array(0 => array('value' => 0)));
		}
		$curVal = $node->field_download_count['und'][0]['value'];
		$curVal++;
		$node->field_download_count['und'][0]['value'] = $curVal;
		node_save($node);
		cache_clear_all('field:node:'.$nid, 'cache_field');
		watchdog(DL_COUNT_TAG, '%filename\'s download count is now %curVal.', array('%filename'=>$results['title'], '%curVal'=>$curVal), WATCHDOG_INFO);
		$urlParts = explode('//', $node->field_file['und'][0]['uri']);
		header("Location: https://{$_SERVER['SERVER_NAME']}/sites/default/files/ftp/{$urlParts[1]}");
		header('Content-Type: ' . $node->field_file['und'][0]['filemime']);			
		header('Content-Disposition: attachment; filename="' . $node->field_file['und'][0]['filename'] . '"');
		header('Content-Length: ' . $node->field_file['und'][0]['filesize']);

	} else {
		watchdog(DL_COUNT_TAG, 'Could not find a record for the file with url alias of %url_alias', array('%url_alias'=>$basename), WATCHDOG_INFO);
	}
} else {
	$n = isset($_GET[DOWNLOAD_COUNT_NODE_ID_GET_KEY]) ? 'undefined' : 'null';
	$v = isset($_GET[DOWNLOAD_COUNT_VERSION_ID_GET_KEY]) ? 'undefined' : 'null';
	watchdog(DL_COUNT_TAG, 'Post variable did not contain a \'nodeId\' (%nid) and/or a \'versionId\' (%vid) attribute.', array('%nid'=>$n, '%vid'=>$v), WATCHDOG_DEBUG);
}

