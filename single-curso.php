<?php get_header(); ?>

<main>
    <?php
    while (have_posts()) :
        the_post();
    ?>

        <article>

            <div class="container-header">

                <div class="content-header">
                    <div class="title">
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>
            </div>

            <div class="container"><?php the_content(); ?></div>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>