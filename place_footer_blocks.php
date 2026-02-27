<?php

use Drupal\block\Entity\Block;

// 1. Social Block
$block = Block::load('seed_theme_footer_social');
if (!$block) {
  $block = Block::create([
    'id' => 'seed_theme_footer_social',
    'plugin' => 'block_content:88888888-1111-1111-1111-111111111111',
    'theme' => 'seed_theme',
    'region' => 'footer_first',
    'provider' => 'block_content',
    'settings' => [
      'id' => 'block_content:88888888-1111-1111-1111-111111111111',
      'label' => 'Footer Social Links',
      'label_display' => '0',
      'provider' => 'block_content',
      'view_mode' => 'full',
    ],
    'weight' => 0,
    'visibility' => [],
  ]);
  $block->save();
  echo "Placed Social Block\n";
}

// 2. Contact Block
$block = Block::load('seed_theme_footer_contact');
if (!$block) {
  $block = Block::create([
    'id' => 'seed_theme_footer_contact',
    'plugin' => 'block_content:88888888-2222-2222-2222-222222222222',
    'theme' => 'seed_theme',
    'region' => 'footer_second',
    'provider' => 'block_content',
    'settings' => [
      'id' => 'block_content:88888888-2222-2222-2222-222222222222',
      'label' => 'Footer Contact Info',
      'label_display' => '0',
      'provider' => 'block_content',
      'view_mode' => 'full',
    ],
    'weight' => 0,
    'visibility' => [],
  ]);
  $block->save();
  echo "Placed Contact Block\n";
}

// 3. Menu Block
$block = Block::load('seed_theme_footer_menu');
if (!$block) {
  $block = Block::create([
    'id' => 'seed_theme_footer_menu',
    'plugin' => 'system_menu_block:footer',
    'theme' => 'seed_theme',
    'region' => 'footer_third',
    'provider' => 'system',
    'settings' => [
      'id' => 'system_menu_block:footer',
      'label' => 'Información',
      'label_display' => 'visible',
      'provider' => 'system',
      'level' => 1,
      'depth' => 0,
      'expand_all_items' => FALSE,
    ],
    'weight' => 0,
    'visibility' => [],
  ]);
  $block->save();
  echo "Placed Menu Block\n";
}

// 4. CTA Block
$block = Block::load('seed_theme_footer_cta');
if (!$block) {
  $block = Block::create([
    'id' => 'seed_theme_footer_cta',
    'plugin' => 'block_content:88888888-4444-4444-4444-444444444444',
    'theme' => 'seed_theme',
    'region' => 'footer_fourth',
    'provider' => 'block_content',
    'settings' => [
      'id' => 'block_content:88888888-4444-4444-4444-444444444444',
      'label' => 'Unete a Seed',
      'label_display' => '0',
      'provider' => 'block_content',
      'view_mode' => 'full',
    ],
    'weight' => 0,
    'visibility' => [],
  ]);
  $block->save();
  echo "Placed CTA Block\n";
}
