<?php 

function learninglab_menus()
{
    $locations = array(
        'primary' => "Cabeçalho",
        'footer' => "Rodapé"
    );
    register_nav_menus($locations);
}
add_action('init', 'learninglab_menus');