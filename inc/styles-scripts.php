<?php

// Enfileirando as folhas de estilo

function learninglab_register_styles()
{
    $version = wp_get_theme()->get('Version');

    wp_enqueue_style('learninglab-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css", array(), '6.0.0', 'all');

    // Estilo para a página inicial (front page)
    wp_enqueue_style('learninglab_main_style', get_template_directory_uri() . "/assets/css/main.css", array(), $version, 'all');

    // Estilo global (exemplo: header.css)
    wp_enqueue_style('learninglab_header_style', get_template_directory_uri() . "/assets/css/header.css", array(), $version, 'all');

    wp_enqueue_style('learninglab_footer_style', get_template_directory_uri() . "/assets/css/footer.css", array(), $version, 'all');

    // Estilo específico para páginas single.php
    if (is_singular('post')) {
        wp_enqueue_style('learninglab_single_style', get_template_directory_uri() . "/assets/css/single.css", array(), $version, 'all');
    }

    if (is_archive() || is_home() || is_search()) {
        wp_enqueue_style('learninglab_archive_style', get_template_directory_uri() . "/assets/css/archive.css", array(), $version, 'all');
    }

    if (is_404()) {
        wp_enqueue_style('learninglab_404_style', get_template_directory_uri() . "/assets/css/404.css", array(), $version, 'all');
    }

    if (is_page() || is_singular('curso')) {
        wp_enqueue_style('learninglab_curso_style', get_template_directory_uri() . "/assets/css/page.css", array(), $version, 'all');
    }

    if (is_page('contato')) {
        wp_enqueue_style('learninglab_contato_style', get_template_directory_uri() . "/assets/css/contato.css", array(), $version, 'all');
    }

    // Estilos específicos para a página inicial (front-page.php)
    if (is_front_page()) {
        wp_enqueue_style('learninglab_frontpage_style', get_template_directory_uri() . "/assets/css/front-page.css", array(), $version, 'all');
        // estilo geral do Swiper (retirar dessa condicional caso vá usar o swiper em outra página)
        wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), null, 'all');
        // Swiper Avaliações
        wp_enqueue_style('swiper-avaliacoes-style', get_template_directory_uri() . "/assets/css/swiper-styles-avaliacoes.css", array('swiper-css'), $version, 'all');
        // Swiper Notícias
        wp_enqueue_style('swiper-noticias-style', get_template_directory_uri() . "/assets/css/swiper-styles-noticias.css", array('swiper-css'), $version, 'all');
    }

    if (is_singular('post') || is_page()) {
        wp_enqueue_style('learninglab_membro_style', get_template_directory_uri() . "/assets/css/membro.css", array(), $version, 'all');
    }
}

add_action('wp_enqueue_scripts', 'learninglab_register_styles');

// Enfileirando os scripts

function learninglab_register_scripts()
{
    $version = wp_get_theme()->get('Version');
    // Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0', true);
    // Swiper Avaliações
    wp_enqueue_script('swiper-init-avaliacoes', get_template_directory_uri() . "/assets/js/swiper-init-avaliacoes.js", array('swiper-js'), $version, true);
    // Swiper Notícias
    wp_enqueue_script('swiper-init-noticias', get_template_directory_uri() . "/assets/js/swiper-init-noticias.js", array('swiper-js'), $version, true);
    // JS principal do site
    wp_enqueue_script('learninglab_main_script', get_template_directory_uri() . "/assets/js/main.js", array(), $version, true);
}

add_action('wp_enqueue_scripts', 'learninglab_register_scripts');