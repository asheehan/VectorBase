<?php

function navigation( $section = '' ){
  return t('Tool Home... section: @section', array('@section' => $section));
}

/*
function navigation_title( $section = '' ){
  drupal_set_title(t('VB Title'));
  return t('VectorBase | @section', array('@section' => $section));
}
*/
