<?php

use Drupal\node\Entity\NodeType;

$types = [
  'insight' => [
    'name' => 'Insight',
    'description' => 'Blog posts, news, and insights.',
  ],
  'client' => [
    'name' => 'Client',
    'description' => 'Client portfolio entries.',
  ],
  'case_study' => [
    'name' => 'Case Study',
    'description' => 'Detailed success stories and project showcases.',
  ],
  'service' => [
    'name' => 'Service',
    'description' => 'Services offered by the company.',
  ],
  'landing_page' => [
    'name' => 'Landing Page',
    'description' => 'Flexible landing pages using Paragraphs.',
  ],
  'faq' => [
    'name' => 'FAQ',
    'description' => 'Frequently Asked Questions.',
  ],
];

foreach ($types as $id => $info) {
  $type = NodeType::load($id);
  if (!$type) {
    $type = NodeType::create([
      'type' => $id,
      'name' => $info['name'],
      'description' => $info['description'],
    ]);
    $type->save();
    
    // Add default body field
    node_add_body_field($type);
    
    echo "Created Content Type: {$info['name']} ($id)\n";
  } else {
    echo "Content Type exists: {$info['name']} ($id)\n";
  }
}
