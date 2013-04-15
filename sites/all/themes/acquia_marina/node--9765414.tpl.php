<?php
//drupal_add_js(drupal_get_path('module', 'blast'). '/blast.js');
//drupal_add_js(drupal_get_path('module', 'blast'). '/tablesorter/jquery.tablesorter.js');
print "<span id=\"blast-compatibility-banner\">Due to browser compatibility problems in Safari, we recommend using <span id=\"recommended-browsers\">Firefox</span> or <span id=\"recommended-browsers\">Google Chrome</span> when using blast. We are working on these issues and apologize for any inconvenience this may cause you.</span>";
$block = module_invoke('blast', 'block_view', 1);
print render($block);
?>
