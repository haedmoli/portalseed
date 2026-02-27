<?php

use Drupal\Core\Entity\Entity\EntityViewDisplay;

// 1. Enable 'field_components' on Landing Page
$node_display = EntityViewDisplay::load('node.landing_page.default');
if ($node_display) {
  $node_display->setComponent('field_components', [
    'type' => 'entity_reference_revisions_entity_view',
    'weight' => 0,
    'label' => 'hidden',
    'settings' => [
      'view_mode' => 'default',
    ],
  ]);
  $node_display->save();
  echo "Enabled field_components on Landing Page.\n";
} else {
  echo "Landing Page display not found.\n";
}

// 2. Create/Update 'Hero' Paragraph Display
$hero_display = EntityViewDisplay::load('paragraph.hero.default');
if (!$hero_display) {
  $hero_display = EntityViewDisplay::create([
    'targetEntityType' => 'paragraph',
    'bundle' => 'hero',
    'mode' => 'default',
    'status' => TRUE,
  ]);
}

// Configure fields
$hero_fields = [
  'field_badge' => ['type' => 'string'],
  'field_title' => ['type' => 'text_default'],
  'field_description' => ['type' => 'text_default'],
  'field_link' => ['type' => 'link'],
  'field_image' => ['type' => 'image', 'settings' => ['image_style' => 'wide']], // Using 'wide' style if exists
  'field_stats' => ['type' => 'text_default'],
];

foreach ($hero_fields as $field_name => $options) {
  $hero_display->setComponent($field_name, [
    'type' => $options['type'],
    'label' => 'hidden',
    'settings' => $options['settings'] ?? [],
  ]);
}

$hero_display->save();
echo "Configured Hero Paragraph Display.\n";
