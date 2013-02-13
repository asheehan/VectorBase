<?php

function acquia_marina_preprocess_page(&$vars) {

//	drupal_add_css('/includes/index_style.css',array('type'=>'file','group'=>'CSS_THEME'));

	// pass the module path to javascript
	drupal_add_js(array('blast' => array('blastPath' => drupal_get_path('module','blast'))), 'setting');
	drupal_add_js(array('clustalw' => array('clustalwPath' => drupal_get_path('module','clustalw'))), 'setting');
	drupal_add_js(array('xgrid' => array('xgridPath' => drupal_get_path('module','xgrid'))), 'setting');

//drupal_add_js(drupal_get_path('theme','acquia_marina').'/tablesorter/jquery.tablesorter.js');


}

function acquia_marina_link($variables) {
  /*$menuObject = FALSE;
  $menuObject = menu_get_object();
if ($menuObject && property_exists($menuObject,'type') && ($menuObject->type == 'navigation_page')) {
  $variables['options']['html'] = FALSE;
} else {
  $variables['options']['html'] = TRUE;
}*/
  $variables['options']['html'] = TRUE;
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : strip_tags($variables['text'])) . '</a>';
}
