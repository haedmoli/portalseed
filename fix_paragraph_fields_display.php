<?php

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;

$paragraphs = [
  'contact_card' => ['field_icon_class', 'field_title', 'field_subtitle', 'field_link'],
  'contact_details' => ['field_cards'],
  'brand_carousel' => ['field_heading', 'field_description', 'field_logos'],
  'tab_item' => ['field_title', 'field_icon_class', 'field_description', 'field_features', 'field_link'],
  'services_tabs' => ['field_heading', 'field_description', 'field_tabs'],
];

foreach ($paragraphs as $bundle => $fields) {
  // Configurar Form Display
  $form_display = EntityFormDisplay::load("paragraph.$bundle.default");
  if (!$form_display) {
    $form_display = EntityFormDisplay::create([
      'targetEntityType' => 'paragraph',
      'bundle' => $bundle,
      'mode' => 'default',
      'status' => TRUE,
    ]);
  }

  // Configurar View Display
  $view_display = EntityViewDisplay::load("paragraph.$bundle.default");
  if (!$view_display) {
    $view_display = EntityViewDisplay::create([
      'targetEntityType' => 'paragraph',
      'bundle' => $bundle,
      'mode' => 'default',
      'status' => TRUE,
    ]);
  }

  $weight = 0;
  foreach ($fields as $field_name) {
    // Determinar el widget del formulario basado en el nombre del campo o tipo aproximado
    $widget_type = 'string_textfield';
    $view_type = 'string';

    if (strpos($field_name, 'description') !== false || strpos($field_name, 'subtitle') !== false) {
      $widget_type = 'text_textarea';
      $view_type = 'text_default';
    } elseif (strpos($field_name, 'link') !== false) {
      $widget_type = 'link_default';
      $view_type = 'link';
    } elseif ($field_name === 'field_logos') {
      $widget_type = 'image_image';
      $view_type = 'image';
    } elseif ($field_name === 'field_cards' || $field_name === 'field_tabs') {
      $widget_type = 'paragraphs';
      $view_type = 'entity_reference_revisions_entity_view';
    }

    // Activar en el formulario
    $form_display->setComponent($field_name, [
      'type' => $widget_type,
      'weight' => $weight,
    ]);

    // Activar en la vista
    $view_display->setComponent($field_name, [
      'type' => $view_type,
      'weight' => $weight,
      'label' => 'hidden',
    ]);

    $weight++;
  }

  $form_display->save();
  $view_display->save();
  echo "Displays updated for paragraph: $bundle\n";
}
