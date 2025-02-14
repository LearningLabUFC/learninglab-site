<footer>

    <div class="conteiner-footer">

        <div>
            <?php
            dynamic_sidebar('footer-2')
            ?>
        </div>

        <div class="social-media">
            <h4>Redes sociais</h4>
            <?php
            $social_networks = array(
                'facebook'  => 'fab fa-facebook-f',
                'twitter'   => 'fab fa-twitter',
                'instagram' => 'fab fa-instagram',
                'linkedin'  => 'fab fa-linkedin-in',
                'youtube'   => 'fab fa-youtube',
                'tiktok'   => 'fab fa-tiktok',
                'telegram'   => 'fab fa-telegram'


            );

            foreach ($social_networks as $key => $class) {
                $url = get_theme_mod("social_media_{$key}");
                if ($url) {
                    echo '<a href="' . esc_url($url) . '" target="_blank" class="social-icon">';
                    echo '<i class="' . esc_attr($class) . '"></i>';
                    echo '</a>';
                }
            }
            ?>
        </div>




        <div class="footer-menu">
            <?php
            // Obtém o objeto do menu baseado no slug ou local de registro
            $menu_location = 'footer'; // Substitua pelo local do menu
            $locations = get_nav_menu_locations();

            if (isset($locations[$menu_location])) {
                $menu_id = $locations[$menu_location];
                $menu_object = wp_get_nav_menu_object($menu_id);

                // Exibe o título do menu
                if ($menu_object) {
                    echo '<h4>' . esc_html($menu_object->name) . '</h4>';
                }

                // Exibe o menu
                wp_nav_menu(
                    array(
                        'menu' => $menu_object->slug,
                        'container' => '',
                        'theme_location' => $menu_location,
                        'items_wrap' => '<ul id="" class="nav-menu-footer">%3$s</ul>',
                        'depth' => 2
                    )
                );
            } else {
                echo '<p>Menu não encontrado.</p>';
            }
            ?>
        </div>


        <div>
            <?php
            dynamic_sidebar('footer-1')
            ?>
        </div>

    </div>
</footer>


<?php
wp_footer();
?>

</body>

</html>