<?php

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

// 1. Delete all main menu links and recreate cleanly
$links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['menu_name' => 'main']);
foreach ($links as $link) {
  $link->delete();
}
echo "Deleted all main menu links.\n";

// 2. Create a "Por qué Seed EM" basic page so it has its own URL
$existing = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['title' => 'Por qué Seed EM']);
if (!$existing) {
  $page = Node::create([
    'type' => 'page',
    'title' => 'Por qué Seed EM',
    'status' => 1,
  ]);
  $page->save();
  $pq_nid = $page->id();
  echo "Created 'Por qué Seed EM' page: node/$pq_nid\n";
} else {
  $page = reset($existing);
  $pq_nid = $page->id();
  echo "Existing 'Por qué Seed EM' page: node/$pq_nid\n";
}

// 3. Recreate menu links with correct URIs
$new_links = [
  ['title' => 'Inicio',           'uri' => 'internal:/'],
  ['title' => 'Por qué Seed EM',  'uri' => 'internal:/node/' . $pq_nid],
  ['title' => 'Servicios',        'uri' => 'internal:/services'],
  ['title' => 'Nuestros clientes','uri' => 'internal:/clients'],
  ['title' => 'Casos de éxito',   'uri' => 'internal:/case-studies'],
  ['title' => 'Insights',         'uri' => 'internal:/insights'],
  ['title' => 'Ofertas de empleo','uri' => 'internal:/careers'],
  ['title' => 'Contacto',         'uri' => 'internal:/contact'],
];

$weight = 0;
foreach ($new_links as $item) {
  MenuLinkContent::create([
    'title' => $item['title'],
    'link' => ['uri' => $item['uri']],
    'menu_name' => 'main',
    'weight' => $weight++,
    'expanded' => FALSE,
  ])->save();
  echo "Created: {$item['title']}\n";
}
