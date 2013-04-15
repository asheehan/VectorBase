<?php
/**
 * Renders attached node in teaser mode.
 *
 * This module is shipped with a minimal node template.
 */
function _attach_node_process($params) {
  if (($node = node_load((int) $params['nid'])) && ($node->status)) {
    $params['default_title'] = empty($params['title']) ? $node->title : $params['title'];

    if ($params['simple']) {
      return '<span class="attach-node-' . $node->type . '">' . l($params['default_title'], 'node/' . $node->nid) . '</span>';
    }
    else {
      $node->attach = $params;
      return render(node_view($node, 'attach'));
    }
  }
}

/**
 * Renders node in AJAX mode.
 *
 * Useful when there is non-cacheable content in attached node, like a form
 * (poll nodes).
 */
function attach_node_ajax_render($node) {
  print render(node_view($node, 'attach_ajax'));
}
