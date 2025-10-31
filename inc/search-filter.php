<?php 

function limitar_busca_apenas_posts($query) {
    if ($query->is_search() && !is_admin()) {
        $query->set('post_type', 'post');
    }
    return $query;
}