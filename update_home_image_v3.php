<?php

use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

// 1. Create File Entity from 'sites/default/files/hero-final-real.png'
$uri = 'public://hero-final-real.png';
$file = File::create([
  'uri' => $uri,
  'uid' => 1,
  'status' => 1,
]);
$file->save();
echo "Created File Entity (V3): " . $file->id() . "\n";

// 2. Find Home Node and Update Hero Paragraph
$node = Node::load(3); // Assuming Node 3 is Home
if ($node && !$node->get('field_components')->isEmpty()) {
  $paragraph_item = $node->get('field_components')->first()->getValue();
  $paragraph_id = $paragraph_item['target_id'];
  $revision_id = $paragraph_item['target_revision_id'];

  $paragraph = \Drupal::entityTypeManager()->getStorage('paragraph')->loadRevision($revision_id);
  
  if ($paragraph) {
    echo "Updating Paragraph: " . $paragraph->id() . "\n";
    $paragraph->set('field_image', [
      'target_id' => $file->id(),
      'alt' => 'Drupal Code Monitor',
    ]);
    $paragraph->save();
    echo "Paragraph Updated with Image V3.\n";
  } else {
    // Fallback if revision load fails
    $paragraph = Paragraph::load($paragraph_id);
    if ($paragraph) {
       $paragraph->set('field_image', [
        'target_id' => $file->id(),
        'alt' => 'Drupal Code Monitor',
      ]);
      $paragraph->save();
      echo "Paragraph Updated (Latest revision).\n";
    }
  }
} else {
  echo "Node 3 or components field empty.\n";
}
