<?php

function registrar_meta_boxes_membros()
{
    add_meta_box('redes_sociais_membro', 'Redes Sociais', 'render_meta_box_redes_sociais', 'membro', 'normal', 'high');
}
add_action('add_meta_boxes', 'registrar_meta_boxes_membros');

function render_meta_box_redes_sociais($post)
{
    $email = get_post_meta($post->ID, 'email', true);
    $instagram = get_post_meta($post->ID, 'instagram_url', true);
    $linkedin = get_post_meta($post->ID, 'linkedin_url', true);
    $lattes = get_post_meta($post->ID, 'lattes_url', true);
    $github = get_post_meta($post->ID, 'github_url', true);
    $site = get_post_meta($post->ID, 'site_url', true);
?>
    <?php wp_nonce_field('membro_redes_sociais', 'membro_redes_sociais_nonce'); ?>
    <p>
        <label for="email"><strong>E-mail:</strong></label><br>
        <input type="email" name="email" id="email" value="<?php echo esc_attr($email); ?>" style="width:100%;">
    </p>
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

function salvar_meta_boxes_membros($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (!isset($_POST['membro_redes_sociais_nonce']) || !wp_verify_nonce($_POST['membro_redes_sociais_nonce'], 'membro_redes_sociais')) return;

    if (isset($_POST['email'])) {
        update_post_meta($post_id, 'email', sanitize_email($_POST['email']));
    }
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

