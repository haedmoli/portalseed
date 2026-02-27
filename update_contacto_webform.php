<?php
use Drupal\webform\Entity\Webform;
use Drupal\Core\Serialization\Yaml;

$webform_id = 'contacto_principal';
$webform = \Drupal::entityTypeManager()->getStorage('webform')->load($webform_id);

if (!$webform) {
  echo "Webform no encontrado.\n";
  return;
}

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
      '#title' => 'Empresa (opcional)',
      '#placeholder' => 'Nombre de tu empresa',
    ],
    'telefono' => [
      '#type' => 'tel',
      '#title' => 'Teléfono',
      '#placeholder' => '+57 300 123 4567',
      '#required' => TRUE,
    ],
  ],
  'tipo_contacto' => [
    '#type' => 'checkbox',
    '#title' => 'PQRS',
    '#wrapper_attributes' => [
      'class' => ['pg-custom-switch-wrapper'],
    ],
  ],
  'asunto' => [
    '#type' => 'textfield',
    '#title' => 'Asunto',
    '#placeholder' => 'Asunto de tu consulta',
    '#states' => [
      'visible' => [
        ':input[name="tipo_contacto"]' => ['checked' => TRUE],
      ],
      'required' => [
        ':input[name="tipo_contacto"]' => ['checked' => TRUE],
      ],
    ],
  ],
  'concepto' => [
    '#type' => 'select',
    '#title' => 'Concepto',
    '#empty_option' => 'Selecciona el tipo de consulta',
    '#options' => [
      'peticion' => 'Petición',
      'queja' => 'Queja',
      'reclamo' => 'Reclamo',
      'sugerencia' => 'Sugerencia',
    ],
    '#states' => [
      'visible' => [
        ':input[name="tipo_contacto"]' => ['checked' => TRUE],
      ],
      'required' => [
        ':input[name="tipo_contacto"]' => ['checked' => TRUE],
      ],
    ],
  ],
  'mensaje' => [
    '#type' => 'textarea',
    '#title' => 'Mensaje',
    '#placeholder' => 'Cuéntanos sobre tu proyecto o consulta...',
    '#required' => TRUE,
  ],
  'politica_datos' => [
    '#type' => 'checkbox',
    '#title' => 'Acepto la <a href="/politica-de-tratamiento-de-datos" target="_blank" class="pg-policy-link">política de tratamiento de datos</a>',
    '#required' => TRUE,
    '#wrapper_attributes' => [
      'class' => ['pg-policy-checkbox-wrapper'],
    ],
  ],
  'actions' => [
    '#type' => 'webform_actions',
    '#title' => 'Submit',
    '#submit__label' => 'Envíanos tu mensaje',
  ],
];

$webform->setElements($elements);
$webform->save();

echo "Webform '$webform_id' actualizado con los campos de políticas y asteriscos.\n";
