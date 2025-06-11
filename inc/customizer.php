<?php

function learninglab_customizer_settings($wp_customize)
{
    // Seção para Redes Sociais
    $wp_customize->add_section('social_media_section', array(
        'title'    => __('Redes Sociais', 'theme_textdomain'),
        'priority' => 30,
    ));

    // Redes Sociais
    $social_networks = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube',
        'tiktok'   => 'TikTok',
        'telegram'   => 'Telegram',
    );

    foreach ($social_networks as $key => $label) {
        $wp_customize->add_setting("social_media_{$key}", array(
            'default'   => '',
            'sanitize_callback' => 'esc_url',
        ));

        $wp_customize->add_control("social_media_{$key}", array(
            'label'    => __("URL do {$label}", 'theme_textdomain'),
            'section'  => 'social_media_section',
            'type'     => 'url',
        ));
    }
}

add_action('customize_register', 'learninglab_customizer_settings');