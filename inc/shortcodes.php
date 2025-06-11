<?php 

// Shortcode para membros

function membros_shortcode($atts) {
    // Extrair os atributos do shortcode e aceitar múltiplos slugs separados por vírgula
    $atts = shortcode_atts(
        array(
            'slugs' => '', // Atributo para receber os slugs
        ),
        $atts,
        'membros'
    );

    // Converter a string de slugs em um array
    $slugs = array_map('trim', explode(',', $atts['slugs']));

    // Se não houver slugs, retorna vazio
    if (empty($slugs)) {
        return '';
    }

    // Iniciar a saída HTML
    $output = '<div class="membros-grid">';

    // Contar quantos membros são retornados
    $membros_count = 0;

    // Loop através dos slugs
    foreach ($slugs as $slug) {
        // Buscar o post pelo slug
        $args = array(
            'name'        => $slug,
            'post_type'   => 'membro', // Altere para o post type correto, se necessário
            'post_status' => 'publish',
            'numberposts' => 1,
        );
        $membro = get_posts($args);

        // Se o post existir, gerar a estrutura
        if ($membro) {
            $post = $membro[0];
            $nome = get_the_title($post->ID);
            $imagem = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'attachment-thumbnail size-thumbnail wp-post-image'));

            $output .= '<div class="membro-item">';
            $output .= '<div class="membro-avatar">' . $imagem . '</div>';
            $output .= '<h4 class="membro-nome">' . esc_html($nome) . '</h4>';
            $output .= '</div>';

            // Incrementa a contagem de membros
            $membros_count++;
        }
    }

    // Adicionar a classe dependendo do número de membros
    if ($membros_count === 2) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-2">', $output);
    } elseif ($membros_count === 3) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-3">', $output);
    } elseif ($membros_count === 4) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-4">', $output);
    } elseif ($membros_count === 5) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-5">', $output);
    } elseif ($membros_count > 5) {
        $output = str_replace('<div class="membros-grid">', '<div class="membros-grid limite-mais-de-5">', $output);
    }

    // Fechar a estrutura da grid
    $output .= '</div>';

    // Retornar o HTML gerado
    return $output;
}
add_shortcode('membros', 'membros_shortcode');


// Shortcode para instrutores nas páginas de cursos

function instrutor_shortcode($atts, $content = null) {
    // Define os atributos com valores padrão
    $atts = shortcode_atts(array(
        'nome' => 'Nome do Instrutor',
        'imagem' => '', // URL ou nome da imagem na biblioteca
        'descricao' => ''
    ), $atts, 'instrutor');

    // Se for o nome de uma imagem da biblioteca, pega a URL
    if (!filter_var($atts['imagem'], FILTER_VALIDATE_URL)) {
        $img = get_page_by_title($atts['imagem'], OBJECT, 'attachment');
        if ($img) {
            $atts['imagem'] = wp_get_attachment_url($img->ID);
        }
    }

    // HTML do bloco
    ob_start();
    ?>
    <div class="instrutor-bloco">
        <?php if ($atts['imagem']) : ?>
            <div class="instrutor-imagem">
                <img src="<?php echo esc_url($atts['imagem']); ?>" alt="<?php echo esc_attr($atts['nome']); ?>">
            </div>
        <?php endif; ?>
        <div class="instrutor-info">
            <h2><?php echo esc_html($atts['nome']); ?></h2>
            <p><?php echo esc_html($atts['descricao']); ?></p>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('instrutor', 'instrutor_shortcode');