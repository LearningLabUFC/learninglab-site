<?php
// Carrega os arquivos do tema a partir da pasta inc/

// Registro de funções suportadas pelo tema
require_once get_template_directory() . '/inc/theme-support.php';

// Registro dos menus
require_once get_template_directory() . '/inc/menus.php';

// Registro de estilos e scripts
require_once get_template_directory() . '/inc/styles-scripts.php';

// Registro de áreas de widgets
require_once get_template_directory() . '/inc/widgets.php';

// Registro de Custom Post Types
require_once get_template_directory() . '/inc/custom-post-types.php';

// Registro de campos personalizados
require_once get_template_directory() . '/inc/custom-fields.php';

// Registro de taxonomias personalizadas
require_once get_template_directory() . '/inc/taxonomies.php';

// Registro de shortcodes
require_once get_template_directory() . '/inc/shortcodes.php';

// Configurações do personalizador
require_once get_template_directory() . '/inc/customizer.php';

// Filtro para limitar busca apenas a posts
require_once get_template_directory() . '/inc/search-filter.php';

// Adição de metatags Open Graph no <head>
require_once get_template_directory() . '/inc/og-tags.php';

// Campos personalizados do autor
require_once get_template_directory() . '/inc/author-fields.php';

// Funções auxiliares
require_once get_template_directory() . '/inc/helpers.php';