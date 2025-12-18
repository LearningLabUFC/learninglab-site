<?php

function limitar_busca_apenas_posts($query)
{
    if ($query->is_search() && !is_admin() && $query->is_main_query()) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_action('pre_get_posts', 'limitar_busca_apenas_posts');
