<?php

use Drupal\webform\Entity\Webform;
use Drupal\Core\Serialization\Yaml;

// Identificador del webform
$webform_id = 'contacto_principal';

// Verificar si ya existe
$webform = \Drupal::entityTypeManager()->getStorage('webform')->load($webform_id);

if ($webform) {
  echo "El webform '$webform_id' ya existe.\n";
  return;
}

// Elementos YAML del formulario
$elements = [
  'flexbox_1' => [
    '#type' => 'webform_flexbox',
    'nombre' => [
      '#type' => 'textfield',
      '#title' => 'Nombre',
      '#placeholder' => 'Tu nombre completo',
      '#required' => TRUE,
    ],
    'correo_electronico' => [
      '#type' => 'email',
      '#title' => 'Correo electrónico',
      '#placeholder' => 'tu@email.com',
      '#required' => TRUE,
    ],
  ],
  'flexbox_2' => [
    '#type' => 'webform_flexbox',
    'empresa' => [
      '#type' => 'textfield',
      '#title' => 'Empresa',
      '#description' => '(opcional)',
      '#description_display' => 'after',
      '#placeholder' => 'Nombre de tu empresa',
    ],
    'telefono' => [
      '#type' => 'tel',
      '#title' => 'Teléfono',
      '#placeholder' => '+57 300 000 0000',
      '#required' => TRUE,
    ],
  ],
  'tipo_contacto' => [
    '#type' => 'radios',
    '#title' => 'Contacto / PQRS',
    '#options' => [
      'contacto' => 'Contacto',
      'pqrs' => 'PQRS',
    ],
    '#default_value' => 'contacto',
    '#options_display' => 'side_by_side',
    '#title_display' => 'invisible', // Hide main title if we want it to look inline like a toggle
  ],
  'mensaje' => [
    '#type' => 'textarea',
    '#title' => 'Mensaje',
    '#placeholder' => 'Cuéntanos sobre tu proyecto o consulta...',
    '#required' => TRUE,
  ],
  'politica_datos' => [
    '#type' => 'checkbox',
    '#title' => 'Acepto la <a href="/politica-de-tratamiento-de-datos" target="_blank">política de tratamiento de datos</a>',
    '#required' => TRUE,
  ],
  'actions' => [
    '#type' => 'webform_actions',
    '#title' => 'Submit button(s)',
    '#submit__label' => 'Envíanos tu mensaje',
  ],
];

// Crear el Webform
$webform = Webform::create([
  'id' => $webform_id,
  'title' => 'Contacto Principal',
  'elements' => Yaml::encode($elements),
  'status' => Webform::STATUS_OPEN,
]);

// Guardar
try {
  $webform->save();
  echo "Webform '$webform_id' creado exitosamente.\n";
} catch (\Exception $e) {
  echo "Error creando webform: " . $e->getMessage() . "\n";
}
