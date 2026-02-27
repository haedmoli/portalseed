<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\paragraphs\Entity\ParagraphsType;

function create_paragraph_type($id, $label) {
  $type = ParagraphsType::load($id);
  if (!$type) {
    ParagraphsType::create([
      'id' => $id,
      'label' => $label,
    ])->save();
    echo "Created Paragraph Type: $id\n";
  } else {
    echo "Paragraph Type exists: $id\n";
  }
}

function create_field($entity_type, $bundle, $field_name, $field_type, $label, $cardinality = 1, $settings = []) {
  $storage = FieldStorageConfig::loadByName($entity_type, $field_name);
  if (!$storage) {
    try {
      $storage = FieldStorageConfig::create([
        'field_name' => $field_name,
        'entity_type' => $entity_type,
        'type' => $field_type,
        'cardinality' => $cardinality,
        'settings' => $settings['storage'] ?? [],
      ]);
      $storage->save();
      echo "Created Field Storage: $field_name ($entity_type)\n";
    } catch (\Exception $e) {
      echo "Error creating Field Storage $field_name: " . $e->getMessage() . "\n";
      return;
    }
  }

  $field = FieldConfig::loadByName($entity_type, $bundle, $field_name);
  if (!$field) {
    try {
      $field = FieldConfig::create([
        'field_storage' => $storage,
        'bundle' => $bundle,
        'label' => $label,
        'settings' => $settings['field'] ?? [],
      ]);
      $field->save();
      echo "Created Field Instance: $field_name ($bundle)\n";
    } catch (\Exception $e) {
      echo "Error creating Field Instance $field_name ($bundle): " . $e->getMessage() . "\n";
    }
  } else {
    echo "Field Instance exists: $field_name ($bundle)\n";
  }
}

// 1. Create Paragraph Types
create_paragraph_type('contact_card', 'Contact Card');
create_paragraph_type('contact_details', 'Contact Details');
create_paragraph_type('brand_carousel', 'Brand Carousel');
create_paragraph_type('tab_item', 'Tab Item');
create_paragraph_type('services_tabs', 'Services Tabs');

// 2. Create fields for 'contact_card'
create_field('paragraph', 'contact_card', 'field_icon_class', 'string', 'Icon Class (e.g., ph-map-pin)');
create_field('paragraph', 'contact_card', 'field_title', 'string', 'Title');
create_field('paragraph', 'contact_card', 'field_subtitle', 'string', 'Subtitle');
create_field('paragraph', 'contact_card', 'field_link', 'link', 'Link');

// 3. Create fields for 'contact_details'
create_field('paragraph', 'contact_details', 'field_cards', 'entity_reference_revisions', 'Contact Cards', -1, [
  'storage' => ['target_type' => 'paragraph'],
  'field' => ['handler_settings' => ['target_bundles' => ['contact_card' => 'contact_card']]]
]);

// 4. Create fields for 'brand_carousel'
create_field('paragraph', 'brand_carousel', 'field_heading', 'string', 'Heading');
create_field('paragraph', 'brand_carousel', 'field_description', 'text_long', 'Description');
create_field('paragraph', 'brand_carousel', 'field_logos', 'image', 'Brands Logos', -1);

// 5. Create fields for 'tab_item'
create_field('paragraph', 'tab_item', 'field_title', 'string', 'Tab Title (Left side)');
create_field('paragraph', 'tab_item', 'field_icon_class', 'string', 'Tab Icon Class', 1); // We can reuse field_icon_class already created
create_field('paragraph', 'tab_item', 'field_description', 'text_long', 'Content Description');
create_field('paragraph', 'tab_item', 'field_features', 'string', 'Features List', -1); // bullet points
create_field('paragraph', 'tab_item', 'field_link', 'link', 'Action Link');

// 6. Create fields for 'services_tabs'
create_field('paragraph', 'services_tabs', 'field_heading', 'string', 'Heading');
create_field('paragraph', 'services_tabs', 'field_description', 'text_long', 'Description');
create_field('paragraph', 'services_tabs', 'field_tabs', 'entity_reference_revisions', 'Tabs', -1, [
  'storage' => ['target_type' => 'paragraph'],
  'field' => ['handler_settings' => ['target_bundles' => ['tab_item' => 'tab_item']]]
]);

// 7. Add Webform and Components to Basic Page (node: page)
create_field('node', 'page', 'field_webform', 'webform', 'Contact Form');

// Attempt to use existing field_components if it exists on node already
$components_exists = FieldStorageConfig::loadByName('node', 'field_components');
if (!$components_exists) {
  create_field('node', 'page', 'field_components', 'entity_reference_revisions', 'Components', -1, [
    'storage' => ['target_type' => 'paragraph']
  ]);
} else {
  // Just attach instance to page
  create_field('node', 'page', 'field_components', 'entity_reference_revisions', 'Components', -1, [
    'storage' => ['target_type' => 'paragraph']
  ]);
}

echo "\n--- Done ---\n";
