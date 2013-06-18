<?php
$block = module_invoke('github_widget', 'block_view', 1);
print render($block);

