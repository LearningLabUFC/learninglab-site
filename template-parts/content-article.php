<article>

    <div class="container-header">
        
        <div class="content-header">
            <div class="title">
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="post-data">
                <span class="author"><i class="fa-solid fa-circle-user"></i> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?> </a> </span>
                 •
                <span class="date"><?php the_date(); ?></span>, às <span class="time"><?php the_time(); ?></span>
            </div>
        </div>
    </div>


    <?php
    // Condicional para exibir a imagem de destaque se a opção estiver marcada
    if (get_post_meta(get_the_ID(), '_featured_image_display_option', true) === 'yes') {
    ?>
        <div class="featured-image">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php
    }
    ?>

    <div class="content"><?php the_content(); ?></div>

</article>

