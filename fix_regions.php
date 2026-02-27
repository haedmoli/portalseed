<?php

use Drupal\block\Entity\Block;

// Move menu to primary_menu region (template renders it in the center nav slot)
$menu = Block::load('seed_theme_main_menu');
if ($menu) {
  $menu->setRegion('primary_menu');
  $menu->setWeight(0);
  $menu->save();
  echo "Moved main menu to primary_menu\n";
}

// Keep branding, search, language in header region
// But search and language are rendered by template as hardcoded SVG icons now
// So hide them from the Drupal block system to avoid duplication
$search = Block::load('seed_theme_search');
if ($search) {
  $search->setRegion('hidden');
  $search->save();
  echo "Hid search block (using template SVG icon instead)\n";
}

$lang = Block::load('seed_theme_language');
if ($lang) {
  // Keep language in header so page.header has it for the dropdown
  // But we'll render it via page.header in the lang-dropdown div
  $lang->setRegion('header');
  $lang->setWeight(6);
  $lang->save();
  echo "Language block stays in header\n";
}

$branding = Block::load('seed_theme_branding');
if ($branding) {
  $branding->setRegion('header');
  $branding->setWeight(-10);
  $branding->save();
  echo "Branding stays in header\n";
}
