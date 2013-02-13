<?php
function ds_dsth_test2() {
  return array(
    'label' => t('dsth test2'),
    'regions' => array(
      'left' => t('Left'),
      'right' => t('Right'),
      'header' => t('Header'),
      'footer' => t('Footer'),
    ),
    // Add this line if there is a default css file.
    'css' => TRUE,
  );
}
?>
