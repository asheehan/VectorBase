<?php
/**
* This file contains all the support functions realted to rendering pages,
* generating html, etc that are part of the data file (downloadable_file) module. 
* 
* @package DataFiles
* @filesource
*/


require_once('constants.php');
require_once('utilities.php');


/**
* Function used to construct the Administration page for this
* module.
* 
* @return string[] Render array defining the form.
*/
function downloadable_file_admin_form() {

   $form['status_area'] = array(
            '#title' => 'Status',
            '#prefix' => '<div id="status-div">',
            '#suffix' => '</div>',
            '#type' => 'fieldset',
            '#description' => 'Status.',

   );

   /*$form['convert_names'] = array(
            '#type' => 'button',
            '#value' => t('Convert Names'),
            '#ajax' => array(
                     'callback' => 'downloadable_file_admin_ajax_handler',
                     'method' => 'replace',
                     'effect' => 'fade',
                     'progress' => array('type' => 'throbber', 'message' => t('Converting Names')),
                     'wrapper' => 'status-div',
            )
   );*/

   $form['clear_featured_tags'] = array(
            '#type' => 'button',
            '#value' => t('Clear \'Featured Download\' Tags'),
            '#ajax' => array(
                     'callback' => 'downloadable_file_admin_ajax_handler',
                     'method' => 'replace',
                     'effect' => 'fade',
                     'progress' => array('type' => 'throbber', 'message' => t('Clearing tags')),
                     'wrapper' => 'status-div',
            )
   );

   $form['reset_counts_button'] = array(
            '#type' => 'button',
            '#value' => t('Reset All Download Counts'),
            '#ajax' => array(
                     'callback' => 'downloadable_file_admin_ajax_handler',
                     'method' => 'replace',
                     'effect' => 'fade',
                     'progress' => array('type' => 'throbber', 'message' => t('Resetting counts')),
                     'wrapper' => 'status-div',
            )
   );

   $form['view_rankings_button'] = array(
            '#type' => 'button',
            '#value' => t('View Top 10 Files for Species'),
            '#ajax' => array(
                     'callback' => 'downloadable_file_admin_ajax_handler',
                     'method' => 'replace',
                     'effect' => 'fade',
                     'progress' => array('type' => 'throbber', 'message' => t('Fetching rankings')),
                     'wrapper' => 'status-div',
            )
   );

  $form['fix_munged_filenames'] = array(
            '#type' => 'button',
            '#value' => t('Fix munged filenames'),
            '#ajax' => array(
                     'callback' => 'downloadable_file_admin_ajax_handler',
                     'method' => 'replace',
                     'effect' => 'fade',
                     'progress' => array('type' => 'throbber', 'message' => t('Fixing munged filenames')),
                     'wrapper' => 'status-div',
            )
   );



   return $form;
}


/** 
* Worker function called by all "button-driven" actions from the Administration
* page.
* 
* At the end of each action, they return (or should return) feedback via the 
* $form['status_area']['#description'] field.
*
* @param string[] $form Array defining the structure of the Admin page. This
* variable contains the status area which gets updated by each action.
* @param string[] $form_state Contains state information about the form's
* components, like which button is currently clicked.
*
* @return string[] Status area component in the Admin  page
*/
function downloadable_file_admin_ajax_handler($form, $form_state) {

	switch ($form_state['clicked_button']['#value']) {

		case 'Reset All Download Counts':
			$query = new EntityFieldQuery();
			$query->entityCondition('entity_type', 'node');
			$query->propertyCondition('type', 'downloadable_file');
			$result = $query->execute();
			$errors = array();
			if(isset($result['node'])) {
				$filesReset = 0;
				$file_nids = array_keys($result['node']);
				$files = entity_load('node', $file_nids);
				foreach($files as $file) {
					$file->field_download_count = array('und' => array(0 => array('value' => '0')));
					try {
						node_save($file);
						$filesReset++;
					} catch (Exception $e) {
						array_push($errors, 'Error trying to reset dl file ' . $file->title . " count: $e\n");
					}
				}
				array_push($errors, "Sucessfully reset $filesReset out of " . count($files) . " file download counts\n");
			}
			$form['status_area']['#description'] = implode(',', $errors);
			break;

		case 'Clear \'Featured Download\' Tags':
			$query = new EntityFieldQuery();
			$query->entityCondition('entity_type', 'node');
			$query->propertyCondition('type', 'downloadable_file');
			$result = $query->execute();
			$tagsReset = 0;
			$totalTagsToReset = 0;
			$errors = array();
			if(isset($result['node'])) {
				$file_nids = array_keys($result['node']);
				$files = entity_load('node', $file_nids);
				$featTid = key(taxonomy_get_term_by_name(FEATURED_DOWNLOAD_TAG_TEXT));
				foreach($files as $file) {
					if(!empty($file->field_tags[$file->language])) {
						for($eye = 0; $eye <= count($file->field_tags[$file->language]); $eye++) {
							if($file->field_tags[$file->language][$eye]['tid'] == $featTid) {
								$totalTagsToReset++;
								unset($file->field_tags[$file->language][$eye]);
								try {
									node_save($file);
									$tagsReset++;
								} catch (Exception $e) {
									array_push($errors, "Error trying to reset dl file " . $file->title . " count: $e\n");
								}
							}
						}
					}
				}
			}
			array_push($errors, "Sucessfully reset $tagsReset out of $totalTagsToReset files that were taged as 'featured'\n");
			$form['status_area']['#description'] = implode(',', $errors);
			break;

		case 'View Top 10 Files for Species':
			$featuredTag = taxonomy_get_term_by_name(FEATURED_DOWNLOAD_TAG_TEXT);
			$orgTids = getUniqueListOrgTidsFromDownloads();
			$markup = array();
			foreach($orgTids as $orgTid) {
				$org = taxonomy_term_load($orgTid);	
				$orgMaxHeap = getSortedFiles($org->tid, key($featuredTag), null);
				if(!$orgMaxHeap->isEmpty()) {
					$orgMaxHeap->top();
					$summary = '<ol><lh>' . $org->name . '</lh>';
					$top10Counter = 0;
					while($orgMaxHeap->valid() && $top10Counter < 10) {
						$file = $orgMaxHeap->current();
						$summary .= '<li><a href="/node/';
						$summary .= $file->nid;
						$summary .= '">';
						$summary .= $file->title;
						$featured = empty($file->field_tags_tid) ? '<font color="red">Not Featured</font>' : '<font color="green">Featured</font>';
						$c = $file->field_download_count_value;
						$fileSize = getFileSizeHumanReadable($file->filesize);
						$summary .= " $fileSize | $featured | <font color=\"dark green\"><b>$c</b></font>";
						$summary .= '</a></li>';
						$orgMaxHeap->next();
						$top10Counter++;
					}
					$summary .= '</ol>';
					array_push($markup, $summary);
				}
			}
			$form['status_area']['#description'] = implode('<br>', $markup);
			break;

		case 'Convert Names':
			convertNames();
			$form['status_area']['#description'] = 'Converting names finished!';
			break;

		case 'Fix munged filenames':
			$form['status_area']['#description'] = fixMungedFilenames();
			break;
	}

	return $form['status_area'];
}

/**
* Builder method for the html to be displayed in the "Related files" block.
*
* @param string $delta Contextual information to check for to make sure this builds the html
* at the right time in the right place.
* 
* @return string[] Markup array consisting of html.
*/
function downloadable_file_block_contents($delta) {

	switch($delta) {

		case 'downloadsForOrganism':

			// First grab the tag taxonomy node
			$downloadPriorityTag = taxonomy_get_term_by_name(FEATURED_DOWNLOAD_TAG_TEXT);

			$fileNames = '';

			$curNode = menu_get_object('node'); 

			if(isset($curNode)) {

				$results = array();
				$fileMaxHeap = getSortedFiles($curNode->field_organism_taxonomy[$curNode->language][0]['tid'], key($downloadPriorityTag), NULL);
				if(!$fileMaxHeap->isEmpty()) {
					$fileNames = '<ul>';
					$i = 0;
					foreach($fileMaxHeap as $file) {
						$i++;
						if($i>RELATED_FILES_VIEW_LIMIT) {
							$url = url('downloads', array('query' => array(
											'field_organism_taxonomy_tid' => $curNode->field_organism_taxonomy[$curNode->language][0]['tid'],
											'field_status_value' => 'Current')));
							$fileNames .= '<li><a href="';
							$fileNames .= $url;
							$fileNames .= '">More...</a></li>';
							break;
						}
						$q = db_select('url_alias', 'a');
						$q->addField('a', 'alias');
						$q->condition('a.source', "node/{$file->nid}", '=');
						$results = $q->execute()->fetchAssoc();
						$url_download = '';
						$url_alias = '';
						if($results !== FALSE) {
							$url_alias = $results['alias'];
							$url_download = str_replace('content', 'download', $results['alias']);
						}
						$fileSize = getFileSizeHumanReadable($file->filesize);
						$fileNames .= "<li><a href=\"/$url_alias\">{$file->title}</a> | ";
						$fileNames .= "<a href=\"/$url_download\">Download ($fileSize)</a></li>";
					}
					$fileNames .= '</ul>';
					return array('#markup' => $fileNames);
				}
			}
			break;
	}
	return null;

}


