<?php
/**
 * This file contains a set of utility functions that both serve as core functions
 * for certain actions related to "downloadable_files"/"Data files", as well as
 * auxilliary functions that makes coding easeier and cleaner for the developer.
 *
 * @package DataFiles
 * @filesource
 */


require_once('constants.php');
require_once('heap.php');


/** 
 * Convenience method to add an error message to an error array map.
 * 
 * This is geared for use in the Drupal forms, where the "element" is the
 * name of the UI element that the error applies to. msg is the message, and
 * the errArray is the pass-by-reference variable to hold the message.
 *
 * @param string $element Key for the error.
 * @param string $msg Error message.
 * @param int[]|string[] $errArray Array that holds the errors. These are added by
 * reference.
 *
 * @return void If the element variable is not set or is set to null, this method will
 * simply return.
 */
function errAdd($element, $msg, &$errArray) {

	if(!isset($element) || is_null($element)) { // If the key isn't provided
		return;
	}

	if (array_key_exists($element, $errArray)) { // If the key exists

		// Add message to elemnt array
		array_push($errArray[$element], $msg);

	} else { // If the key is new

		// Add new array with the message as the only element
		$errArray[$element] = array($msg);
	}

}


/**
 * Drupal 7 implementation of hook_views_query_alter.
 * 
 * This implementation alters filtered queries in the "Downloads/Data files"
 * view. It allows a user to filter by a term in the file type taxonomy
 * and get matches for that term AND its child terms.
 *
 * @see hook_views_query_alter(&$view, &$query)
 *
 * @param object $view Drupal view object.
 * @param object $query Drupal query object.
 *
 * @return void
 */
function downloadable_file_views_query_alter(&$view, &$query) {
	if($view->name == 'downloads') {
		foreach($query->where[1]['conditions'] as $key => $condition) {
			if($condition['field'] == 'field_data_field_download_file_type.field_download_file_type_tid') {
				$type = $condition['value'];
				$familyTree = taxonomy_get_children($type);
				$tids = array($type);
				foreach($familyTree as $node) {
					array_push($tids, $node->tid);
				}
				$query->where[1]['conditions'][$key]['value'] = $tids;
				$query->where[1]['conditions'][$key]['operator'] = 'IN';
				break;
			}
		}
	}
}


/**
 * Returns unique list of organisms referenced in exisiting data files (downloads).
 *
 * Utility method designed to scan all nodes classified as "downloadable_file"s,
 * and return a unique list of organism taxon ids from the organism taxonomy.
 * Each taxon id returned has at least one "downloadable_file" node that exsits
 * in drupal. This method is used to display a shortened, relevant list of 
 * organisms available to filter on in the "Data files" (downlaods) view.
 * 
 * @return string[]|int[] List of organism taxon ids.
 */
function getUniqueListOrgTidsFromDownloads() {

	$q = db_select('node', 'n');
	$q->distinct();
	$q->innerJoin('field_data_field_organism_taxonomy', 'org', 'n.nid = org.entity_id');
	$q->addField('org', 'field_organism_taxonomy_tid', 'tid');
	$q->condition('n.type', 'downloadable_file', '=');
	$q->orderBy('tid');
	$results = $q->execute();
	$tids = array();
	foreach ($results as $res) {
		array_push($tids, $res->tid);	
	}
	return $tids;

}


/**
 * Returns a max heap object of ranked files.
 *
 * @param int|string $organismId Organism taxonomy id to be ranked on. 
 * @param int|string (Optional) $tagId Taxon Id of a Tag that is used by downloads to
 * promote certain files over others.
 * @param int $limit (Optional) Number of files to return in the ranking.
 *
 * @return DownloadSimpleHeap A max heap object of ranked files (drupal nodes).
 */
function getSortedFiles($organismId, $tagId, $limit) {

	$q = db_select('node', 'n');
	$q->leftJoin('field_data_field_tags', 'tags', 'n.nid = tags.entity_id AND tags.field_tags_tid = :field_tags_tid', array(':field_tags_tid'=>$tagId));
	$q->innerJoin('field_data_field_download_count', 'count', 'n.nid = count.entity_id');
	$q->innerJoin('field_data_field_organism_taxonomy', 'org', 'n.nid = org.entity_id AND org.field_organism_taxonomy_tid = :field_organism_taxonomy_tid', array(':field_organism_taxonomy_tid'=>$organismId));
	$q->innerJoin('field_data_field_file', 'file', 'n.nid = file.entity_id');
	$q->innerJoin('file_managed', 'managed', 'file.field_file_fid = managed.fid');
	$q->addField('n', 'nid');
	$q->addField('n', 'vid');
	$countFieldAlias = $q->addField('count', 'field_download_count_value');
	$tagsTidFieldAlias = $q->addField('tags', 'field_tags_tid');
	$q->addField('n', 'title');
	$q->addField('managed', 'filesize');
	$q->condition('n.type', 'downloadable_file', '=');
	$q->orderBy($countFieldAlias);
	$q->orderBy($tagsTidFieldAlias, 'DESC');
	if(!empty($limit)) {
		$q->range(0, $limit);
	}
	$testResult = $q->execute();
	$resultObjects = array();
	$maxHeap = new DownloadSimpleHeap();
	foreach ($testResult as $testRez) {
		$maxHeap->insert($testRez);	
	}
	return $maxHeap;
}


/**
 * Re-writes the file links to display "human readable" filesize.
 *
 * Function is added into the "post_render" stack by this module's
 * implementation of hook_node_view_alter.
 *
 * @param string $content HTML content to be displayed.
 * @param array $element Container for the renderable page.
 *
 * @return string Returning the given content variable.  This is probably not
 * necessary, but to avoid possibly breaking things, this is left in.
 */
function download_file_post_render($content, $element) {
	$fileSize = getFileSizeHumanReadable($element['field_file']['#items'][0]['filesize']);
	$matches = array();
	$stuff = $element['field_file']['#items'][0]['filename'];
	$content = preg_replace("#href\s*=\s*\".+?\"\s*(.+?)\s*>$stuff</a>#", 
			"href=\"/sites/all/modules/custom/downloadable_file/include/incrementFileDownloadCount.php?nid=" .
			$element['#node']->nid  . "&vid=" . 
			$element['#node']->vid . "\" class=\"" . 
			DATA_FILE_DOWNLOAD_LINK_CSS_CLASS . "\" $1>" . $stuff . 
			' | ' . $fileSize . '</a>', $content);
	return $content;
}


/**
 * Convenience method to calculate, in human-readable text, the
 * size of something given the bytes and precision.
 *
 * @param int $bytes Number of bytes to convert.
 * @param int $precision How many decimal places to be specific to.
 * default is set to 2.
 *
 * @return string Human readable string of the size given. Values will be
 * in either B, KB, MB, GB, or TB. Note, if something larger than TB is
 * given, returned value will not be correct, it will return that same
 * number as B. 
 */
function getFileSizeHumanReadable($bytes, $precision = 2) {
	$kilobyte = 1024;
	$megabyte = $kilobyte * 1024;
	$gigabyte = $megabyte * 1024;
	$terabyte = $gigabyte * 1024;
	if (($bytes >= 0) && ($bytes < $kilobyte)) {
		return $bytes . ' B';
	} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
		return round($bytes / $kilobyte, $precision) . ' KB';
	} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
		return round($bytes / $megabyte, $precision) . ' MB';
	} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
		return round($bytes / $gigabyte, $precision) . ' GB';
	} elseif ($bytes >= $terabyte) {
		return round($bytes / $terabyte, $precision) . ' TB';
	} else {
		return $bytes . ' B';
	}
}


/**
 * Fixes the filenames download nodes that have been "munged" (filename has a 
 * "_." in it).
 * 
 * @return string Returns a html formatted status results string that is used to
 * display feedback of what happened in this method.
 */
function fixMungedFilenames() {

	$q = db_select('node', 'n');	
	$q->addField('n', 'nid');
	$q->addField('n', 'vid');
	$q->addField('n', 'title');
	$q->condition('n.type', 'downloadable_file', '=');
	$q->distinct();
	$results = $q->execute();
	$status = "<ul>";
	while($record = $results->fetchAssoc()) {
		$node = node_load($record['nid'], $record['vid']);
		if($node !== false) {
			$re = '/^(.+)_\.(.+)/';
			$title = $node->title;	
			$uri = $node->field_file['und'][0]['uri'];
			$fid = $node->field_file['und'][0]['fid'];
			$fixedTitle = '';
			$fixedUri = '';
			$newFile = false;
			if(preg_match($re, $title, $m)) {
				$fixedTitle = $m[1] . $m[2];
				$node->title = $fixedTitle;
			}
			if(preg_match($re, basename($uri), $m) ||
			   (preg_match('/(.+)_[\d](\.[[:alnum:]]+)$/', basename($uri), $m) && 
			    $node->field_file['und'][0]['filename'] === $m[1].$m[2])) {
				$fixedUri = dirname($uri) . '/' . $m[1] . $m[2];
				if($newFile = file_move(file_load($fid), $fixedUri, FILE_EXISTS_REPLACE)) {
					$newFile->filename = $m[1] . $m[2];
					file_save($newFile);
				}
			}
			if(!empty($fixedTitle) || !empty($fixedUri)) {
				$status .= "<li>Fixing munged node {$node->nid} ($title)<ul>";
				$status .= '<li>Change title? <span style="color:';
				$status .= !empty($fixedTitle) ? 'green">YES' : 'red">NO';
				$status .= '</span></li>'; 
				$status .= '<li>Change uri/filename? <span style="color:';
				$status .= !empty($fixedUri) ? 'green">YES' : 'red">NO';
				$status .= '</span></li>'; 
				$status .= empty($newFile) ? "<li><span style=\"color:yellow\">There was a problem renaming node \"{$node->nid}\"</span></li>" : '';
				$status .= '</ul></li>';
				node_save($node);
			} 
		}
	}
	$status .= "</ul>";
	$status .= "<br>Done!<br>";
	return $status;

}

/** * Simple getter that returns a map from common orgnism shortnames to their
 * full names in "genus-species" format. This function was specifically designed 
 * for the Download Files Name format.
 * 
 * @todo Might remove this b/c the names no longer follow the name format.
 */
function getShortNames() {
	$names = array(
			'agambiae' => 'anopheles-gambiae',
			'aaegypti' => 'aedes-aegypti',
			'adarlingi' => 'anopheles-darlingi',
			'astephensi' => 'anopheles-stephensi',
			'cquinquefasciatus' => 'culex-quinquefasciatus',
			'gmorsitans' => 'glossina-morsitans',
			'iscapularis' => 'ixodes-scapularisi',
			'llongipalpis' => 'lutzomyia-longipalpis',
			'phumanus' => 'pediculus-humanus',
			'ppapatasi' => 'phlebotomus-papatasi',
			'rprolixus' => 'rhodnius-prolixus',
		      );
	return $names;
}


/**
 * Convenience method that returns a string from the beginning
 * to the nth instance of a given character.
 *
 * Warning: String-typed checks are performed in this function,
 * so make sure the original and char inputs are strings. If,
 * for some reason, one of the 2 is something else, they will
 * never match.
 * Warning 2: Negative numbers will not work in this method.
 *
 * @param string $original The given string.
 * @param string $char The character to search for.
 * @param int	$nth How many occurrances to count before returning
 * the substring.
 *
 * @return The substring before the nth occurrance of the given char,
 * or the original string if the char is not found or if there are less
 * than n chars in the string. 
 */
function substrnpos($original, $char, $nth) {
	$max = strlen($original);
	$n = 0;
	for($i = 0; $i < $max; $i++) {
		if($original[$i] === $char) {
			$n++;
			if($n>=$nth) {
				return substr($original, 0, $i);
			}
		}
	}
	return $original;
}





