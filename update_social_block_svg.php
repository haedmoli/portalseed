<?php

use Drupal\block_content\Entity\BlockContent;

$social_uuid = '88888888-1111-1111-1111-111111111111';

// User provided SVG
// <svg width='61' height='80' viewBox='0 0 61 80' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='...' fill='#22D3EE'/></svg>
// We need to scale it to ~20px height to match others.
// Preserving 'fill' as requested ("dejarlo tal cual el original").
// Adding style="height: 20px; width: auto;" to control size within flex container.

$drupal_svg = <<<SVG
<svg width="61" height="80" viewBox="0 0 61 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="height: 20px; width: auto;">
<path d="M42.8102 16.8687C37.2278 11.3034 31.9188 5.98244 30.3362 0C28.7823 5.98244 23.4302 11.3034 17.8478 16.8687C9.4886 25.224 0.00719428 34.6866 0.00719428 48.8949C-0.0807593 52.9305 0.638511 56.9431 2.12281 60.6971C3.6071 64.4511 5.82653 67.8711 8.65088 70.7563C11.4752 73.6415 14.8476 75.9338 18.5702 77.4988C22.2928 79.0639 26.2905 79.87 30.329 79.87C34.3674 79.87 38.3652 79.0639 42.0878 77.4988C45.8104 75.9338 49.1828 73.6415 52.0071 70.7563C54.8315 67.8711 57.0509 64.4511 58.5352 60.6971C60.0195 56.9431 60.7387 52.9305 60.6508 48.8949C60.6508 34.6866 51.1694 25.224 42.8102 16.8687ZM15.6033 51.656C14.6763 52.8213 13.8802 54.0848 13.2294 55.4238C13.181 55.53 13.1093 55.6239 13.0197 55.6986C12.93 55.7733 12.8246 55.8269 12.7114 55.8553H12.4524C11.7762 55.8553 11.0137 54.5322 11.0137 54.5322C10.8123 54.2158 10.6252 53.8851 10.4382 53.5399L10.3087 53.2667C8.55341 49.2544 10.0785 43.5452 10.0785 43.5452C10.8303 40.7627 12.0568 38.1308 13.7042 35.7652C14.7106 34.263 15.806 32.8224 16.9845 31.4509L18.4233 32.889L25.2142 39.8206C25.3416 39.963 25.4121 40.1473 25.4121 40.3383C25.4121 40.5293 25.3416 40.7136 25.2142 40.856L18.1211 48.7224L15.6033 51.656ZM30.6815 71.516C28.6636 71.5043 26.692 70.9109 25.003 69.8072C23.314 68.7035 21.9795 67.1362 21.1593 65.2933C20.3392 63.4504 20.0684 61.4102 20.3793 59.4173C20.6902 57.4244 21.5697 55.5635 22.9122 54.0577C25.1279 51.426 27.8327 48.8374 30.7678 45.4291C34.2496 49.1394 36.5228 51.6848 38.7529 54.4747C38.9276 54.6899 39.0818 54.921 39.2133 55.165C40.4331 56.8999 41.0864 58.9694 41.0837 61.0899C41.0875 62.4577 40.8212 63.8128 40.3002 65.0776C39.7791 66.3424 39.0135 67.492 38.0472 68.4605C37.0808 69.4291 35.9328 70.1975 34.6689 70.7218C33.405 71.2461 32.05 71.516 30.6815 71.516ZM50.3637 54.8486C50.2967 55.0636 50.171 55.2557 50.0007 55.403C49.8304 55.5504 49.6222 55.6473 49.3997 55.6827H49.1983C48.7856 55.549 48.437 55.2672 48.2199 54.8917C46.4019 52.1659 44.3409 49.6101 42.0621 47.2555L39.2853 44.3793L30.0628 34.8161C28.1261 33.0224 26.2821 31.1313 24.538 29.15C24.4951 29.0749 24.447 29.0028 24.3941 28.9343C24.0804 28.4934 23.8331 28.0089 23.6604 27.4962C23.6604 27.4099 23.6604 27.3093 23.6604 27.223C23.5326 26.4411 23.5968 25.64 23.8474 24.8885C24.098 24.1369 24.5276 23.4575 25.0991 22.9087C26.8832 21.1255 28.6816 19.3279 30.3794 17.4584C32.2497 19.5292 34.2496 21.5138 36.2207 23.4839C40.2419 27.2268 43.8806 31.36 47.0833 35.8227C49.7872 39.6495 51.2579 44.2102 51.2989 48.8949C51.2762 50.9142 50.9612 52.9195 50.3637 54.8486Z" fill="#22D3EE"/>
</svg>
SVG;

$social_body = <<<HTML
<div class="footer-social">
  <div class="social-icons">
    <a href="https://www.facebook.com/" class="social-icon facebook" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
    <a href="https://www.linkedin.com/" class="social-icon linkedin" aria-label="LinkedIn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
    <a href="https://www.drupal.org/seed-em" class="social-icon drupal" aria-label="Drupal - Seed EM" target="_blank" rel="noopener">
      {$drupal_svg}
    </a>
    <a href="https://www.youtube.com/" class="social-icon youtube" aria-label="YouTube"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg></a>
    <a href="https://www.instagram.com/" class="social-icon instagram" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
  </div>
</div>
HTML;

$block = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', $social_uuid);
if ($block) {
    $block->body->value = $social_body;
    $block->body->format = 'full_html';
    $block->save();
    echo "Updated Social Block Layout with User Requested SVG\n";
} else {
    echo "Block not found!\n";
}
