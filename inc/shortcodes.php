<?php

function membros_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'slugs' => '',
        ),
        $atts,
        'membros'
    );

    $slugs = array_map('trim', explode(',', $atts['slugs']));

    if (empty($slugs)) {
        return '';
    }

    $output = '<div class="membros-grid">';

    $membros_count = 0;

    foreach ($slugs as $slug) {
        $args = array(
            'name'        => $slug,
            'post_type'   => 'membro',
            'post_status' => 'publish',
            'numberposts' => 1,
        );
        $membro = get_posts($args);

        if ($membro) {
            $post = $membro[0];
            $nome = get_the_title($post->ID);
            $imagem = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'attachment-thumbnail size-thumbnail wp-post-image'));

            $output .= '<div class="membro-item">';
            $output .= '<div class="membro-avatar">' . $imagem . '</div>';
            $output .= '<h4 class="membro-nome">' . esc_html($nome) . '</h4>';
            $output .= '</div>';

            $membros_count++;
        }
    }
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

    $output .= '</div>';

    return $output;
}
add_shortcode('membros', 'membros_shortcode');



function instrutor_shortcode($atts, $content = null)
{
    $atts = shortcode_atts(array(
        'nome' => 'Nome do Instrutor',
        'imagem' => '',
        'descricao' => ''
    ), $atts, 'instrutor');

    if (!filter_var($atts['imagem'], FILTER_VALIDATE_URL)) {
        $img = get_page_by_title($atts['imagem'], OBJECT, 'attachment');
        if ($img) {
            $atts['imagem'] = wp_get_attachment_url($img->ID);
        }
    }

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

function color_box_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'text'     => '28 artigos publicados',
            'bg_color' => '#f2637e',
            'color'    => 'white',
        ),
        $atts,
        'caixa_destaque'
    );

    $bg_color = esc_attr($atts['bg_color']);
    $text_color = esc_attr($atts['color']);

    $style_container = "background-color: {$bg_color}; min-height: 13.5rem; display: flex; align-items: center; justify-content: center; border-radius: 15px;";
    $style_text = "margin-bottom: 0; font-weight: bold; padding: 2rem; color: white !important; text-align: center;";
    $output = '<div class="custom-box" style="' . $style_container . '">';
    $output .= '<p style="' . $style_text . '">' . esc_html($atts['text']) . '</p>';
    $output .= '</div>';

    return $output;
}
add_shortcode('caixa_destaque', 'color_box_shortcode');
