<?php

/**
 * The admin settings form for CSS Browser Selector.
 */
function css_browser_selector_admin_settings() {
  $form = array();

  $form['settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Settings'),
  );
  $form['settings']['css_browser_selector_use_js'] = array(
    '#type' => 'radios',
    '#title' => t('Use Javascript'),
    '#description' => t('When enabled, the CSS selectors will be
    	injected into the HTML tag after the page loads.
    	<strong>You must use this feature if you intend to cache
    	your pages.</strong>'),
    '#options' => array(
      0 => 'No',
      1 => 'Yes',
    ),
    '#default_value' => variable_get('css_browser_selector_use_js', 0),
  );
  $form['settings']['css_browser_selector_class_variables'] = array(
    '#type' => 'textarea',
    '#title' => t('Class variables'),
    '#description' => t('These are the names of the variables that
    	will contain the browser selectors.  You may print any of these
    	variables in any class tag in your tpl.php files.  Enter one
    	name per line.'),
    '#default_value' => variable_get('css_browser_selector_class_variables', 'classes_array'),
  );

  return system_settings_form($form);
}
