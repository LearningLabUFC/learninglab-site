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
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'status-do-curso'),
    );
    register_taxonomy('status_curso', array('curso'), $args);
}
add_action('init', 'registrar_taxonomia_status_curso');

// Registrando a taxonomia para Evento de artigos - CORRIGIDA
function registrar_taxonomia_evento_artigo() {
    $labels = array(
        'name'              => 'Eventos',
        'singular_name'     => 'Evento',
        'search_items'      => 'Buscar Eventos',
        'all_items'         => 'Todos os Eventos',
        'edit_item'         => 'Editar Evento',
        'update_item'       => 'Atualizar Evento',
        'add_new_item'      => 'Adicionar Novo Evento',
        'new_item_name'     => 'Nome do Novo Evento',
        'menu_name'         => 'Eventos',
    );
    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'evento-artigo'),
        'show_in_quick_edit' => true, // Adiciona edição rápida
    );
    register_taxonomy('evento_artigo', array('artigo'), $args);
}
add_action('init', 'registrar_taxonomia_evento_artigo');