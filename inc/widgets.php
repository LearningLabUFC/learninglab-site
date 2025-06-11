<?php

function learninglab_widget_areas()
{
    // Primeira área de widget no rodapé
    register_sidebar(
        array(
            'name'          => 'Rodapé - Área 1',
            'id'            => 'footer-1',
            'description'   => 'Primeira área de widget do rodapé',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
        )
    );

    // Segunda área de widget no rodapé
    register_sidebar(
        array(
            'name'          => 'Rodapé - Área 2',
            'id'            => 'footer-2',
            'description'   => 'Segunda área de widget do rodapé',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
        )
    );
}

add_action('widgets_init', 'learninglab_widget_areas');