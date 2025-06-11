<?php 

function is_membro_formado($post_id) {
    return has_term('formado', 'tipo_de_membro', $post_id);
}