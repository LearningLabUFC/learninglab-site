<?php
$alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
$alt_text = !empty($alt) ? $alt : get_the_title();
?>
<img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr($alt_text); ?>">
<div class="descricao">
    <h1><?php the_title(); ?></h1>
    <?php the_excerpt(); ?>
</div>
