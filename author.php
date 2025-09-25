<?php


get_header();

// Obter informações do autor
$author_id = get_queried_object_id();
$author_name = get_the_author_meta('display_name', $author_id);
$author_bio = get_the_author_meta('description', $author_id);
$author_avatar = get_avatar_url($author_id, array('size' => 150));
$author_title = get_the_author_meta('user_title', $author_id);

// Redes sociais do autor
$author_facebook = get_the_author_meta('facebook', $author_id);
$author_twitter = get_the_author_meta('twitter', $author_id);
$author_instagram = get_the_author_meta('instagram', $author_id);
$author_linkedin = get_the_author_meta('linkedin', $author_id);
$author_website = get_the_author_meta('url', $author_id);

// Contar posts do autor
$post_count = count_user_posts($author_id, 'post');
?>

<div class="author-header">
    <div class="author-header-content">
        <div class="author-header-avatar">
            <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
        </div>
        <div class="author-header-info">
            <h1><?php echo esc_html($author_name); ?></h1>
            
            <?php if ($author_title) : ?>
                <div class="author-title"><?php echo esc_html($author_title); ?></div>
            <?php endif; ?>
            
            <?php if ($author_bio) : ?>
                <div class="author-header-bio">
                    <?php echo wp_kses_post($author_bio); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($author_facebook || $author_twitter || $author_instagram || $author_linkedin || $author_website) : ?>
                <div class="author-header-social">
                    <?php if ($author_website) : ?>
                        <a href="<?php echo esc_url($author_website); ?>" target="_blank" title="Website">
                            <i class="fas fa-globe"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($author_facebook) : ?>
                        <a href="<?php echo esc_url($author_facebook); ?>" target="_blank" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($author_twitter) : ?>
                        <a href="<?php echo esc_url($author_twitter); ?>" target="_blank" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($author_instagram) : ?>
                        <a href="<?php echo esc_url($author_instagram); ?>" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($author_linkedin) : ?>
                        <a href="<?php echo esc_url($author_linkedin); ?>" target="_blank" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container-blog">
    <div class="author-posts-count">
        <?php 
        if ($post_count > 0) {
            printf(
                _n(
                    '%s publicou %d artigo',
                    '%s publicou %d artigos',
                    $post_count,
                    'textdomain'
                ),
                $author_name,
                $post_count
            );
        } else {
            printf(__('%s ainda não publicou nenhum artigo', 'textdomain'), $author_name);
        }
        ?>
    </div>

    <?php
    if (have_posts()) :
        // Post em destaque apenas na primeira página
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        
        if ($paged == 1) :
            the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="conteiner-destaque">
                <?php get_template_part('template-parts/content', 'featured'); ?>
            </a>
            <?php
        endif;

        // Resetando o loop para os próximos posts
        rewind_posts();

        // Posts regulares
        ?>
        <section class="conteiner-conteudos">
            <?php
            $post_count = 0;
            while (have_posts()) : the_post();
                // Se for primeira página, pula o primeiro post (que já foi exibido como destaque)
                if ($paged == 1 && $post_count == 0) :
                    $post_count++;
                    continue;
                endif;
                ?>
                <a href="<?php the_permalink(); ?>" class="painel-blogs">
                    <?php get_template_part('template-parts/content', 'archive'); ?>
                </a>
                <?php
                $post_count++;
            endwhile;
            ?>
        </section>

        <?php
        // Paginação
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('&laquo; Anterior', 'textdomain'),
            'next_text' => __('Próximo &raquo;', 'textdomain'),
        ));
    else :
        echo '<div class="content"><p>Este autor ainda não publicou nenhum post.</p></div>';
    endif;
    ?>
</div>

<?php get_footer(); ?>