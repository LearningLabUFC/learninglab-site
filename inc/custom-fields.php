<?php

// Adiciona a meta box para os campos personalizados dos artigos
function adicionar_meta_box_artigos() {
    add_meta_box(
        'artigo_custom_fields',
        'Informações Adicionais do Artigo',
        'mostrar_meta_box_artigos',
        'artigo',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'adicionar_meta_box_artigos');

// Mostra os campos da meta box
function mostrar_meta_box_artigos($post) {
    // Adiciona um nonce para verificação
    wp_nonce_field('salvar_meta_box_artigos', 'artigos_nonce');

    // Obtém os valores atuais dos campos
    $ano = get_post_meta($post->ID, 'ano_publicacao', true);
    $premio = get_post_meta($post->ID, 'premio', true);
    $artigo_url_externa = get_post_meta($post->ID, 'artigo_url_externa', true);

    // Campo para o ano de publicação
    echo '<p>';
    echo '<label for="ano_publicacao">Ano de Publicação:</label><br>';
    echo '<input type="text" id="ano_publicacao" name="ano_publicacao" value="' . esc_attr($ano) . '" size="25" />';
    echo '</p>';

    // Campo para o prêmio
    echo '<p>';
    echo '<label for="premio">Prêmio (opcional):</label><br>';
    echo '<input type="text" id="premio" name="premio" value="' . esc_attr($premio) . '" size="25" />';
    echo '</p>';

    // Campo para a URL externa do artigo
    echo '<p>';
    echo '<label for="artigo_url_externa">URL Externa do Artigo (opcional):</label><br>';
    echo '<input type="url" id="artigo_url_externa" name="artigo_url_externa" value="' . esc_attr($artigo_url_externa) . '" size="50" />';
    echo '</p>';
}

// Salva os dados da meta box
function salvar_meta_box_artigos($post_id) {
    // Verifica o nonce
    if (!isset($_POST['artigos_nonce']) || !wp_verify_nonce($_POST['artigos_nonce'], 'salvar_meta_box_artigos')) {
        return;
    }

    // Verifica se é um autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verifica as permissões do usuário
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Salva o campo 'ano_publicacao'
    if (isset($_POST['ano_publicacao'])) {
        update_post_meta($post_id, 'ano_publicacao', sanitize_text_field($_POST['ano_publicacao']));
    }



    // Salva o campo 'premio'
    if (isset($_POST['premio'])) {
        update_post_meta($post_id, 'premio', sanitize_text_field($_POST['premio']));
    }

    // Salva o campo 'artigo_url_externa'
    if (isset($_POST['artigo_url_externa'])) {
        update_post_meta($post_id, 'artigo_url_externa', esc_url_raw($_POST['artigo_url_externa']));
    }
}
add_action('save_post', 'salvar_meta_box_artigos');

// Adiciona a meta box para selecionar autores
function adicionar_meta_box_autores_artigo() {
    add_meta_box(
        'artigo_autores_meta_box',
        'Autores do Artigo',
        'mostrar_meta_box_autores_artigo',
        'artigo',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'adicionar_meta_box_autores_artigo');

// Mostra a meta box para selecionar e ordenar autores
function mostrar_meta_box_autores_artigo($post) {
    wp_nonce_field('salvar_autores_artigo', 'autores_artigo_nonce');

    $membros = get_posts(array(
        'post_type' => 'membro',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ));

    $autores_selecionados_ids = get_post_meta($post->ID, '_artigo_autores', true);
    if (!is_array($autores_selecionados_ids)) {
        $autores_selecionados_ids = array();
    }

    // Create an associative array of all members for easy lookup
    $all_membros_map = array();
    foreach ($membros as $membro) {
        $all_membros_map[$membro->ID] = $membro;
    }

    ?>
    <style>
        .author-sort-container { display: flex; gap: 20px; }
        .author-sort-list-wrapper { width: 50%; }
        .author-sort-list { border: 1px solid #ccd0d4; padding: 10px; min-height: 150px; background: #fff; }
        .author-sort-list h4 { margin: 0 0 10px; padding-bottom: 5px; border-bottom: 1px solid #ccd0d4; font-size: 14px; }
        .author-sort-list li { cursor: move; background: #f8f9fa; padding: 8px; border: 1px solid #e9e9e9; margin-bottom: 5px; border-radius: 3px; }
        .author-sort-list li:hover { background: #f1f1f1; }
        .author-sort-list.selected-authors li { background: #e8f6ff; }
        .ui-sortable-placeholder { border: 1px dashed #f00; background: #fff9c4; height: 36px; margin-bottom: 5px; }
    </style>

    <div class="author-sort-container">
        <div class="author-sort-list-wrapper">
            <h4>Autores Disponíveis</h4>
            <ul id="available-authors-list" class="author-sort-list">
                <?php
                foreach ($membros as $membro) {
                    if (!in_array($membro->ID, $autores_selecionados_ids)) {
                        echo '<li data-id="' . $membro->ID . '">' . esc_html($membro->post_title) . '</li>';
                    }
                }
                ?>
            </ul>
        </div>

        <div class="author-sort-list-wrapper">
            <h4>Autores Selecionados (arraste para ordenar)</h4>
            <ul id="selected-authors-list" class="author-sort-list selected-authors">
                <?php
                // Ensure we display authors in the saved order
                foreach ($autores_selecionados_ids as $autor_id) {
                    if (isset($all_membros_map[$autor_id])) {
                        $membro = $all_membros_map[$autor_id];
                        echo '<li data-id="' . $membro->ID . '">' . esc_html($membro->post_title) . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <input type="hidden" id="artigo_autores_order" name="artigo_autores" value="<?php echo implode(',', $autores_selecionados_ids); ?>">
    <?php
}

// Salva os autores selecionados e ordenados
function salvar_autores_artigo($post_id) {
    // Verifica o nonce
    if (!isset($_POST['autores_artigo_nonce']) || !wp_verify_nonce($_POST['autores_artigo_nonce'], 'salvar_autores_artigo')) {
        return;
    }

    // Verifica se é um autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verifica as permissões
    if (isset($_POST['post_type']) && 'artigo' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Salva os autores
    if (isset($_POST['artigo_autores'])) {
        $autores_ids_str = sanitize_text_field($_POST['artigo_autores']);
        if (empty($autores_ids_str)) {
            delete_post_meta($post_id, '_artigo_autores');
        } else {
            $autores = array_map('intval', explode(',', $autores_ids_str));
            update_post_meta($post_id, '_artigo_autores', $autores);
        }
    } else {
        // Se o campo oculto não estiver presente, remove o meta para limpar os autores
        delete_post_meta($post_id, '_artigo_autores');
    }
}
add_action('save_post', 'salvar_autores_artigo');

add_action('add_meta_boxes', 'adicionar_meta_box_evento_artigo_personalizada');

// Adiciona uma meta box personalizada para a taxonomia 'evento_artigo'
function adicionar_meta_box_evento_artigo_personalizada() {
    add_meta_box(
        'evento_artigo_checklist',
        'Evento do Artigo',
        'mostrar_meta_box_evento_artigo_checklist',
        'artigo',
        'side',
        'high'
    );
}

// Mostra a meta box personalizada como um select dropdown
function mostrar_meta_box_evento_artigo_checklist($post) {
    $taxonomy = 'evento_artigo';
    $tax = get_taxonomy($taxonomy);
    $terms = get_terms($taxonomy, array('hide_empty' => false));
    $post_terms = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));

    $selected_term_id = empty($post_terms) ? '' : $post_terms[0];

    echo '<select name="tax_input[' . $taxonomy . '][]" id="' . $taxonomy . '_select">';
    echo '<option value="">Selecione um Evento</option>'; // Default option
    foreach ($terms as $term) {
        $selected = selected($selected_term_id, $term->term_id, false);
        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
    }
    echo '</select>';
    echo '<p style="margin-top: 10px;"><a href="' . admin_url('edit-tags.php?taxonomy=evento_artigo&post_type=artigo') . '" target="_blank">Adicionar ou editar eventos</a></p>';
}
