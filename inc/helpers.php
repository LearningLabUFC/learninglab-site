<?php 

function is_membro_formado($post_id) {
    return has_term('formado', 'tipo_de_membro', $post_id);
}

/**
 * Exibe o nome do membro em duas linhas:
 * Linha 1: todos os nomes exceto o último
 * Linha 2: último nome (sobrenome)
 */
function learninglab_membro_nome_duas_linhas() {
    $nome_completo = get_the_title();
    $partes = explode(' ', trim($nome_completo));

    if (count($partes) <= 1) {
        echo '<span class="membro-primeiro-nome">' . esc_html($nome_completo) . '</span><br><span class="membro-sobrenome">&nbsp;</span>';
        return;
    }

    $sobrenome = array_pop($partes);
    $primeiro_nomes = implode(' ', $partes);

    echo '<span class="membro-primeiro-nome">' . esc_html($primeiro_nomes) . '</span><br><span class="membro-sobrenome">' . esc_html($sobrenome) . '</span>';
}

function learninglab_render_membro_socials($post_id) {
    $email = get_post_meta($post_id, 'email', true);
    $instagram = get_post_meta($post_id, 'instagram_url', true);
    $linkedin = get_post_meta($post_id, 'linkedin_url', true);
    $lattes = get_post_meta($post_id, 'lattes_url', true);
    $github = get_post_meta($post_id, 'github_url', true);
    $site = get_post_meta($post_id, 'site_url', true);

    if ($email || $instagram || $linkedin || $github || $site || $lattes) {
        echo '<div class="membro-redes-sociais">';
        if ($email) {
            echo '<a href="mailto:' . esc_attr($email) . '" class="social-icon" title="E-mail"><i class="fa-solid fa-envelope"></i></a>';
        }
        if ($linkedin) {
            echo '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>';
        }
        if ($instagram) {
            echo '<a href="' . esc_url($instagram) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="Instagram"><i class="fa-brands fa-instagram"></i></a>';
        }
        if ($github) {
            echo '<a href="' . esc_url($github) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="GitHub"><i class="fa-brands fa-github"></i></a>';
        }
        if ($site) {
            echo '<a href="' . esc_url($site) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="Site"><i class="fa-solid fa-globe"></i></a>';
        }
        if ($lattes) {
            echo '<a href="' . esc_url($lattes) . '" target="_blank" rel="noopener noreferrer" class="social-icon" title="Currículo Lattes"><i class="fa-solid fa-address-card"></i></a>';
        }
        echo '</div>';
    }
}
