<?php
/**
 * Template Part: Card unificado
 * Usado em: Blog (home.php), Cursos (page-nossos-cursos.php), Subprojetos (page-subprojetos.php)
 *
 * Variáveis esperadas via $args (set_query_var / get_template_part):
 *   - 'show_badge'        => bool   (exibir badge de status, padrão false)
 *   - 'badge_text'        => string (texto do badge)
 *   - 'badge_class'       => string (classe CSS: 'aberto' ou 'em-breve')
 */

$show_badge  = isset($args['show_badge']) ? $args['show_badge'] : false;
$badge_text  = isset($args['badge_text']) ? $args['badge_text'] : '';
$badge_class = isset($args['badge_class']) ? $args['badge_class'] : '';
?>

<article class="card">
    <a href="<?php the_permalink(); ?>" class="card-link">
        <div class="card-thumb">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
        </div>
        <?php if ($show_badge && $badge_text) : ?>
            <div class="card-footer">
                <span class="card-badge <?php echo esc_attr($badge_class); ?>">
                    <?php echo esc_html($badge_text); ?>
                </span>
            </div>
        <?php endif; ?>
    </a>
</article>
