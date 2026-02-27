<?php

use Drupal\eck\Entity\EckEntityType;
use Drupal\eck\Entity\EckEntityBundle;

// 1. Create Entity Type 'project'
$entity_type_id = 'project';
$entity_type_label = 'Project';

$entity_type = EckEntityType::load($entity_type_id);
if (!$entity_type) {
  $entity_type = EckEntityType::create([
    'id' => $entity_type_id,
    'label' => $entity_type_label,
    'created' => TRUE,
    'changed' => TRUE,
    'title' => TRUE,
    'uid' => TRUE,
  ]);
  $entity_type->save();
  echo "Created ECK Entity Type: $entity_type_label ($entity_type_id)\n";
} else {
  echo "ECK Entity Type exists: $entity_type_label ($entity_type_id)\n";
}

// 2. Create Bundle 'project'
$bundle_id = 'project';
$bundle_label = 'Project';

$bundle = EckEntityBundle::load($entity_type_id . '.' . $bundle_id);
if (!$bundle) {
  $bundle = EckEntityBundle::create([
    'type' => $bundle_id,
    'name' => $bundle_label,
    'entity_type' => $entity_type_id,
  ]);
  $bundle->save();
  echo "Created ECK Bundle: $bundle_label ($bundle_id)\n";
} else {
  echo "ECK Bundle exists: $bundle_label ($bundle_id)\n";
}
