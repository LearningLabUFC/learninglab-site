<?php


// Adicionar campos personalizados ao perfil do usuário
function learninglab_add_author_fields($user) {
    ?>
    <h3>Informações Adicionais do Autor</h3>
    
    <table class="form-table">
        <tr>
            <th><label for="user_title">Título/Cargo</label></th>
            <td>
                <input type="text" name="user_title" id="user_title" value="<?php echo esc_attr(get_the_author_meta('user_title', $user->ID)); ?>" class="regular-text" />
                <br />
                <span class="description">Ex: Desenvolvedor Full Stack, Designer, etc.</span>
            </td>
        </tr>
        
        <tr>
            <th><label for="facebook">Facebook</label></th>
            <td>
                <input type="url" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" class="regular-text" />
                <br />
                <span class="description">URL completa do perfil no Facebook</span>
            </td>
        </tr>
        
        <tr>
            <th><label for="twitter">Twitter</label></th>
            <td>
                <input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" />
                <br />
                <span class="description">URL completa do perfil no Twitter</span>
            </td>
        </tr>
        
        <tr>
            <th><label for="instagram">Instagram</label></th>
            <td>
                <input type="url" name="instagram" id="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>" class="regular-text" />
                <br />
                <span class="description">URL completa do perfil no Instagram</span>
            </td>
        </tr>
        
        <tr>
            <th><label for="linkedin">LinkedIn</label></th>
            <td>
                <input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text" />
                <br />
                <span class="description">URL completa do perfil no LinkedIn</span>
            </td>
        </tr>
    </table>
    <?php
}

// Adicionar os campos no perfil do usuário
add_action('show_user_profile', 'learninglab_add_author_fields');
add_action('edit_user_profile', 'learninglab_add_author_fields');

// Salvar os campos personalizados
function learninglab_save_author_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    
    $fields = array('user_title', 'facebook', 'twitter', 'instagram', 'linkedin');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_user_meta($user_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

// Salvar os campos quando o perfil for atualizado
add_action('personal_options_update', 'learninglab_save_author_fields');
add_action('edit_user_profile_update', 'learninglab_save_author_fields');