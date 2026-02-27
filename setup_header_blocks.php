<?php

use Drupal\block\Entity\Block;

// Blocks to add
$blocks = [
  'seed_theme_search' => [
    'plugin' => 'search_form_block',
    'region' => 'header',
    'weight' => 5, // After menu
    'settings' => ['label_display' => FALSE],
  ],
  'seed_theme_language' => [
    'plugin' => 'language_block:language_interface',
    'region' => 'header',
    'weight' => 6, // After search
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
    // Force region update
    $block->setRegion($data['region']);
    $block->setWeight($data['weight']);
    $block->save();
    echo "Updated block: $id in {$data['region']}\n";
  }
}
