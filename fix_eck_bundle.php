<?php

use Drupal\eck\Entity\EckEntityBundle;

try {
  // Check if we can load the storage for the bundle type
  // The bundle entity type ID is [entity_type]_type. So for 'project', it is 'project_type'.
  $storage = \Drupal::entityTypeManager()->getStorage('project_type');
  
  $bundle = $storage->load('project');
  if ($bundle) {
    echo "Bundle 'project' loaded successfully. Label: " . $bundle->label() . "\n";
    $bundle->save();
    echo "Saved bundle 'project' to ensure registration.\n";
  } else {
    echo "Bundle 'project' NOT found via storage load.\n";
    // Try creating it using the class directly if storage create is tricky without exact keys
    // But storage->create is best.
    // keys for EckEntityBundle: type (id), name (label), entity_type
    $bundle = $storage->create([
      'type' => 'project',
      'name' => 'Project',
      'entity_type' => 'project',
    ]);
    $bundle->save();
    echo "Created bundle 'project'.\n";
  }
} catch (\Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
}
