<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;

function create_field($entity_type, $bundle, $field_name, $field_type, $label, $cardinality = 1, $settings = []) {
  $storage = FieldStorageConfig::loadByName($entity_type, $field_name);
  if (!$storage) {
    $storage = FieldStorageConfig::create([
      'field_name' => $field_name,
      'entity_type' => $entity_type,
      'type' => $field_type,
      'cardinality' => $cardinality,
      'settings' => $settings['storage'] ?? [],
    ]);
    $storage->save();
    echo "Created Field Storage: $field_name ($entity_type)\n";
  }

  $field = FieldConfig::loadByName($entity_type, $bundle, $field_name);
  if (!$field) {
    $field = FieldConfig::create([
      'field_storage' => $storage,
      'bundle' => $bundle,
      'label' => $label,
      'settings' => $settings['field'] ?? [],
    ]);
    $field->save();
    echo "Created Field Instance: $field_name ($bundle)\n";
  } else {
    echo "Field Instance exists: $field_name ($bundle)\n";
  }

  // Assign widget and formatter (simple defaults)
  // This part usually requires EntityDisplayRepository but we'll skip for brevity or add if needed.
}

// --- Paragraph Fields ---
// Hero
create_field('paragraph', 'hero', 'field_heading', 'string', 'Heading');
create_field('paragraph', 'hero', 'field_subtitle', 'string', 'Subtitle');
create_field('paragraph', 'hero', 'field_image', 'image', 'Background Image');
create_field('paragraph', 'hero', 'field_link', 'link', 'CTA Link');

// Text + Image
create_field('paragraph', 'text_image', 'field_text', 'text_long', 'Text');
create_field('paragraph', 'text_image', 'field_image', 'image', 'Image'); // Reusing field_image

// CTA
create_field('paragraph', 'cta', 'field_text', 'string', 'Text'); // Reusing field_text if possible, but distinct types
create_field('paragraph', 'cta', 'field_link', 'link', 'Link');

// Webform Embed
create_field('paragraph', 'webform_embed', 'field_webform', 'webform', 'Webform');


// --- Content Type Fields ---
// Insight
create_field('node', 'insight', 'field_image', 'image', 'Main Image');
create_field('node', 'insight', 'field_article_category', 'entity_reference', 'Category', 1, [
  'storage' => ['target_type' => 'taxonomy_term'],
  'field' => ['handler_settings' => ['target_bundles' => ['article_category' => 'article_category']]]
]);

// Client
create_field('node', 'client', 'field_logo', 'image', 'Logo');
create_field('node', 'client', 'field_website', 'link', 'Website');
create_field('node', 'client', 'field_client_type', 'entity_reference', 'Client Type', 1, [
  'storage' => ['target_type' => 'taxonomy_term'],
  'field' => ['handler_settings' => ['target_bundles' => ['client_type' => 'client_type']]]
]);

// Case Study
create_field('node', 'case_study', 'field_summary', 'text_long', 'Summary');
create_field('node', 'case_study', 'field_project_ref', 'entity_reference', 'Project', 1, [
  'storage' => ['target_type' => 'project'], // ECK entity type
  'field' => ['handler_settings' => ['target_bundles' => ['project' => 'project']]]
]);
create_field('node', 'case_study', 'field_client_ref', 'entity_reference', 'Client', 1, [
  'storage' => ['target_type' => 'node'],
  'field' => ['handler_settings' => ['target_bundles' => ['client' => 'client']]]
]);
create_field('node', 'case_study', 'field_components', 'entity_reference_revisions', 'Components', -1, [
  'storage' => ['target_type' => 'paragraph'],
  'field' => ['handler_settings' => ['target_bundles' => NULL]] // Allow all or restrict
]);

// Landing Page
create_field('node', 'landing_page', 'field_components', 'entity_reference_revisions', 'Components', -1, [
   'storage' => ['target_type' => 'paragraph']
]);

// FAQ
create_field('node', 'faq', 'field_faq_category', 'entity_reference', 'Category', 1, [
  'storage' => ['target_type' => 'taxonomy_term'],
  'field' => ['handler_settings' => ['target_bundles' => ['faq_category' => 'faq_category']]]
]);


// --- ECK Project Fields ---
create_field('project', 'project', 'field_description', 'text_long', 'Description');
create_field('project', 'project', 'field_status', 'list_string', 'Status', 1, [
  'storage' => ['allowed_values' => ['planned' => 'Planned', 'active' => 'Active', 'completed' => 'Completed']]
]);
create_field('project', 'project', 'field_client_ref', 'entity_reference', 'Client', 1, [
  'storage' => ['target_type' => 'node'],
  'field' => ['handler_settings' => ['target_bundles' => ['client' => 'client']]]
]);
