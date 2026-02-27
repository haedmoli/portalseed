<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;

function create_field($entity_type, $bundle, $field_name, $field_type, $label, $cardinality = 1, $settings = []) {
   // Storage check/create
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
      echo "Error creating storage $field_name: " . $e->getMessage() . "\n";
      return;
    }
  }

  // Instance check/create
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
      echo "Error creating instance $field_name: " . $e->getMessage() . "\n";
    }
  } else {
    echo "Field Instance exists: $field_name ($bundle)\n";
  }
}

// --- ECK Project Fields ---
echo "Attempting to create fields for 'project' entity, bundle 'project'...\n";

create_field('project', 'project', 'field_description', 'text_long', 'Description');
create_field('project', 'project', 'field_status', 'list_string', 'Status', 1, [
  'storage' => ['allowed_values' => ['planned' => 'Planned', 'active' => 'Active', 'completed' => 'Completed']]
]);
create_field('project', 'project', 'field_client_ref', 'entity_reference', 'Client', 1, [
  'storage' => ['target_type' => 'node'],
  'field' => ['handler_settings' => ['target_bundles' => ['client' => 'client']]]
]);

// Also add a date field if needed
create_field('project', 'project', 'field_date', 'datetime', 'Date');
