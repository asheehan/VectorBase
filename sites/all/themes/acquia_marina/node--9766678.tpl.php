<?php
$block = module_invoke('hmmer', 'block_view', 1);
print render($block);
