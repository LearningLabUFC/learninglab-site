<?php 



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
        'show_in_rest'       => true, 
        'has_archive'        => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'rewrite'            => array('slug' => 'cursos'),
    );

    register_post_type('curso', $args);
}

add_action('init', 'registrar_cpt_cursos');


function registrar_meta_boxes_membros() {
    add_meta_box('redes_sociais_membro', 'Redes Sociais', 'render_meta_box_redes_sociais', 'membro', 'normal', 'high');
}
add_action('add_meta_boxes', 'registrar_meta_boxes_membros');

function render_meta_box_redes_sociais($post) {
    $instagram = get_post_meta($post->ID, 'instagram_url', true);
    $linkedin = get_post_meta($post->ID, 'linkedin_url', true);
    $lattes = get_post_meta($post->ID, 'lattes_url', true);
    $github = get_post_meta($post->ID, 'github_url', true);
    $site = get_post_meta($post->ID, 'site_url', true);
    ?>
    <?php wp_nonce_field('membro_redes_sociais', 'membro_redes_sociais_nonce'); ?>
    <p>
        <label for="linkedin_url"><strong>LinkedIn URL:</strong></label><br>
        <input type="url" name="linkedin_url" id="linkedin_url" value="<?php echo esc_attr($linkedin); ?>" style="width:100%;">
    </p>
    <p>
        <label for="instagram_url"><strong>Instagram URL:</strong></label><br>
        <input type="url" name="instagram_url" id="instagram_url" value="<?php echo esc_attr($instagram); ?>" style="width:100%;">
    </p>
    <p>
        <label for="github_url"><strong>GitHub URL:</strong></label><br>
        <input type="url" name="github_url" id="github_url" value="<?php echo esc_attr($github); ?>" style="width:100%;">
    </p>
    <p>
        <label for="site_url"><strong>Site URL:</strong></label><br>
        <input type="url" name="site_url" id="site_url" value="<?php echo esc_attr($site); ?>" style="width:100%;">
    </p>
    <p>
        <label for="lattes_url"><strong>Currículo Lattes URL:</strong></label><br>
        <input type="url" name="lattes_url" id="lattes_url" value="<?php echo esc_attr($lattes); ?>" style="width:100%;">
    </p>
    <?php
}

function salvar_meta_boxes_membros($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!isset($_POST['membro_redes_sociais_nonce']) || !wp_verify_nonce($_POST['membro_redes_sociais_nonce'], 'membro_redes_sociais')) return;

    if (isset($_POST['instagram_url'])) {
        update_post_meta($post_id, 'instagram_url', esc_url_raw($_POST['instagram_url']));
    }
    if (isset($_POST['linkedin_url'])) {
        update_post_meta($post_id, 'linkedin_url', esc_url_raw($_POST['linkedin_url']));
    }
    if (isset($_POST['github_url'])) {
        update_post_meta($post_id, 'github_url', esc_url_raw($_POST['github_url']));
    }
    if (isset($_POST['site_url'])) {
        update_post_meta($post_id, 'site_url', esc_url_raw($_POST['site_url']));
    }
    if (isset($_POST['lattes_url'])) {
        update_post_meta($post_id, 'lattes_url', esc_url_raw($_POST['lattes_url']));
    }
}
add_action('save_post_membro', 'salvar_meta_boxes_membros');



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
        'show_in_rest'          => true, 
        'menu_icon'             => 'dashicons-format-quote', 
        'supports'              => array('title', 'editor', 'thumbnail'), 
    );

    register_post_type('avaliacoes', $args);
}

add_action('init', 'criar_cpt_avaliacoes');


function registrar_cpt_artigos()
{
    $labels = array(
        'name'               => 'Artigos',
        'singular_name'      => 'Artigo',
        'menu_name'          => 'Artigos',
        'name_admin_bar'     => 'Artigo',
        'add_new'            => 'Adicionar Novo',
        'add_new_item'       => 'Adicionar Novo Artigo',
        'new_item'           => 'Novo Artigo',
        'edit_item'          => 'Editar Artigo',
        'view_item'          => 'Ver Artigo',
        'all_items'          => 'Todos os Artigos',
        'search_items'       => 'Procurar Artigos',
        'not_found'          => 'Nenhum artigo encontrado.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'show_in_rest'       => true,
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-media-document',
    );

    register_post_type('artigo', $args);
}

add_action('init', 'registrar_cpt_artigos');
