<?php

/**
 * Settings form callback.
 * @ingroup forms 
 */
function taxonomy_subterms_admin_settings() {
  $form = array();

  
  $form['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    );
 
  $form['general']['taxonomy_subterms_subterms_map_position'] = array(
    '#type' => 'select',
    '#title' => t('Subterms map position'),
    '#options' => array('before' => t('Before'), 'after' => t('After')),
    '#default_value' => variable_get('taxonomy_subterms_subterms_map_position', 'before'),
    '#description' => t('Position of the subterms map relative to nodes list.'),
    );

  $form['general']['taxonomy_subterms_subterms_map_description'] = array(
    '#type' => 'select',
    '#title' => t('Display term description'),
    '#options' => array('yes' => t('Yes'), 'no' => t('No')),
    '#default_value' => variable_get('taxonomy_subterms_subterms_map_description', 'no'),
    '#description' => t('Display terms description in the subterms map.'),
    );
    
  return system_settings_form($form);
}
