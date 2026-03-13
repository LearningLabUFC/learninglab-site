<?php 

function is_membro_formado($post_id) {
    return has_term('formado', 'tipo_de_membro', $post_id);
}

function learninglab_render_membro_socials($post_id) {
    $instagram = get_post_meta($post_id, 'instagram_url', true);
    $linkedin = get_post_meta($post_id, 'linkedin_url', true);
    $lattes = get_post_meta($post_id, 'lattes_url', true);

    if ($instagram || $linkedin || $lattes) {
        echo '<div class="membro-redes-sociais">';
        if ($linkedin) {
            echo '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>';
        }
        if ($instagram) {
            echo '<a href="' . esc_url($instagram) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="Instagram"><i class="fa-brands fa-instagram"></i></a>';
        }
        if ($lattes) {
            echo '<a href="' . esc_url($lattes) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="Currículo Lattes"><i class="fa-solid fa-address-card"></i></a>';
        }
        echo '</div>';
    }
}