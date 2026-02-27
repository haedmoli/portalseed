<?php

use Drupal\block\Entity\Block;

// The header region has: branding, search, language, main-menu
// We want: branding (left), main-menu (center/flex), search + language (right)
// Move search and language to header with high weight (renders last = right side)
// Move main-menu to header too (instead of primary_menu region)

// First: move main menu to header region so it's in the same flex row
$menu = Block::load('seed_theme_main_menu');
if ($menu) {
  $menu->setRegion('header');
  $menu->setWeight(0); // After branding (-10), before icons (5, 6)
  $menu->save();
  echo "Moved main menu to header, weight 0\n";
}

// Ensure branding is first
$branding = Block::load('seed_theme_branding');
if ($branding) {
  $branding->setRegion('header');
  $branding->setWeight(-10);
  $branding->save();
  echo "Branding weight: -10\n";
}

// Search icon after menu
$search = Block::load('seed_theme_search');
if ($search) {
  $search->setRegion('header');
  $search->setWeight(5);
  $search->save();
  echo "Search weight: 5\n";
}

// Language icon last
$lang = Block::load('seed_theme_language');
if ($lang) {
  $lang->setRegion('header');
  $lang->setWeight(6);
  $lang->save();
  echo "Language weight: 6\n";
}
