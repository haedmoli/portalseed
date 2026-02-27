<?php

use Drupal\Core\Entity\Entity\EntityFormDisplay;

$entity_type = 'node';
$bundle = 'page';

$form_display = EntityFormDisplay::load("$entity_type.$bundle.default");
if ($form_display) {
  $form_display->setComponent('field_components', [
    'type' => 'paragraphs',
    'weight' => 6,
    'settings' => [
      'title' => 'Component',
      'title_plural' => 'Components',
      'edit_mode' => 'open', // CHANGED from 'closed' to 'open'
      'add_mode' => 'dropdown',
      'form_display_mode' => 'default',
      'default_paragraph_type' => '',
    ],
  ]);
  $form_display->save();
  echo "Form display updated: 'edit_mode' set to 'open'.\n";
} else {
  echo "Form display not found.\n";
}
