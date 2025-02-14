<?php
get_header();
?>

<div class="container-blog">
    <section class="container-inicial-blog">
        <h1>Exibindo resultados para "<?php echo get_search_query(); ?>"</h1>
    </section>

    <?php
    // Obtém a página atual
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if (have_posts()) :
        // Post em destaque apenas na primeira página
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
    ?>
        <div class="content">
            <p>
                <?php _e('Nenhum resultado encontrado. Tente fazer outra busca ou considere dar uma olhada em', 'textdomain'); ?>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                    <?php _e('nossos posts mais recentes', 'textdomain'); ?>
                </a>.
            </p>
        </div>

    <?php
    endif;
    ?>
</div>


<?php
get_footer();
?>