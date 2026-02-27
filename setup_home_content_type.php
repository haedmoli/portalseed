<?php

/**
 * Creates a new "Home" content type, migrates Hero paragraph, and hides metadata.
 */

use Drupal\node\Entity\NodeType;
use Drupal\node\Entity\Node;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;

// ═══════════════════════════════════════════════════
// 1. CREATE "HOME" CONTENT TYPE
// ═══════════════════════════════════════════════════
$type_id = 'home_page';

if (!NodeType::load($type_id)) {
  $home_type = NodeType::create([
    'type' => $type_id,
    'name' => 'Home',
    'description' => 'Tipo de contenido para la página principal del sitio.',
    'display_submitted' => FALSE, // ← Hides "Submitted by..." natively
  ]);
  $home_type->save();
  echo "✅ Content type 'Home' created.\n";

  // Add default body field (optional but good practice)
  // node_add_body_field($home_type); // Uncomment if body field is needed
} else {
  // Ensure submitted info is disabled
  $home_type = NodeType::load($type_id);
  $home_type->setDisplaySubmitted(FALSE);
  $home_type->save();
  echo "ℹ️  Content type 'Home' already exists. Updated display_submitted.\n";
}

// ═══════════════════════════════════════════════════
// 2. ADD field_components TO HOME (Paragraph Reference)
// ═══════════════════════════════════════════════════

// Check if field_storage exists (it should, since landing_page uses it)
$field_storage = FieldStorageConfig::loadByName('node', 'field_components');
if (!$field_storage) {
  echo "❌ field_components storage not found. Creating...\n";
  $field_storage = FieldStorageConfig::create([
    'field_name' => 'field_components',
    'entity_type' => 'node',
    'type' => 'entity_reference_revisions',
    'settings' => [
      'target_type' => 'paragraph',
    ],
    'cardinality' => -1,
  ]);
  $field_storage->save();
  echo "✅ Field storage created.\n";
}

// Attach field to home_page bundle
$field_config = FieldConfig::loadByName('node', $type_id, 'field_components');
if (!$field_config) {
  $field_config = FieldConfig::create([
    'field_storage' => $field_storage,
    'bundle' => $type_id,
    'label' => 'Componentes',
    'settings' => [
      'handler' => 'default:paragraph',
      'handler_settings' => [
        'target_bundles' => NULL, // Allow all paragraph types
      ],
    ],
  ]);
  $field_config->save();
  echo "✅ field_components attached to 'Home'.\n";
} else {
  echo "ℹ️  field_components already on 'Home'.\n";
}

// ═══════════════════════════════════════════════════
// 3. CONFIGURE VIEW DISPLAY FOR HOME
// ═══════════════════════════════════════════════════

$view_display = EntityViewDisplay::load('node.home_page.default');
if (!$view_display) {
  $view_display = EntityViewDisplay::create([
    'targetEntityType' => 'node',
    'bundle' => $type_id,
    'mode' => 'default',
    'status' => TRUE,
  ]);
}

$view_display->setComponent('field_components', [
  'type' => 'entity_reference_revisions_entity_view',
  'label' => 'hidden',
  'settings' => [
    'view_mode' => 'default',
  ],
  'weight' => 0,
]);

// Hide unwanted fields
$view_display->removeComponent('uid');
$view_display->removeComponent('created');
$view_display->removeComponent('langcode');
$view_display->save();
echo "✅ View display configured.\n";

// ═══════════════════════════════════════════════════
// 4. CONFIGURE FORM DISPLAY FOR HOME
// ═══════════════════════════════════════════════════

$form_display = EntityFormDisplay::load('node.home_page.default');
if (!$form_display) {
  $form_display = EntityFormDisplay::create([
    'targetEntityType' => 'node',
    'bundle' => $type_id,
    'mode' => 'default',
    'status' => TRUE,
  ]);
}

$form_display->setComponent('field_components', [
  'type' => 'paragraphs',
  'weight' => 0,
  'settings' => [
    'title' => 'Componente',
    'title_plural' => 'Componentes',
    'edit_mode' => 'open',
    'closed_mode' => 'summary',
    'autocollapse' => 'none',
    'add_mode' => 'dropdown',
    'form_display_mode' => 'default',
    'default_paragraph_type' => '',
  ],
]);
$form_display->save();
echo "✅ Form display configured.\n";

// ═══════════════════════════════════════════════════
// 5. CREATE HOME NODE WITH EXISTING HERO PARAGRAPH
// ═══════════════════════════════════════════════════

// Load existing Home node (landing_page, Node 3)
$old_node = Node::load(3);
$paragraph_ref = NULL;

if ($old_node && !$old_node->get('field_components')->isEmpty()) {
  $paragraph_ref = $old_node->get('field_components')->getValue();
  echo "📦 Found " . count($paragraph_ref) . " paragraph(s) in old Home.\n";
}

// Create new Home node
$home_node = Node::create([
  'type' => $type_id,
  'title' => 'Home',
  'uid' => 1,
  'status' => 1,
  'langcode' => 'es',
]);

if ($paragraph_ref) {
  $home_node->set('field_components', $paragraph_ref);
}

$home_node->save();
echo "✅ Home node created: NID=" . $home_node->id() . "\n";

// ═══════════════════════════════════════════════════
// 6. SET NEW NODE AS FRONTPAGE
// ═══════════════════════════════════════════════════

\Drupal::configFactory()->getEditable('system.site')
  ->set('page.front', '/node/' . $home_node->id())
  ->save();
echo "✅ Frontpage set to /node/" . $home_node->id() . "\n";

// ═══════════════════════════════════════════════════
// 7. HIDE "SUBMITTED BY" ON LANDING_PAGE TOO
// ═══════════════════════════════════════════════════

$landing_type = NodeType::load('landing_page');
if ($landing_type) {
  $landing_type->setDisplaySubmitted(FALSE);
  $landing_type->save();
  echo "✅ 'Submitted by...' hidden on landing_page.\n";
}

// Also hide on 'page' (basic page) if it exists
$page_type = NodeType::load('page');
if ($page_type) {
  $page_type->setDisplaySubmitted(FALSE);
  $page_type->save();
  echo "✅ 'Submitted by...' hidden on page.\n";
}

// Also hide on 'article' if it exists
$article_type = NodeType::load('article');
if ($article_type) {
  $article_type->setDisplaySubmitted(FALSE);
  $article_type->save();
  echo "✅ 'Submitted by...' hidden on article.\n";
}

echo "\n🎉 Done! New Home node: /node/" . $home_node->id() . "\n";
echo "Run: ddev drush cr\n";
