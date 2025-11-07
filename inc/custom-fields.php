<?php

// ========================================
// META BOX: INFORMAÇÕES DO ARTIGO
// ========================================

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
    $evento = get_post_meta($post->ID, 'evento', true);
    $premio = get_post_meta($post->ID, 'premio', true);

    // Campo para o ano de publicação
    echo '<p>';
    echo '<label for="ano_publicacao">Ano de Publicação:</label><br>';
    echo '<input type="text" id="ano_publicacao" name="ano_publicacao" value="' . esc_attr($ano) . '" size="25" />';
    echo '</p>';

    // Campo para o evento
    echo '<p>';
    echo '<label for="evento">Evento:</label><br>';
    echo '<input type="text" id="evento" name="evento" value="' . esc_attr($evento) . '" size="25" />';
    echo '</p>';

    // Campo para o prêmio
    echo '<p>';
    echo '<label for="premio">Prêmio (opcional):</label><br>';
    echo '<input type="text" id="premio" name="premio" value="' . esc_attr($premio) . '" size="25" />';
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

    // Salva o campo 'evento'
    if (isset($_POST['evento'])) {
        update_post_meta($post_id, 'evento', sanitize_text_field($_POST['evento']));
    }

    // Salva o campo 'premio'
    if (isset($_POST['premio'])) {
        update_post_meta($post_id, 'premio', sanitize_text_field($_POST['premio']));
    }
}
add_action('save_post', 'salvar_meta_box_artigos');

// ========================================
// META BOX: AUTORES DO ARTIGO
// ========================================

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

// Mostra a meta box para selecionar autores
function mostrar_meta_box_autores_artigo($post) {
    // Adiciona um nonce
    wp_nonce_field('salvar_autores_artigo', 'autores_artigo_nonce');

    // Obtém todos os membros
    $membros = get_posts(array(
        'post_type' => 'membro',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ));

    // Obtém os autores já selecionados
    $autores_selecionados = get_post_meta($post->ID, '_artigo_autores', true);
    if (!is_array($autores_selecionados)) {
        $autores_selecionados = array();
    }

    echo '<ul>';
    foreach ($membros as $membro) {
        $checked = in_array($membro->ID, $autores_selecionados) ? 'checked' : '';
        echo '<li>';
        echo '<label>';
        echo '<input type="checkbox" name="artigo_autores[]" value="' . $membro->ID . '" ' . $checked . '> ';
        echo esc_html($membro->post_title);
        echo '</label>';
        echo '</li>';
    }
    echo '</ul>';
}

// Salva os autores selecionados
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
        $autores = array_map('intval', $_POST['artigo_autores']);
        update_post_meta($post_id, '_artigo_autores', $autores);
    } else {
        // Se nenhum autor for selecionado, remove o meta
        delete_post_meta($post_id, '_artigo_autores');
    }
}
add_action('save_post', 'salvar_autores_artigo');

// ========================================
// META BOX: EVENTO DO ARTIGO (TAXONOMIA)
// ========================================

// Remove a meta box padrão da taxonomia 'evento_artigo'
function remover_meta_box_evento_artigo() {
    remove_meta_box('tagsdiv-evento_artigo', 'artigo', 'normal');
}
add_action('admin_menu', 'remover_meta_box_evento_artigo', 999);

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
add_action('add_meta_boxes', 'adicionar_meta_box_evento_artigo_personalizada');

// Mostra a meta box personalizada como um select dropdown
function mostrar_meta_box_evento_artigo_checklist($post) {
    $taxonomy = 'evento_artigo';
    $tax = get_taxonomy($taxonomy);
    $terms = get_terms($taxonomy, array('hide_empty' => false));
    $post_terms = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));

    $selected_term_id = empty($post_terms) ? '' : $post_terms[0];

    echo '<select name="tax_input[' . $taxonomy . '][]" id="' . $taxonomy . '_select">';
    echo '<option value="">Selecione um Evento</option>';
    foreach ($terms as $term) {
        $selected = selected($selected_term_id, $term->term_id, false);
        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
    }
    echo '</select>';
}

// ========================================
// META BOX: LINK EXTERNO DO ARTIGO
// ========================================

// Adicionar meta box para link externo do artigo
function adicionar_meta_box_link_externo() {
    add_meta_box(
        'artigo_link_externo',
        'Link Externo do Artigo',
        'render_meta_box_link_externo',
        'artigo',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'adicionar_meta_box_link_externo');

// Renderizar o campo
function render_meta_box_link_externo($post) {
    wp_nonce_field('salvar_link_externo', 'link_externo_nonce');
    $link_externo = get_post_meta($post->ID, '_link_externo_artigo', true);
    ?>
    <div style="padding: 10px 0;">
        <label for="link_externo_artigo" style="display: block; margin-bottom: 5px; font-weight: 600;">
            URL do Artigo:
        </label>
        <input 
            type="url" 
            id="link_externo_artigo" 
            name="link_externo_artigo" 
            value="<?php echo esc_url($link_externo); ?>" 
            style="width: 100%; padding: 5px;" 
            placeholder="https://exemplo.com/artigo.pdf"
        >
        <p class="description" style="margin-top: 5px;">
            Digite aqui o link do repositório onde o artigo está hospedado.
        </p>
    </div>
    <?php
}

// Salvar o campo
function salvar_link_externo($post_id) {
    // Verifica o nonce
    if (!isset($_POST['link_externo_nonce']) || 
        !wp_verify_nonce($_POST['link_externo_nonce'], 'salvar_link_externo')) {
        return;
    }

    // Verifica se é autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verifica permissões
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Salva ou remove o link externo
    if (isset($_POST['link_externo_artigo']) && !empty($_POST['link_externo_artigo'])) {
        $link = esc_url_raw($_POST['link_externo_artigo']);
        update_post_meta($post_id, '_link_externo_artigo', $link);
    } else {
        delete_post_meta($post_id, '_link_externo_artigo');
    }
}
add_action('save_post', 'salvar_link_externo');