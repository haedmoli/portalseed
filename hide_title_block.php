<?php
$theme = \Drupal::config('system.theme')->get('default');
$blocks = \Drupal::entityTypeManager()->getStorage('block')->loadByProperties(['theme' => $theme]);

foreach ($blocks as $id => $block) {
  if (strpos($block->getPluginId(), 'page_title_block') !== false) {
    echo "Found title block: $id\n";
    $visibility = $block->getVisibility();
    
    // Check if we already have some paths, append ours so we don't break existing rules
    $pages = "<front>\n/contacto\n/*/contacto\n/node/5\n/*/node/5";
    
    // We basically override the visibility to negate these pages
    $visibility['request_path'] = [
      'id' => 'request_path',
      'pages' => $pages,
      'negate' => true,
    ];
    
    $block->setVisibilityConfig('request_path', $visibility['request_path']);
    $block->save();
    echo "Visibility updated successfully for $id.\n";
  }
}
