<?php

function acquia_marina_preprocess_node(&$variables) {
	$nodeUrlName = end(explode('/', drupal_get_path_alias("node/{$variables['nid']}")));
	$themePath = drupal_get_path('theme', 'acquia_marina');
	switch($nodeUrlName) {	
		case 'transcriptomes':
			drupal_add_css($themePath . '/css/transcriptomes.css');
			break;
		case 'cytogenetic-map-anopheles-gambiae-connected-pest':
			drupal_add_css($themePath . '/css/cytogenetic-map-imgs.css');
			break;
	}
}

function acquia_marina_preprocess_page(&$vars) {
	// pass module paths to javascript
	drupal_add_js(array('blast' => array('blastPath' => drupal_get_path('module','blast'))), 'setting');
	drupal_add_js(array('clustalw' => array('clustalwPath' => drupal_get_path('module','clustalw'))), 'setting');
	drupal_add_js(array('xgrid' => array('xgridPath' => drupal_get_path('module','xgrid'))), 'setting');
/*
	// this is a nice idea but creates a completely blank page (no header/footer)
	// custom 404 page: use page--404.tpl.php
	$status = drupal_get_http_header("status");  
	if($status == "404 Not Found")
	  $vars['theme_hook_suggestions'][] = 'page__404';
*/

}


function acquia_marina_preprocess_html(&$vars) {
  // set site tiles and background color css for dev, pre, and !www here

  //bender is dev
  if(strstr(gethostname(),"bender")){
    variable_set('site_name', 'Dev.VectorBase');
    drupal_add_css('#site-name a{background-color: rgba(255,0,0,0.4);}', array('group' => CSS_THEME, 'type' => 'inline'));

  //adama is pre
  }else if(strstr(gethostname(),"adama")){
    variable_set('site_name', 'Pre.VectorBase');
    drupal_add_css('#site-name a{background-color: rgba(0,0,255,0.4);}', array('group' => CSS_THEME, 'type' => 'inline'));

  //bella is live. if not bella, show the name of this machine
  }else if($_SERVER['SERVER_NAME']!='www.vectorbase.org' && $_SERVER['SERVER_NAME']!='vectorbase.org' && strstr(gethostname(),"bella") ){
   $newName=strstr($_SERVER['SERVER_NAME'],'.',TRUE);
    variable_set('site_name', ucfirst($newName).'.VectorBase');
    drupal_add_css('#site-name a{background-color: rgba(0,255,0,0.4);}', array('group' => CSS_THEME, 'type' => 'inline'));
  }

  if($vars['head_title_array']['title'] === 'Anopheles gambiae') {
	drupal_add_css(drupal_get_path('theme', 'acquia_marina') . '/css/cytogenetic-map-imgs.css');	
  }


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
