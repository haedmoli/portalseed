<?php

$theme = 'seed_theme';
$regions = ['header', 'primary_menu', 'content'];

$storage = \Drupal::entityTypeManager()->getStorage('block');
$blocks = $storage->loadByProperties(['theme' => $theme]);

foreach ($regions as $region) {
  echo "--- Region: $region ---\n";
  foreach ($blocks as $block) {
    if ($block->getRegion() === $region && $block->status()) {
      echo $block->id() . " (Plugin: " . $block->getPluginId() . ", Weight: " . $block->getWeight() . ")\n";
    }
  }
}
