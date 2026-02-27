<?php

use Drupal\block\Entity\Block;

$to_remove = [
  'seed_theme_site_branding',
  'seed_theme_search_form_wide',
  'seed_theme_search_form_narrow',
  'seed_theme_help', // Remove help from header
];

foreach ($to_remove as $id) {
  $block = Block::load($id);
  if ($block) {
    $block->delete();
    echo "Deleted block: $id\n";
  }
}

// Move local tasks to content
$tasks = Block::load('seed_theme_primary_local_tasks');
if ($tasks) {
  $tasks->setRegion('content');
  $tasks->setWeight(-20);
  $tasks->save();
  echo "Moved primary_local_tasks to content\n";
}

$secondary = Block::load('seed_theme_secondary_local_tasks');
if ($secondary) {
  $secondary->setRegion('content');
  $secondary->setWeight(-19);
  $secondary->save();
  echo "Moved secondary_local_tasks to content\n";
}

$actions = Block::load('seed_theme_primary_admin_actions');
if ($actions) {
  $actions->setRegion('content');
  $actions->setWeight(-18);
  $actions->save();
  echo "Moved primary_admin_actions to content\n";
}

// Verify main menu block settings
$menu = Block::load('seed_theme_main_menu');
if ($menu) {
  echo "Main Menu Region: " . $menu->getRegion() . "\n";
}
