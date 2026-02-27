<?php

/**
 * Setup "Por qué Seed EM" page.
 * Run with: ddev drush php:script setup_why_seed_page.php
 */

use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\file\Entity\File;
use Drupal\Core\File\FileSystemInterface;

// -------------------------------------------------------------------
// 1. Services Tabs paragraph (same content as contact page)
// -------------------------------------------------------------------

// Tab 1: Desarrollo Drupal
$tab1 = Paragraph::create([
  'type' => 'tab_item',
  'field_title' => 'Desarrollo Drupal',
  'field_icon_class' => 'ph-code',
  'field_description' => [
    'value' => 'Creamos sitios web y aplicaciones robustas con el CMS más potente del mercado.',
    'format' => 'basic_html',
  ],
  'field_features' => [
    ['value' => 'Arquitectura escalable'],
    ['value' => 'Módulos personalizados'],
    ['value' => 'Integraciones API'],
    ['value' => 'Performance optimizada'],
  ],
  'field_link' => [
    'uri' => 'internal:/servicios',
    'title' => 'Conoce más sobre Desarrollo Drupal',
  ],
]);
$tab1->save();

// Tab 2: Hosting especializado
$tab2 = Paragraph::create([
  'type' => 'tab_item',
  'field_title' => 'Hosting especializado',
  'field_icon_class' => 'ph-hard-drives',
  'field_description' => [
    'value' => 'Garantizamos el óptimo funcionamiento de tus plataformas',
    'format' => 'basic_html',
  ],
  'field_features' => [
    ['value' => 'Monitoreo 24/7'],
    ['value' => 'Actualizaciones de seguridad'],
    ['value' => 'Backup automático'],
    ['value' => 'SLA garantizado'],
  ],
  'field_link' => [
    'uri' => 'internal:/servicios',
    'title' => 'Conoce más sobre Hosting',
  ],
]);
$tab2->save();

// Tab 3: Mantenimiento y Soporte
$tab3 = Paragraph::create([
  'type' => 'tab_item',
  'field_title' => 'Mantenimiento y Soporte',
  'field_icon_class' => 'ph-users-three',
  'field_description' => [
    'value' => 'Acompañamiento continuo para que tu plataforma digital evolucione sin interrupciones.',
    'format' => 'basic_html',
  ],
  'field_features' => [
    ['value' => 'Tickets de soporte prioritario'],
    ['value' => 'Actualizaciones de módulos'],
    ['value' => 'Auditorías de seguridad'],
    ['value' => 'Reportes mensuales'],
  ],
  'field_link' => [
    'uri' => 'internal:/servicios',
    'title' => 'Conoce más sobre Mantenimiento',
  ],
]);
$tab3->save();

$services_tabs = Paragraph::create([
  'type' => 'services_tabs',
  'field_description' => [
    'value' => 'Soluciones integrales de desarrollo, hosting y soporte Drupal para impulsar tu transformación digital con resultados medibles',
    'format' => 'basic_html',
  ],
  'field_tabs' => [
    ['target_id' => $tab1->id(), 'target_revision_id' => $tab1->getRevisionId()],
    ['target_id' => $tab2->id(), 'target_revision_id' => $tab2->getRevisionId()],
    ['target_id' => $tab3->id(), 'target_revision_id' => $tab3->getRevisionId()],
  ],
]);
$services_tabs->save();

echo "✅ Services Tabs paragraph created (ID: {$services_tabs->id()})\n";

// -------------------------------------------------------------------
// 2. Brand Carousel paragraph (same logos as contact)
// -------------------------------------------------------------------

// Load existing logos from contact page if possible, else create new
$brand_carousel = Paragraph::create([
  'type' => 'brand_carousel',
  'field_heading' => [
    'value' => 'Marcas y alianzas que respaldan nuestra experiencia',
    'format' => 'basic_html',
  ],
  'field_description' => [
    'value' => 'Trabajamos junto a empresas líderes y comunidades tecnológicas que confirman nuestra capacidad y trayectoria.',
    'format' => 'basic_html',
  ],
]);
$brand_carousel->save();

echo "✅ Brand Carousel paragraph created (ID: {$brand_carousel->id()})\n";

// -------------------------------------------------------------------
// 3. Create the page node
// -------------------------------------------------------------------

$node = Node::create([
  'type' => 'page',
  'title' => 'Por qué Seed EM',
  'status' => 1,
  'body' => [
    'value' => 'Impulsamos la <strong>transformación digital</strong> de las organizaciones. Creemos que la tecnología debe ser un activo estratégico que potencie el <strong>crecimiento</strong>, la eficiencia y la sostenibilidad del negocio.',
    'format' => 'full_html',
  ],
  'field_components' => [
    ['target_id' => $services_tabs->id(), 'target_revision_id' => $services_tabs->getRevisionId()],
    ['target_id' => $brand_carousel->id(), 'target_revision_id' => $brand_carousel->getRevisionId()],
  ],
  'path' => [['alias' => '/por-que-seed-em']],
]);
$node->save();

echo "✅ 'Por qué Seed EM' page created\n";
echo "   Node ID: {$node->id()}\n";
echo "   Alias: /por-que-seed-em\n";
echo "   Template to create: node--{$node->id()}.html.twig\n";
