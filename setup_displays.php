<?php

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;

$entity_type = 'node';
$bundle = 'page';

/**
 * Configure Form Display
 */
$form_display = EntityFormDisplay::load("$entity_type.$bundle.default");
if (!$form_display) {
  $form_display = EntityFormDisplay::create([
    'targetEntityType' => $entity_type,
    'bundle' => $bundle,
    'mode' => 'default',
    'status' => TRUE,
  ]);
}

// Set Webform to use select widget
$form_display->setComponent('field_webform', [
  'type' => 'options_select',
  'weight' => 5,
]);

// Set Components to use paragraphs widget
$form_display->setComponent('field_components', [
  'type' => 'paragraphs',
  'weight' => 6,
  'settings' => [
    'title' => 'Component',
    'title_plural' => 'Components',
    'edit_mode' => 'closed',
    'add_mode' => 'dropdown',
    'form_display_mode' => 'default',
    'default_paragraph_type' => '',
  ],
]);

$form_display->save();
echo "Form display updated for $bundle.\n";

/**
 * Configure View Display
 */
$view_display = EntityViewDisplay::load("$entity_type.$bundle.default");
if (!$view_display) {
  $view_display = EntityViewDisplay::create([
    'targetEntityType' => $entity_type,
    'bundle' => $bundle,
    'mode' => 'default',
    'status' => TRUE,
  ]);
}

$view_display->setComponent('field_webform', [
  'type' => 'webform_entity_reference_entity_view',
  'weight' => 5,
  'label' => 'hidden',
]);

$view_display->setComponent('field_components', [
  'type' => 'entity_reference_revisions_entity_view',
  'weight' => 6,
  'label' => 'hidden',
]);

$view_display->save();
echo "View display updated for $bundle.\n";
