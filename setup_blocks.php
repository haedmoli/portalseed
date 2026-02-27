<?php

use Drupal\block\Entity\Block;

// Map blocks to regions
$blocks = [
  'seed_theme_branding' => [
    'plugin' => 'system_branding_block',
    'region' => 'header',
    'weight' => -10,
    'settings' => [
      'use_site_logo' => TRUE,
      'use_site_name' => FALSE,
      'label_display' => FALSE,
    ]
  ],
  'seed_theme_main_menu' => [
    'plugin' => 'system_menu_block:main',
    'region' => 'primary_menu',
    'weight' => 0,
    'settings' => [
      'label_display' => FALSE,
      'level' => 1,
      'depth' => 2,
    ]
  ],
  'seed_theme_account_menu' => [
    'plugin' => 'system_menu_block:account',
    'region' => 'hidden', // Hide for now or put in footer
    'weight' => 0,
  ],
  'seed_theme_breadcrumbs' => [
    'plugin' => 'system_breadcrumb_block',
    'region' => 'breadcrumb',
    'weight' => 0,
    'settings' => ['label_display' => FALSE],
  ],
  'seed_theme_messages' => [
    'plugin' => 'system_messages_block',
    'region' => 'content',
    'weight' => -10,
    'settings' => ['label_display' => FALSE],
  ],
  'seed_theme_page_title' => [
    'plugin' => 'page_title_block',
    'region' => 'content',
    'weight' => -9,
    'settings' => ['label_display' => FALSE],
  ],
  'seed_theme_content' => [
    'plugin' => 'system_main_block',
    'region' => 'content',
    'weight' => 0,
    'settings' => ['label_display' => FALSE],
  ],
];

foreach ($blocks as $id => $data) {
  $block = Block::load($id);
  if (!$block) {
    if ($data['region'] === 'hidden') continue;
    
    $block = Block::create([
      'id' => $id,
      'theme' => 'seed_theme',
      'plugin' => $data['plugin'],
      'region' => $data['region'],
      'weight' => $data['weight'],
      'settings' => $data['settings'] ?? [],
    ]);
    $block->save();
    echo "Created block: $id in {$data['region']}\n";
  } else {
    $block->setRegion($data['region']);
    $block->setWeight($data['weight']);
    if (isset($data['settings'])) {
      foreach ($data['settings'] as $k => $v) {
        $block->set($k, $v); // settings are nested usually, simplifiction here
      }
    }
    $block->save();
    echo "Updated block: $id in {$data['region']}\n";
  }
}
