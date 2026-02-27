<?php

use Drupal\menu_link_content\Entity\MenuLinkContent;

$links = [
  'Inicio' => 'internal:/', // Front page
  'Por qué Seed EM' => 'internal:/node/1', // Placeholder
  'Servicios' => 'internal:/services',
  'Nuestros clientes' => 'internal:/clients',
  'Casos de éxito' => 'internal:/case-studies',
  'Insights' => 'internal:/insights',
  'Ofertas de empleo' => 'internal:/careers',
  'Contacto' => 'internal:/contact',
];

$weight = 0;
foreach ($links as $title => $uri) {
  // Check if link exists
  $existing = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties([
    'title' => $title,
    'menu_name' => 'main'
  ]);

  if (!$existing) {
    MenuLinkContent::create([
      'title' => $title,
      'link' => ['uri' => $uri],
      'menu_name' => 'main',
      'weight' => $weight++,
      'expanded' => TRUE,
    ])->save();
    echo "Created menu link: $title\n";
  } else {
    echo "Menu link exists: $title\n";
  }
}
