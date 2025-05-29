<?php 

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
        'show_in_rest'       => true, // ativa o editor Gutemberg
        'has_archive'        => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'rewrite'            => array('slug' => 'cursos'),
    );

    register_post_type('curso', $args);
}

add_action('init', 'registrar_cpt_cursos');

// Registrando um Custom Post Type para adicionar avaliações (aquelas opiniões que ficam na home)

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

