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
    wp_nonce_field('salvar_meta_box_artigos', 'artigos_nonce');

    // Removemos Ano e Evento daqui, pois agora são taxonomias laterais
    $premio = get_post_meta($post->ID, 'premio', true);

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

    // Salva o campo 'premio' (Ano e Evento foram removidos daqui pois agora são taxonomias)
    if (isset($_POST['premio'])) {
        update_post_meta($post_id, 'premio', sanitize_text_field($_POST['premio']));
    }
}
add_action('save_post', 'salvar_meta_box_artigos');

// ========================================
// META BOX: AUTORES DO ARTIGO
// ========================================

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

// Mostra a meta box para selecionar autores com ordenação (Versão Corrigida para Sidebar)
function mostrar_meta_box_autores_artigo($post) {
    // Adiciona o nonce de segurança
    wp_nonce_field('salvar_autores_artigo', 'autores_artigo_nonce');

    // Obtém todos os membros
    $todos_membros = get_posts(array(
        'post_type' => 'membro',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    ));

    // Obtém os IDs dos autores já salvos
    $autores_selecionados_ids = get_post_meta($post->ID, '_artigo_autores', true);
    if (!is_array($autores_selecionados_ids)) {
        $autores_selecionados_ids = array();
    }
    ?>

    <style>
        /* Estilos ajustados para a barra lateral estreita */
        #container-autores-wrapper {
            margin-top: 10px;
        }
        #lista-autores-selecionados {
            list-style: none;
            margin: 0 0 15px 0;
            padding: 0;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 40px; /* Garante altura mesmo vazia */
        }
        #lista-autores-selecionados li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px;
            border-bottom: 1px solid #eee;
            background: #fff;
            margin: 0;
            cursor: move;
        }
        #lista-autores-selecionados li:last-child {
            border-bottom: none;
        }
        #lista-autores-selecionados li:hover {
            background: #f1f1f1;
        }
        .autor-handle {
            color: #ccc;
            margin-right: 8px;
            cursor: grab;
        }
        .autor-nome {
            flex-grow: 1;
            font-size: 13px;
            font-weight: 500;
        }
        .remove-autor {
            color: #d63638;
            cursor: pointer;
            padding: 2px;
        }
        .remove-autor:hover {
            color: #ff0000;
        }
        /* Layout dos controles */
        .controles-adicao {
            display: block; /* Garante que fiquem um abaixo do outro */
        }
        #select-novos-autores {
            width: 100%;
            margin-bottom: 8px;
            box-sizing: border-box;
        }
        #btn-add-autor {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
        .placeholder-msg {
            padding: 10px;
            color: #999;
            font-size: 12px;
            text-align: center;
            font-style: italic;
        }
    </style>

    <script>
    jQuery(document).ready(function($){
        var lista = $('#lista-autores-selecionados');

        // Ativa o Drag & Drop
        lista.sortable({
            handle: '.autor-handle, .autor-nome',
            placeholder: "ui-state-highlight",
            update: function() {
                checkEmpty();
            }
        });

        // Verifica se a lista está vazia para mostrar mensagem
        function checkEmpty() {
            if(lista.children('li').length === 0) {
                if(lista.find('.placeholder-msg').length === 0) {
                    lista.append('<div class="placeholder-msg">Nenhum autor selecionado. Adicione abaixo.</div>');
                }
            } else {
                lista.find('.placeholder-msg').remove();
            }
        }
        
        // Roda ao carregar para verificar estado inicial
        checkEmpty();

        // Botão Adicionar
        $('#btn-add-autor').click(function(e){
            e.preventDefault(); // Impede de salvar o post ao clicar
            
            var select = $('#select-novos-autores');
            var id = select.val();
            var nome = select.find('option:selected').text();

            if(!id) {
                alert('Por favor, selecione um membro na lista.');
                return;
            }

            // Evita duplicatas checando se o ID já existe na lista
            if(lista.find('input[value="'+id+'"]').length > 0) {
                alert('Este autor já está na lista.');
                return;
            }

            // Remove mensagem de vazio se existir
            lista.find('.placeholder-msg').remove();

            // HTML do item
            var html = '<li>';
            html += '<span class="dashicons dashicons-menu autor-handle"></span> ';
            html += '<span class="autor-nome">' + nome + '</span>';
            html += '<input type="hidden" name="artigo_autores[]" value="'+id+'">';
            html += '<span class="dashicons dashicons-trash remove-autor" title="Remover"></span>';
            html += '</li>';

            lista.append(html);
            select.val(''); // Reseta o select
        });

        // Botão Remover
        $(document).on('click', '.remove-autor', function(){
            $(this).closest('li').remove();
            checkEmpty();
        });
    });
    </script>

    <div id="container-autores-wrapper">
        <label><strong>Autores Selecionados:</strong></label>
        
        <ul id="lista-autores-selecionados">
            <?php foreach ($autores_selecionados_ids as $id) : 
                $nome = get_the_title($id);
                if(!$nome) continue;
            ?>
                <li>
                    <span class="dashicons dashicons-menu autor-handle"></span>
                    <span class="autor-nome"><?php echo esc_html($nome); ?></span>
                    <input type="hidden" name="artigo_autores[]" value="<?php echo $id; ?>">
                    <span class="dashicons dashicons-trash remove-autor" title="Remover"></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="controles-adicao">
            <select id="select-novos-autores">
                <option value="">Selecione um membro...</option>
                <?php foreach ($todos_membros as $membro) : ?>
                    <option value="<?php echo $membro->ID; ?>">
                        <?php echo esc_html($membro->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button class="button button-primary" id="btn-add-autor">
                + Adicionar Autor
            </button>
        </div>
        
        <p class="description">
            O primeiro da lista será considerado o <strong>autor principal</strong>.
        </p>
    </div>
    <?php
}

function salvar_autores_artigo($post_id) {
    if (!isset($_POST['autores_artigo_nonce']) || !wp_verify_nonce($_POST['autores_artigo_nonce'], 'salvar_autores_artigo')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    if (isset($_POST['artigo_autores'])) {
        $autores = array_map('intval', $_POST['artigo_autores']);
        update_post_meta($post_id, '_artigo_autores', $autores);
    } else {
        delete_post_meta($post_id, '_artigo_autores');
    }
}
add_action('save_post', 'salvar_autores_artigo');



// ========================================
// META BOX: LINK EXTERNO DO ARTIGO
// ========================================

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

function render_meta_box_link_externo($post) {
    wp_nonce_field('salvar_link_externo', 'link_externo_nonce');
    $link_externo = get_post_meta($post->ID, '_link_externo_artigo', true);
    ?>
    <div style="padding: 10px 0;">
        <label for="link_externo_artigo" style="display: block; margin-bottom: 5px; font-weight: 600;">URL do Artigo:</label>
        <input type="url" id="link_externo_artigo" name="link_externo_artigo" value="<?php echo esc_url($link_externo); ?>" style="width: 100%; padding: 5px;" placeholder="https://exemplo.com/artigo.pdf">
        <p class="description" style="margin-top: 5px;">Digite aqui o link do repositório onde o artigo está hospedado.</p>
    </div>
    <?php
}

function salvar_link_externo($post_id) {
    if (!isset($_POST['link_externo_nonce']) || !wp_verify_nonce($_POST['link_externo_nonce'], 'salvar_link_externo')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['link_externo_artigo']) && !empty($_POST['link_externo_artigo'])) {
        $link = esc_url_raw($_POST['link_externo_artigo']);
        update_post_meta($post_id, '_link_externo_artigo', $link);
    } else {
        delete_post_meta($post_id, '_link_externo_artigo');
    }
}
add_action('save_post', 'salvar_link_externo');