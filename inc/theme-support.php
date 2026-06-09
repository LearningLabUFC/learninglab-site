<?php

function learninglab_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'learninglab_theme_support');

function learninglab_block_author_enumeration()
{
    if (is_author() && isset($_GET['author'])) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('template_redirect', 'learninglab_block_author_enumeration', 1);