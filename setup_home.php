<?php

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\Entity\FieldConfig;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;

// 1. Update Field Link Cardinality
$link_storage = FieldStorageConfig::loadByName('paragraph', 'field_link');
if ($link_storage) {
  $link_storage->setCardinality(-1); // Unlimited
  $link_storage->save();
  echo "Updated field_link cardinality to unlimited.\n";
}

// Helper Block to create fields
function create_paragraph_field($field_name, $type, $label, $bundle, $cardinality = 1, $settings = []) {
  $storage = FieldStorageConfig::loadByName('paragraph', $field_name);
  if (!$storage) {
    $storage = FieldStorageConfig::create([
      'field_name' => $field_name,
      'entity_type' => 'paragraph',
      'type' => $type,
      'cardinality' => $cardinality,
      'settings' => $settings,
    ]);
    $storage->save();
  }

  $field = FieldConfig::loadByName('paragraph', $bundle, $field_name);
  if (!$field) {
    $field = FieldConfig::create([
      'field_name' => $field_name,
      'entity_type' => 'paragraph',
      'bundle' => $bundle,
      'label' => $label,
    ]);
    $field->save();

    // Enable in Form Display
    $form_display = \Drupal::service('entity_display.repository')->getFormDisplay('paragraph', $bundle);
    $form_display->setComponent($field_name, [
      'type' => ($type == 'text_long' || $type == 'text_with_summary') ? 'text_textarea' : 'string_textfield',
    ])->save();

    // Enable in View Display
    $view_display = \Drupal::service('entity_display.repository')->getViewDisplay('paragraph', $bundle);
    $view_display->setComponent($field_name, [
      'type' => ($type == 'text_long' || $type == 'text_with_summary') ? 'text_default' : 'string',
    ])->save();
    
    echo "Created field $field_name on $bundle.\n";
  }
}

// 2. Create New Fields for Hero
create_paragraph_field('field_badge', 'string', 'Badge/Tag', 'hero');
create_paragraph_field('field_title', 'text_long', 'Hero Title (Formatted)', 'hero');
create_paragraph_field('field_description', 'text_long', 'Description (Main)', 'hero');
create_paragraph_field('field_stats', 'text_long', 'Stats Items', 'hero', 3);


// 3. Create Home Content
// Check if "Inicio" exists
$query = \Drupal::entityQuery('node')
  ->condition('type', 'landing_page')
  ->condition('title', 'Inicio')
  ->accessCheck(FALSE);
$nids = $query->execute();

if (empty($nids)) {
  // Create Hero Paragraph
  $hero = Paragraph::create([
    'type' => 'hero',
    'field_badge' => 'Drupal Certified Partner - Nivel Oro',
    'field_title' => [
      'value' => 'Transformamos ideas en <strong>soluciones digitales</strong> extraordinarias',
      'format' => 'full_html',
    ],
    'field_description' => [
      'value' => '<p>Desarrollamos plataformas web robustas y escalables con Drupal, impulsando la transformación digital de empresas líderes en gobierno, educación y tecnología.</p>
      <div class="hero-feature-box">
        <div class="feature-icon">🚀</div>
        <div class="feature-content">
          <strong>SeedCloud Hosting</strong>
          <p>Hosting especializado en Drupal con soporte técnico en español. Optimizado para máximo rendimiento y seguridad.</p>
          <div class="feature-tags">
            <span class="tag">99.9% Uptime</span>
            <span class="tag">Soporte en Español</span>
            <span class="tag">SSL Gratuito</span>
          </div>
        </div>
      </div>',
      'format' => 'full_html',
    ],
    'field_link' => [
      ['uri' => 'internal:#project', 'title' => 'Iniciar Proyecto', 'options' => ['attributes' => ['class' => ['button', 'button--primary']]]],
      ['uri' => 'internal:#seedcloud', 'title' => 'Ver SeedCloud', 'options' => ['attributes' => ['class' => ['button', 'button--outline']]]],
    ],
    'field_stats' => [
      ['value' => '<strong>150+</strong><br>Proyectos completados', 'format' => 'full_html'],
      ['value' => '<strong>18</strong><br>Años de experiencia', 'format' => 'full_html'],
      ['value' => '<strong>99.9%</strong><br>Uptime SeedCloud', 'format' => 'full_html'],
    ],
    // Image would need a file upload. For now, leave empty or use a placeholder if exists.
  ]);
  $hero->save();

  // Create Node
  $node = Node::create([
    'type' => 'landing_page',
    'title' => 'Inicio',
    'field_components' => [
      [
        'target_id' => $hero->id(),
        'target_revision_id' => $hero->getRevisionId(),
      ],
    ],
    'status' => 1,
  ]);
  $node->save();
  echo "Created Home Node: " . $node->id() . "\n";

  // Set as Front Page
  \Drupal::configFactory()->getEditable('system.site')->set('page.front', '/node/' . $node->id())->save();
  echo "Set Home as Front Page.\n";

} else {
  echo "Home node already exists.\n";
}
