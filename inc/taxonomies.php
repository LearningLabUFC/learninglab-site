<?php

// Registrando a taxonomia para o CPT de membros

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
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'tipo-de-membro'),
    );

    register_taxonomy('tipo_de_membro', array('membro'), $args);
}

add_action('init', 'registrar_taxonomia_tipo_de_membro');

// Registrando a taxonomia para o CPT de cursos

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

// Registrando a taxonomia para Evento de artigos
function registrar_taxonomia_evento_artigo() {
    $labels = array(
        'name'              => 'Eventos',
        'singular_name'     => 'Evento',
        'search_items'      => 'Buscar Eventos',
        'all_items'         => 'Todos os Eventos',
        'parent_item'       => 'Evento Pai',       // Adicionado para hierarquia
        'parent_item_colon' => 'Evento Pai:',      // Adicionado para hierarquia
        'edit_item'         => 'Editar Evento',
        'update_item'       => 'Atualizar Evento',
        'add_new_item'      => 'Adicionar Novo Evento',
        'new_item_name'     => 'Nome do Novo Evento',
        'menu_name'         => 'Eventos',
    );
    $args = array(
        'hierarchical'      => true,  // MUDANÇA: true deixa igual a Categorias (checkbox)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,  // Necessário para aparecer no editor novo
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'evento-artigo'),
    );
    register_taxonomy('evento_artigo', array('artigo'), $args);
}
add_action('init', 'registrar_taxonomia_evento_artigo');

// Registrando a taxonomia para Anos dos Artigos
function registrar_taxonomia_ano_artigo()
{
    $labels = array(
        'name'              => 'Anos de Publicação',
        'singular_name'     => 'Ano',
        'search_items'      => 'Buscar Anos',
        'all_items'         => 'Todos os Anos',
        'parent_item'       => 'Ano Pai',
        'parent_item_colon' => 'Ano Pai:',
        'edit_item'         => 'Editar Ano',
        'update_item'       => 'Atualizar Ano',
        'add_new_item'      => 'Adicionar Novo Ano',
        'new_item_name'     => 'Novo Ano',
        'menu_name'         => 'Anos',
    );
    $args = array(
        'hierarchical'      => true, // True deixa igual a Categorias (checkbox list)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'ano-artigo'),
        'show_in_rest'      => true, // Importante para o editor de blocos
    );
    register_taxonomy('ano_artigo', array('artigo'), $args);
}
add_action('init', 'registrar_taxonomia_ano_artigo');