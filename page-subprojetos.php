<?php


get_header(); ?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Nossos Subprojetos</h1>
        </div>
    </div>
</div>

<div class="container">

    <div class="subprojetos-grid">
        <?php
        $args = array(
            'post_type'      => 'subprojetos',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        );

        $query_subprojetos = new WP_Query( $args );

        if ( $query_subprojetos->have_posts() ) :
            while ( $query_subprojetos->have_posts() ) : $query_subprojetos->the_post(); ?>

                <div class="subprojeto-card">
                    <a href="<?php the_permalink(); ?>" class="subprojeto-link">
                        <div class="subprojeto-content">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium' ); ?>
                            <?php endif; ?>
                            <div class="subprojeto-texto">
                                <h3><?php the_title(); ?></h3>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </a>
                </div>

            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Nenhum subprojeto encontrado no momento.</p>
        <?php endif; ?>
    </div>

</div>

<?php get_footer(); ?>