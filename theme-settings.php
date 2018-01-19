<?php

function tenshin_theme_form_system_theme_settings_alter(&$form, &$form_state) {
    $form['additional_theme_settings'] = array (
        'social_links' => array (
            '#type' => 'fieldset',
            '#title' => t('Social links settings'),

            'tw_link' => array (
                '#type' => 'textfield',
                '#title' => t('Twitter link'),
                '#default_value' => theme_get_setting('tw_link', 'tenshin_theme'),
            ),
            'fb_link' => array (
                '#type' => 'textfield',
                '#title' => t('Facebook link'),
                '#default_value' => theme_get_setting('fb_link', 'tenshin_theme'),
            )
        ),
        'foter_texts' => array (
            '#type' => 'fieldset',
            '#title' => t('Footer texts'),

            'footer_text_1' => array (
                '#type' => 'textarea',
                '#title' => t('First text'),
                '#default_value' => theme_get_setting('footer_text_1', 'tenshin_theme'),
            ),
            'footer_text_2' => array (
                '#type' => 'textarea',
                '#title' => t('Second text'),
                '#default_value' => theme_get_setting('footer_text_2', 'tenshin_theme'),
            )
        ),       
    );
}