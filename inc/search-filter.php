<?php
/**
 * Filtros de busca para o tema
 */

// Limita a busca geral do site apenas a posts (não inclui páginas, CPTs, etc)
function limitar_busca_apenas_posts($query) {
    if ($query->is_search() && !is_admin()) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_action('pre_get_posts', 'limitar_busca_apenas_posts');


function buscar_apenas_artigos($search, $query) {
    global $wpdb;
    
    if (!$query->is_main_query() || empty($search)) {
        return $search;
    }
    
    $post_type = $query->get('post_type');
    if ($post_type !== 'artigo') {
        return $search;
    }
    
    return $search;
}