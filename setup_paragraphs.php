<?php

use Drupal\paragraphs\Entity\ParagraphsType;

$types = [
  'hero' => 'Hero',
  'text_image' => 'Text + Image',
  'cta' => 'Call to Action',
  'webform_embed' => 'Webform Embed',
  'card_grid' => 'Card Grid',
];

foreach ($types as $id => $label) {
  $type = ParagraphsType::load($id);
  if (!$type) {
    $type = ParagraphsType::create([
      'id' => $id,
      'label' => $label,
    ]);
    $type->save();
    echo "Created Paragraph Type: $label ($id)\n";
  } else {
    echo "Paragraph Type exists: $label ($id)\n";
  }
}
