<?php

use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

// Load the node. Based on the screenshot it's node/5.
$node = Node::load(5);

if (!$node) {
  // If node 5 doesn't exist, try loading by title
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['title' => 'Contacto', 'type' => 'page']);
  $node = reset($nodes);
}

if (!$node) {
  echo "Node not found. Please create a basic page named 'Contacto' first.\n";
  return;
}

// 1. Attach the Webform
$node->set('field_webform', [
  'target_id' => 'contacto_principal',
]);

// Helper to create paragraph and return the item format for entity_reference_revisions
function create_p($bundle, $fields = []) {
  $p = Paragraph::create(['type' => $bundle]);
  foreach ($fields as $field_name => $value) {
    $p->set($field_name, $value);
  }
  $p->save();
  return [
    'target_id' => $p->id(),
    'target_revision_id' => $p->getRevisionId(),
  ];
}

// 2. Create Contact Details Paragraphs
$card1 = create_p('contact_card', [
  'field_icon_class' => 'ph-map-pin',
  'field_title' => 'Dirección',
  'field_subtitle' => "Calle 150 No. 21A-14, P2\nBogotá, Colombia",
]);
$card2 = create_p('contact_card', [
  'field_icon_class' => 'ph-map-pin',
  'field_title' => 'Oficina Miami',
  'field_subtitle' => "4555 W Hillsboro Blvd Suite B3\nCoconut Creek, FL 33073",
]);
$card3 = create_p('contact_card', [
  'field_icon_class' => 'ph-phone',
  'field_title' => 'Teléfono',
  'field_subtitle' => '(+57) 3118608152',
]);
$card4 = create_p('contact_card', [
  'field_icon_class' => 'ph-envelope-simple',
  'field_title' => 'Correo electrónico',
  'field_subtitle' => 'info@seedem.co',
]);
$card5 = create_p('contact_card', [
  'field_icon_class' => 'ph-headset',
  'field_title' => 'Soporte',
  'field_subtitle' => 'Centro de soporte',
]);

$contact_details = create_p('contact_details', [
  'field_cards' => [$card1, $card2, $card3, $card4, $card5]
]);

// 3. Create Brand Carousel
// Note: Logos would ideally be File entities. Without files, the carousel will render empty.
// We'll leave the image field empty for now unless there are images in the system.
$brand_carousel = create_p('brand_carousel', [
  'field_heading' => 'Marcas y alianzas que respaldan nuestra experiencia',
  'field_description' => [
    'value' => 'Trabajamos junto a empresas líderes y comunidades tecnológicas que confían en nuestra capacidad y trayectoria.',
    'format' => 'full_html',
  ],
]);

// 4. Create Services Tabs
$tab1 = create_p('tab_item', [
  'field_title' => 'Desarrollo Drupal',
  'field_icon_class' => 'ph-code',
  'field_description' => [
     'value' => 'Garantizamos el óptimo funcionamiento de tus plataformas',
     'format' => 'full_html',
  ],
  'field_features' => ['Monitoreo 24/7', 'Actualizaciones de seguridad', 'Backup automático', 'SLA garantizado'],
  'field_link' => ['uri' => 'internal:/', 'title' => 'Conoce más sobre Mantenimiento y Soporte'], // Dummy link
]);

$tab2 = create_p('tab_item', [
  'field_title' => 'Hosting especializado',
  'field_icon_class' => 'ph-hard-drives',
  'field_description' => ['value' => 'Infraestructura robusta y escalable para tus proyectos.', 'format' => 'full_html'],
]);

$tab3 = create_p('tab_item', [
  'field_title' => 'Mantenimiento y Soporte',
  'field_icon_class' => 'ph-users-three',
  'field_description' => ['value' => 'Tu equipo de soporte siempre disponible.', 'format' => 'full_html'],
]);

$services_tabs = create_p('services_tabs', [
  'field_description' => [
    'value' => 'Soluciones integrales de desarrollo, hosting y soporte Drupal para impulsar tu transformación digital con resultados medibles',
    'format' => 'full_html',
  ],
  'field_tabs' => [$tab1, $tab2, $tab3],
]);


// Attach all paragraphs to the node
$node->set('field_components', [
  $contact_details,
  $brand_carousel,
  $services_tabs
]);

$node->save();

echo "Node " . $node->id() . " successfully populated with Webform and Paragraphs.\n";
