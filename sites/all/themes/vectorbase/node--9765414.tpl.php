<?php
//drupal_add_js(drupal_get_path('module', 'blast'). '/blast.js');
drupal_add_js(drupal_get_path('module', 'blast'). '/tablesorter/jquery.tablesorter.js');

$block = module_invoke('blast', 'block_view', 1);
print render($block);
?>
