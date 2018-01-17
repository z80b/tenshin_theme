<?php
function fix_ajax_upload($element, &$form_state, $form) {

  // process $element as normal
  $element = file_managed_file_process($element, $form_state, $form);

  // remove path, add callback
  unset($element['upload_button']['#ajax']['path']);
  $element['upload_button']['#ajax']['callback'] = 'file_ajax_upload_callback';

  return $element;

}

function tenshin_theme_form_system_theme_settings_alter(&$form, &$form_state) {
    $images = theme_get_setting('theme_slide_1');
    die('<pre>'.print_r($images, true).'</pre>');
    $slides_count =  theme_get_setting('slides_count', 'tenshin_theme');
    if (!$slides_count) {
        $slides_count = 5;
    }

    $form['additional_theme_settings'] = array (
        '#type' => 'fieldset',
        '#title' => t('Home page slider'),
        'slides_count' => array (
            '#title' => t('Theme slides count'),
            '#type' => 'textfield',
            '#default_value' => $slides_count
        ),
        'uploads' => array (
            '#type' => 'fieldset'
        )
    );

    for ($i = 0; $i < $slides_count; $i++) {
        $form['additional_theme_settings']['uploads']['theme_slide_' . $i] = array (
            '#type' => 'managed_file',
            '#upload_location' => 'public://tenshin_theme/',
            '#attributes' => array('multiple' => 'multiple'),
            '#upload_validators' => array(
                'file_validate_extensions' => array('jpg png gif'),
            )
        );
    }
}