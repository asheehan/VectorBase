<?php

function home( $section = '' ){
  return t('Home... args: @section', array('@section' => $section));
}

/*
function navigation_title( $section = '' ){
  drupal_set_title(t('VB Title'));
  return t('VectorBase | @section', array('@section' => $section));
}
*/
