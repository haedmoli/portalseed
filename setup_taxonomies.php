<?php

use Drupal\taxonomy\Entity\Vocabulary;

$vocabularies = [
  'client_type' => 'Client Type',
  'article_category' => 'Article Category',
  'faq_category' => 'FAQ Category',
];

foreach ($vocabularies as $vid => $label) {
  $vocab = Vocabulary::load($vid);
  if (!$vocab) {
    $vocab = Vocabulary::create([
      'vid' => $vid,
      'name' => $label,
    ]);
    $vocab->save();
    echo "Created vocabulary: $label ($vid)\n";
  } else {
    echo "Vocabulary exists: $label ($vid)\n";
  }
}
