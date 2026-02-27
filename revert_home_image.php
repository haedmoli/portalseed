<?php

use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

// Revert to File Entity 3 (The 732KB image from V3 step)
$target_file_id = 3;

echo "Reverting Hero to use File ID: $target_file_id\n";

$node = Node::load(3); // Home
if ($node && !$node->get('field_components')->isEmpty()) {
  $paragraph_item = $node->get('field_components')->first()->getValue();
  $paragraph_id = $paragraph_item['target_id'];
  $revision_id = $paragraph_item['target_revision_id'];

  $paragraph = \Drupal::entityTypeManager()->getStorage('paragraph')->loadRevision($revision_id);
  
  if ($paragraph) {
    echo "Updating Paragraph: " . $paragraph->id() . "\n";
    $paragraph->set('field_image', [
      'target_id' => $target_file_id,
      'alt' => 'Drupal Code Monitor',
    ]);
    $paragraph->save();
    echo "Paragraph Reverted to Image V3.\n";
  }
}
