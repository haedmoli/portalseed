<?php

use Drupal\block_content\Entity\BlockContent;
use Drupal\menu_link_content\Entity\MenuLinkContent;

// 1. Footer Social Block
$social_uuid = '88888888-1111-1111-1111-111111111111';
$social_body = <<<HTML
<div class="footer-social">
  <div class="social-icons">
    <a href="#" class="social-icon facebook" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
    <a href="#" class="social-icon linkedin" aria-label="LinkedIn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
    <a href="#" class="social-icon drupal" aria-label="Drupal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 22h20L12 2zm0 4l7 14H5l7-14z"/></svg></a>
    <a href="#" class="social-icon youtube" aria-label="YouTube"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg></a>
    <a href="#" class="social-icon instagram" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
  </div>
</div>
HTML;

$block = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', $social_uuid);
if (!$block) {
  $block = BlockContent::create([
    'uuid' => $social_uuid,
    'info' => 'Footer Social Links',
    'type' => 'basic',
    'body' => [
      'value' => $social_body,
      'format' => 'full_html',
    ],
  ]);
  $block->save();
  echo "Created Social Block ($social_uuid)\n";
} else {
    // Update content just in case
    $block->body->value = $social_body;
    $block->body->format = 'full_html';
    $block->save();
    echo "Updated Social Block\n";
}


// 2. Footer Contact Block
$contact_uuid = '88888888-2222-2222-2222-222222222222';
$contact_body = <<<HTML
<div class="footer-contact-info">
  <div class="footer-logo mb-4">
    <img src="/themes/custom/seed_theme/logo.png" alt="Seed" style="height: 36px; width: auto;">
  </div>
  <p class="mb-2">Calle 150 # 21 A - 14, P 2. Bogotá | Colombia</p>
  <p class="mb-4"><strong>Tel: (+57) 3110608152</strong></p>
  <p class="mb-1"><strong>Oficina Miami:</strong></p>
  <p class="mb-4">4855 W Hillsboro Blvd, Suite B3, Coconut Creek, FL 33073</p>
  <p><a href="mailto:info@seedem.co" class="footer-email">info@seedem.co</a></p>
</div>
HTML;

$block = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', $contact_uuid);
if (!$block) {
  $block = BlockContent::create([
    'uuid' => $contact_uuid,
    'info' => 'Footer Contact Info',
    'type' => 'basic',
    'body' => [
      'value' => $contact_body,
      'format' => 'full_html',
    ],
  ]);
  $block->save();
  echo "Created Contact Block ($contact_uuid)\n";
} else {
    $block->body->value = $contact_body;
    $block->body->format = 'full_html';
    $block->save();
    echo "Updated Contact Block\n";
}


// 3. Footer CTA Block
$cta_uuid = '88888888-4444-4444-4444-444444444444';
$cta_body = <<<HTML
<div class="footer-cta-block">
  <p class="mb-4">¿Buscas ayuda en un proyecto en Drupal? Esperamos con interés escuchar de ti.</p>
  <a href="/contacto" class="button button--primary">Evoluciona con Drupal 11</a>
</div>
HTML;

$block = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', $cta_uuid);
if (!$block) {
  $block = BlockContent::create([
    'uuid' => $cta_uuid,
    'info' => 'Footer CTA',
    'type' => 'basic',
    'body' => [
      'value' => $cta_body,
      'format' => 'full_html',
    ],
  ]);
  $block->save();
  echo "Created CTA Block ($cta_uuid)\n";
} else {
    $block->body->value = $cta_body;
    $block->body->format = 'full_html';
    $block->save();
    echo "Updated CTA Block\n";
}

// 4. Footer Menu Items
// Create a separate menu named 'footer-info' if not exists?
// Standard Drupal has 'footer' menu. We'll use that.
$menu_name = 'footer';
$links = [
  'Servicios' => '/services',
  'Nuestros clientes' => '/clients',
  'Casos de éxito' => '/cases',
  'Insights' => '/insights',
  'Ofertas de empleo' => '/jobs',
  'Prensa' => '/press',
  'Política de privacidad' => '/privacy',
  'Contacto' => '/contact',
];

// Clear existing footer links to avoid duplicates? Or just check by title.
// For now, simple creation.
foreach ($links as $title => $uri) {
  $query = \Drupal::entityQuery('menu_link_content')
    ->condition('menu_name', $menu_name)
    ->condition('title', $title)
    ->accessCheck(FALSE);
  $r = $query->execute();
  if (empty($r)) {
    $link = MenuLinkContent::create([
      'title' => $title,
      'link' => ['uri' => 'internal:' . $uri],
      'menu_name' => $menu_name,
      'expanded' => TRUE,
    ]);
    $link->save();
    echo "Created menu link: $title\n";
  }
}
