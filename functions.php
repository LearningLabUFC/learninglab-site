<?php

// Definindo recursos suportados pelo tema

function learninglab_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
}

add_action('after_setup_theme', 'learninglab_theme_support');

// Definindo os menus do tema e suas localizações

function learninglab_menus()
{
    $locations = array(
        'primary' => "Cabeçalho",
        'footer' => "Rodapé"
    );
    register_nav_menus($locations);
}

add_action('init', 'learninglab_menus');

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

// Definindo áreas de widgets

function learninglab_widget_areas()
{
    // Primeira área de widget no rodapé
    register_sidebar(
        array(
            'name'          => 'Rodapé - Área 1',
            'id'            => 'footer-1',
            'description'   => 'Primeira área de widget do rodapé',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
        )
    );

    // Segunda área de widget no rodapé
    register_sidebar(
        array(
            'name'          => 'Rodapé - Área 2',
            'id'            => 'footer-2',
            'description'   => 'Segunda área de widget do rodapé',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
        )
    );
}

add_action('widgets_init', 'learninglab_widget_areas');

// Definindo configuração de personalização para redes sociais

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

// Limitar a pesquisa apenas a posts

function limitar_busca_apenas_posts($query) {
    if ($query->is_search() && !is_admin()) {
        $query->set('post_type', 'post');    }
    return $query;
}

add_action('pre_get_posts', 'limitar_busca_apenas_posts');

// Registrando um Custom Post Type para adicionar membros

function registrar_cpt_membros()
{
    $labels = array(
        'name'               => 'Membros',
        'singular_name'      => 'Membro',
        'menu_name'          => 'Membros',
        'name_admin_bar'     => 'Membro',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Membro',
        'new_item'           => 'Novo Membro',
        'edit_item'          => 'Editar Membro',
        'view_item'          => 'Ver Membro',
        'all_items'          => 'Todos os Membros',
        'search_items'       => 'Procurar Membros',
        'not_found'          => 'Nenhum membro encontrado.',
        'not_found_in_trash' => 'Nenhum membro encontrado na lixeira.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'show_in_rest'       => false,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-groups',
    );

    register_post_type('membro', $args);
}
add_action('init', 'registrar_cpt_membros');

// Registrando a taxonomia para os membros

function registrar_taxonomia_tipo_de_membro()
{
    $labels = array(
        'name'              => 'Tipo de Membro',
        'singular_name'     => 'Tipo de Membro',
        'search_items'      => 'Procurar Tipos de Membro',
        'all_items'         => 'Todos os Tipos',
        'parent_item'       => 'Tipo Pai',
        'parent_item_colon' => 'Tipo Pai:',
        'edit_item'         => 'Editar Tipo',
        'update_item'       => 'Atualizar Tipo',
        'add_new_item'      => 'Adicionar Novo Tipo',
        'new_item_name'     => 'Novo Nome do Tipo',
        'menu_name'         => 'Tipo de Membro',
    );

    $args = array(
        'hierarchical'      => true, // Permite subcategorias
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipo-de-membro'),
    );

    register_taxonomy('tipo_de_membro', array('membro'), $args);
}
add_action('init', 'registrar_taxonomia_tipo_de_membro');

// Registrando um Custom Post Type para adicionar cursos

function registrar_cpt_cursos()
{
    $labels = array(
        'name'               => 'Cursos',
        'singular_name'      => 'Curso',
        'menu_name'          => 'Cursos',
        'name_admin_bar'     => 'Curso',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Curso',
        'new_item'           => 'Novo Curso',
        'edit_item'          => 'Editar Curso',
        'view_item'          => 'Ver Curso',
        'all_items'          => 'Todos os Cursos',
        'search_items'       => 'Buscar Cursos',
        'not_found'          => 'Nenhum curso encontrado.',
        'not_found_in_trash' => 'Nenhum curso encontrado na lixeira.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => false,
        'has_archive'        => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'rewrite'            => array('slug' => 'cursos'),
    );

    register_post_type('curso', $args);
}
add_action('init', 'registrar_cpt_cursos');

// Registrando a taxonomia para os cursos 

function registrar_taxonomia_status_curso()
{
    $labels = array(
        'name'              => 'Status do Curso',
        'singular_name'     => 'Status do Curso',
        'search_items'      => 'Procurar Status',
        'all_items'         => 'Todos os Status',
        'parent_item'       => 'Status Pai',
        'parent_item_colon' => 'Status Pai:',
        'edit_item'         => 'Editar Status',
        'update_item'       => 'Atualizar Status',
        'add_new_item'      => 'Adicionar Novo Status',
        'new_item_name'     => 'Novo Nome de Status',
        'menu_name'         => 'Status do Curso',
    );

    $args = array(
        'hierarchical'      => true, // Para permitir subcategorias
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'status-do-curso'),
    );

    register_taxonomy('status_curso', array('curso'), $args);
}
add_action('init', 'registrar_taxonomia_status_curso');

// Registrando um Custom Post Type para adicionar avaliações

function criar_cpt_avaliacoes()
{
    $labels = array(
        'name'                  => 'Avaliações',
        'singular_name'         => 'Avaliação',
        'menu_name'             => 'Avaliações',
        'name_admin_bar'        => 'Avaliação',
        'add_new'               => 'Adicionar Nova',
        'add_new_item'          => 'Adicionar Nova Avaliação',
        'new_item'              => 'Nova Avaliação',
        'edit_item'             => 'Editar Avaliação',
        'view_item'             => 'Ver Avaliação',
        'all_items'             => 'Todas as Avaliações',
        'search_items'          => 'Buscar Avaliações',
        'not_found'             => 'Nenhuma avaliação encontrada.',
        'not_found_in_trash'    => 'Nenhuma avaliação encontrada na lixeira.',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'show_in_rest'          => true, // Ativa o suporte para o editor Gutenberg
        'menu_icon'             => 'dashicons-format-quote', // Ícone para o menu no admin
        'supports'              => array('title', 'editor', 'thumbnail'), // Suporta título, editor (conteúdo) e imagem destacada
    );

    register_post_type('avaliacoes', $args);
}

add_action('init', 'criar_cpt_avaliacoes');

// Shortcode para membros
function membros_shortcode($atts) {
    // Extrair os atributos do shortcode e aceitar múltiplos slugs separados por vírgula
    $atts = shortcode_atts(
        array(
            'slugs' => '', // Atributo para receber os slugs
        ),
        $atts,
        'membros'
    );

    // Converter a string de slugs em um array
    $slugs = array_map('trim', explode(',', $atts['slugs']));

    // Se não houver slugs, retorna vazio
    if (empty($slugs)) {
        return '';
    }

    // Iniciar a saída HTML
    $output = '<div class="membros-grid">';

    // Contar quantos membros são retornados
    $membros_count = 0;

    // Loop através dos slugs
    foreach ($slugs as $slug) {
        // Buscar o post pelo slug
        $args = array(
            'name'        => $slug,
            'post_type'   => 'membro', // Altere para o post type correto, se necessário
            'post_status' => 'publish',
            'numberposts' => 1,
        );
        $membro = get_posts($args);

        // Se o post existir, gerar a estrutura
        if ($membro) {
            $post = $membro[0];
            $nome = get_the_title($post->ID);
            $imagem = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'attachment-thumbnail size-thumbnail wp-post-image'));

            $output .= '<div class="membro-item">';
            $output .= '<div class="membro-avatar">' . $imagem . '</div>';
            $output .= '<h4 class="membro-nome">' . esc_html($nome) . '</h4>';
            $output .= '</div>';

            // Incrementa a contagem de membros
            $membros_count++;
        }
    }

    // Adicionar a classe dependendo do número de membros
    if ($membros_count === 2) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-2">', $output);
    } elseif ($membros_count === 3) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-3">', $output);
    } elseif ($membros_count === 4) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-4">', $output);
    } elseif ($membros_count === 5) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-5">', $output);
    } elseif ($membros_count > 5) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-mais-de-5">', $output);
    }

    // Fechar a estrutura da grid
    $output .= '</div>';

    // Retornar o HTML gerado
    return $output;
}
add_shortcode('membros', 'membros_shortcode');

// Função auxiliar para verificar se um membro é formado na página de membros

function is_membro_formado($post_id) {
    return has_term('formado', 'tipo_de_membro', $post_id);
}