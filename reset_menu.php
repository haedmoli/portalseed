<?php

use Drupal\menu_link_content\Entity\MenuLinkContent;

$links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['menu_name' => 'main']);
foreach ($links as $link) {
  $link->delete();
}
echo "Deleted all main menu links.\n";

// Re-create them once
$new_links = [
  'Inicio' => 'internal:/',
  'Por qué Seed EM' => 'internal:/node/1',
  'Servicios' => 'internal:/services',
  'Nuestros clientes' => 'internal:/clients',
  'Casos de éxito' => 'internal:/case-studies',
  'Insights' => 'internal:/insights',
  'Ofertas de empleo' => 'internal:/careers',
  'Contacto' => 'internal:/contact',
];

$weight = 0;
foreach ($new_links as $title => $uri) {
  MenuLinkContent::create([
    'title' => $title,
    'link' => ['uri' => $uri],
    'menu_name' => 'main',
    'weight' => $weight++,
    'expanded' => TRUE,
  ])->save();
  echo "Created menu link: $title\n";
}
