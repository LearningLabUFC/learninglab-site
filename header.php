<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    wp_head();
    ?>
</head>

<body>
    <div class="cabecalho">
        <header>

            <?php
            if (function_exists('the_custom_logo')) {
                the_custom_logo();
            } else {
            ?>
                <a href="<?php echo home_url('/'); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/imgs/logo-branca.png" alt="Logo Alternativa">
                </a>
            <?php
            }
            ?>

            <nav>
                <input type="checkbox" id="checkbox-menu">
                <div class="icone-menu-mobile">
                    <label class="label-header" for="checkbox-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                </div>
                <ul class="nav-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'menu' => 'primary',
                            'container' => '',
                            'theme_location' => 'primary',
                            'items_wrap' => '%3$s',
                            'depth' => 2
                        )
                    );
                    ?>

                    <li class="search-container">
                        <button id="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                        <form id="search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="search-wrapper">
                                <input type="search" name="s" placeholder="Digite sua busca..." required>
                                <button type="submit"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </nav>
        </header>
    </div>

