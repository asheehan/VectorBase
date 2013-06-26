<?php

//drupal_add_css('/includes/index_style.css',array('type'=>'file','group'=>'CSS_THEME'));


?>
<!--
-->
<link rel="stylesheet" href="/includes/index_style.css">
<!--
<link rel="stylesheet" href="/includes/vb-tools.css">
-->

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <span class="submitted"><?php print $submitted ?></span>
  <?php endif; ?>

  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.

error_reporting(E_ERROR | E_WARNING | E_PARSE);
//var_dump($_GET);

if($_GET['result']=='html_results')
  include('/vectorbase/web/root/sections/Tools/tool_includes/BLAST/html_results.php');
else
  include('/vectorbase/web/root/sections/Tools/tool_includes/BLAST/input.php');

 ?>
  </div>

  <div class="clearfix">
    <?php if (!empty($content['links'])): ?>
      <div class="links"><?php print render($content['links']); ?></div>
    <?php endif; ?>

    <?php print render($content['comments']); ?>
  </div>

</div>
