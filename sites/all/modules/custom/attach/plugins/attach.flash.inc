<?php
/**
 * Renders attached view.
 *
 */
function attach_flash_process($params) {
  if ($view = views_embed_view($params['viewname'],$params['display'])) {
    return render($view);
  }
}
