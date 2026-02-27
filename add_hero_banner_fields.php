<?php

/**
 * Adds banner fields (image + link) to the Hero paragraph type
 * and populates the existing Hero paragraph with the banner data.
 */

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\file\Entity\File;
use Drupal\paragraphs\Entity\Paragraph;

$bundle = 'hero';

// ═══════════════════════════════════════════════════
// 1. ADD field_banner_image (Image)
// ═══════════════════════════════════════════════════
$field_name = 'field_banner_image';
$storage = FieldStorageConfig::loadByName('paragraph', $field_name);
if (!$storage) {
  $storage = FieldStorageConfig::create([
    'field_name' => $field_name,
    'entity_type' => 'paragraph',
    'type' => 'image',
    'settings' => [
      'target_type' => 'file',
    ],
  ]);
  $storage->save();
  echo "✅ Field storage '$field_name' created.\n";
}

$field = FieldConfig::loadByName('paragraph', $bundle, $field_name);
if (!$field) {
  $field = FieldConfig::create([
    'field_storage' => $storage,
    'bundle' => $bundle,
    'label' => 'Banner Image',
    'description' => 'Imagen de banner que se superpone sobre la imagen principal del Hero. Ej: Drupal Certified Partner.',
    'settings' => [
      'file_extensions' => 'png jpg jpeg gif webp svg',
      'alt_field' => TRUE,
      'alt_field_required' => TRUE,
    ],
  ]);
  $field->save();
  echo "✅ Field '$field_name' added to '$bundle'.\n";
}

// ═══════════════════════════════════════════════════
// 2. ADD field_banner_link (Link)
// ═══════════════════════════════════════════════════
$field_name = 'field_banner_link';
$storage = FieldStorageConfig::loadByName('paragraph', $field_name);
if (!$storage) {
  $storage = FieldStorageConfig::create([
    'field_name' => $field_name,
    'entity_type' => 'paragraph',
    'type' => 'link',
    'settings' => [],
  ]);
  $storage->save();
  echo "✅ Field storage '$field_name' created.\n";
}

$field = FieldConfig::loadByName('paragraph', $bundle, $field_name);
if (!$field) {
  $field = FieldConfig::create([
    'field_storage' => $storage,
    'bundle' => $bundle,
    'label' => 'Banner Link',
    'description' => 'URL a la que lleva el banner al hacer clic.',
    'settings' => [
      'link_type' => 16, // External links
      'title' => 0,      // No title needed
    ],
  ]);
  $field->save();
  echo "✅ Field '$field_name' added to '$bundle'.\n";
}

// ═══════════════════════════════════════════════════
// 3. CONFIGURE FORM DISPLAY
// ═══════════════════════════════════════════════════
$form_display = EntityFormDisplay::load("paragraph.$bundle.default");
if ($form_display) {
  $form_display->setComponent('field_banner_image', [
    'type' => 'image_image',
    'weight' => 10,
    'settings' => [
      'preview_image_style' => 'medium',
    ],
  ]);
  $form_display->setComponent('field_banner_link', [
    'type' => 'link_default',
    'weight' => 11,
  ]);
  $form_display->save();
  echo "✅ Form display updated.\n";
}

// ═══════════════════════════════════════════════════
// 4. CONFIGURE VIEW DISPLAY
// ═══════════════════════════════════════════════════
$view_display = EntityViewDisplay::load("paragraph.$bundle.default");
if ($view_display) {
  $view_display->setComponent('field_banner_image', [
    'type' => 'image',
    'label' => 'hidden',
    'weight' => 10,
    'settings' => [
      'image_style' => '',
      'image_link' => '',
    ],
  ]);
  // Banner link is handled in template, hide from default rendering
  $view_display->removeComponent('field_banner_link');
  $view_display->save();
  echo "✅ View display updated.\n";
}

// ═══════════════════════════════════════════════════
// 5. POPULATE THE HERO PARAGRAPH WITH BANNER DATA
// ═══════════════════════════════════════════════════

// Create file entity for the banner image
$uri = 'public://hero-banner-drupal.png';
if (file_exists(\Drupal::service('file_system')->realpath($uri))) {
  $file = File::create([
    'uri' => $uri,
    'status' => 1,
  ]);
  $file->save();
  echo "✅ Banner file entity created: FID=" . $file->id() . "\n";

  // Find the Hero paragraph (attached to Node 4, home_page)
  $node = \Drupal\node\Entity\Node::load(4);
  if ($node && !$node->get('field_components')->isEmpty()) {
    foreach ($node->get('field_components') as $item) {
      $paragraph = $item->entity;
      if ($paragraph && $paragraph->bundle() === 'hero') {
        $paragraph->set('field_banner_image', [
          'target_id' => $file->id(),
          'alt' => 'Drupal Certified Partner - Diamond | Drupal AI Gold Sponsor',
        ]);
        $paragraph->set('field_banner_link', [
          'uri' => 'https://www.drupal.org/seed-em',
          'title' => '',
        ]);
        $paragraph->save();
        echo "✅ Hero paragraph updated with banner: PID=" . $paragraph->id() . "\n";
        break;
      }
    }
  } else {
    echo "⚠️  Node 4 not found or has no components.\n";
  }
} else {
  echo "❌ Banner image file not found at $uri\n";
}

echo "\n🎉 Done! Run: ddev drush cr\n";
