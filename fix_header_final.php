<?php

use Drupal\block\Entity\Block;
use Drupal\menu_link_content\Entity\MenuLinkContent;

// 1. Move language block OUT of header — disable it entirely
//    (we use hardcoded links in the template dropdown instead)
$lang = Block::load('seed_theme_language');
if ($lang) {
  $lang->setRegion('hidden');
  $lang->save();
  echo "Language block hidden (using template dropdown instead)\n";
}

// 2. Fix duplicate Inicio — delete all and recreate cleanly
$links = \Drupal::entityTypeManager()->getStorage('menu_link_content')
  ->loadByProperties(['menu_name' => 'main']);
foreach ($links as $link) {
  $link->delete();
}
echo "Deleted all main menu links\n";

// Get the Por qué Seed EM node ID
$pq_nodes = \Drupal::entityTypeManager()->getStorage('node')
  ->loadByProperties(['title' => 'Por qué Seed EM']);
$pq_nid = $pq_nodes ? reset($pq_nodes)->id() : 2;

$items = [
  ['title' => 'Inicio',            'uri' => 'internal:/'],
  ['title' => 'Por qué Seed EM',   'uri' => 'internal:/node/' . $pq_nid],
  ['title' => 'Servicios',         'uri' => 'internal:/servicios'],
  ['title' => 'Nuestros clientes', 'uri' => 'internal:/nuestros-clientes'],
  ['title' => 'Casos de éxito',    'uri' => 'internal:/casos-de-exito'],
  ['title' => 'Insights',          'uri' => 'internal:/insights'],
  ['title' => 'Ofertas de empleo', 'uri' => 'internal:/ofertas-empleo'],
  ['title' => 'Contacto',          'uri' => 'internal:/contacto'],
];

$weight = 0;
foreach ($items as $item) {
  MenuLinkContent::create([
    'title'     => $item['title'],
    'link'      => ['uri' => $item['uri']],
    'menu_name' => 'main',
    'weight'    => $weight++,
    'expanded'  => FALSE,
  ])->save();
  echo "Created: {$item['title']}\n";
}

// 3. Verify logo config
$logo_path = \Drupal::config('seed_theme.settings')->get('logo.path');
echo "Current logo path in config: " . ($logo_path ?: '(not set)') . "\n";
echo "Logo file exists: " . (file_exists(DRUPAL_ROOT . '/themes/custom/seed_theme/logo.png') ? 'YES' : 'NO') . "\n";
