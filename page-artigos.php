<?php
/*
 * Página de Artigos
 */
get_header();
?>

<div class="container-header">
  <div class="content-header">
    <div class="title">
      <h1>Confira nossos artigos</h1>
    </div>
  </div>
</div>

<div class="container">
  <?php
  // Parâmetros da URL
  $ano_get    = isset($_GET['ano']) ? sanitize_text_field($_GET['ano']) : '';
  $autor_get  = isset($_GET['autor']) ? sanitize_text_field($_GET['autor']) : '';
  $evento_get = isset($_GET['evento']) ? sanitize_text_field($_GET['evento']) : '';
  $buscar_get = isset($_GET['buscar']) ? sanitize_text_field($_GET['buscar']) : '';
  ?>

  <form id="filter-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
    <div class="artigos-filters">

      <!-- Ano -->
      <div class="filter-group">
        <label for="filter-ano">Ano</label>
        <select id="filter-ano" name="ano">
          <option value="">Todos</option>
          <?php
          for ($y = 2025; $y >= 2021; $y--) {
            $selected = ($ano_get == $y) ? 'selected' : '';
            echo '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
          }
          ?>
        </select>
      </div>

      <!-- Autor -->
      <div class="filter-group">
        <label for="filter-autor">Autor</label>
        <select id="filter-autor" name="autor">
          <option value="">Todos os autores</option>
          <?php
          $autores = get_posts(array(
            'post_type' => 'membro',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
          ));
          foreach ($autores as $autor) {
            $selected = ($autor_get == $autor->ID) ? 'selected' : '';
            echo '<option value="' . $autor->ID . '" ' . $selected . '>' . esc_html($autor->post_title) . '</option>';
          }
          ?>
        </select>
      </div>

      <!-- Evento -->
      <div class="filter-group">
        <label for="filter-evento">Evento</label>
        <select id="filter-evento" name="evento">
          <option value="">Todos os eventos</option>
          <?php
          $eventos = get_terms(array(
            'taxonomy' => 'evento_artigo',
            'hide_empty' => false, // Alterado para false para mostrar todos
          ));
          if (!is_wp_error($eventos) && !empty($eventos)) {
            foreach ($eventos as $evento) {
              $selected = ($evento_get == $evento->slug) ? 'selected' : '';
              echo '<option value="' . esc_attr($evento->slug) . '" ' . $selected . '>' . esc_html($evento->name) . '</option>';
            }
          }
          ?>
        </select>
      </div>

      <!-- Buscar -->
      <div class="filter-group search-group">
        <label for="filter-buscar">Buscar</label>
        <input type="text" id="filter-buscar" name="buscar" placeholder="Título ou palavra-chave" value="<?php echo esc_attr($buscar_get); ?>">
      </div>

      <button type="submit" class="filter-btn">Filtrar</button>
    </div>
  </form>

  <?php
  // Query WP com filtros - CORRIGIDA
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

  $args = array(
    'post_type' => 'artigo', // Apenas artigos, não posts do blog
    'posts_per_page' => 5,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
  );

  $meta_query = array('relation' => 'AND');

  // Ano
  if ($ano_get) {
    $meta_query[] = array(
      'key' => 'ano_publicacao',
      'value' => $ano_get,
      'compare' => '='
    );
  }

  // Autor
  if ($autor_get) {
    $meta_query[] = array(
      'key' => '_artigo_autores',
      'value' => '"' . $autor_get . '"', // Busca serializada
      'compare' => 'LIKE'
    );
  }

  if (count($meta_query) > 1) {
    $args['meta_query'] = $meta_query;
  }

  // Evento (taxonomia)
  if ($evento_get) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'evento_artigo',
        'field'    => 'slug',
        'terms'    => $evento_get,
      ),
    );
  }

  // Busca - CORRIGIDA para buscar apenas em artigos
  if ($buscar_get) {
    $args['s'] = $buscar_get;
    // Garante que só busca em artigos
    add_filter('posts_search', 'buscar_apenas_artigos', 10, 2);
  }

  $artigos_query = new WP_Query($args);

  // Remove o filtro após a query
  if ($buscar_get) {
    remove_filter('posts_search', 'buscar_apenas_artigos', 10);
  }
  ?>

  <div class="artigos-container" id="artigos-results">
    <?php
    if ($artigos_query->have_posts()) :
      while ($artigos_query->have_posts()) : $artigos_query->the_post();
        $ano = get_post_meta(get_the_ID(), 'ano_publicacao', true) ?: date('Y');
        $premio = get_post_meta(get_the_ID(), 'premio', true);
        $link_externo = get_post_meta(get_the_ID(), '_link_externo_artigo', true);
        
        // Usa link externo se disponível, senão usa permalink
        $link_artigo = !empty($link_externo) ? $link_externo : get_permalink();
        $target_link = !empty($link_externo) ? '_blank' : '_self';
        $rel_link = !empty($link_externo) ? 'noopener noreferrer' : '';
        
        $eventos_term = get_the_terms(get_the_ID(), 'evento_artigo');
        if (!empty($eventos_term) && !is_wp_error($eventos_term)) {
          $evento_slug = $eventos_term[0]->slug;
          $evento_name = $eventos_term[0]->name;
        } else {
          $evento_slug = 'sbc-brasil';
          $evento_name = 'SBC BRASIL';
        }
    ?>
    <article class="artigo-card">
      <div class="artigo-badges">
        <span class="badge ano-badge"><?php echo esc_html($ano); ?></span>
        <span class="badge evento-badge"><?php echo esc_html($evento_name); ?></span>
        <?php if ($premio) : ?>
          <span class="badge premio-badge">🥇 <?php echo esc_html($premio); ?></span>
        <?php endif; ?>

      </div>
      <div class="artigo-content">
        <h2 class="artigo-title">
          <a href="<?php echo esc_url($link_artigo); ?>" 
             target="<?php echo $target_link; ?>" 
             <?php if ($rel_link) echo 'rel="' . $rel_link . '"'; ?>>
            <?php the_title(); ?>
          </a>
        </h2>
        <div class="artigo-excerpt">
          <?php 
          $content = strip_shortcodes(strip_tags(get_the_content()));
          $paragraphs = array_filter(explode("\n\n", $content));
          foreach(array_slice($paragraphs, 0, 2) as $p) {
            echo '<p>' . trim($p) . '</p>';
          }
          ?>
        </div>
        <?php
        $autores_ids = get_post_meta(get_the_ID(), '_artigo_autores', true);
        if (!empty($autores_ids) && is_array($autores_ids)) :
        ?>
        <div class="artigo-autores">
          <?php foreach ($autores_ids as $autor_id) :
            $autor_nome = get_the_title($autor_id);
            $autor_foto_url = get_the_post_thumbnail_url($autor_id, 'thumbnail');
          ?>
          <div class="autor-avatar">
            <div class="avatar-circle">
              <?php if ($autor_foto_url) : ?>
                <img src="<?php echo esc_url($autor_foto_url); ?>" alt="<?php echo esc_attr($autor_nome); ?>">
              <?php else : ?>
                <?php echo strtoupper(substr($autor_nome, 0, 1)); ?>
              <?php endif; ?>
            </div>
            <span class="autor-nome"><?php echo esc_html($autor_nome); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </article>
    <?php
      endwhile;
      wp_reset_postdata();
    else : ?>
      <p class="no-articles">Não há artigos disponíveis no momento.</p>
    <?php endif; ?>
  </div>

  <?php
  // Paginação mantendo filtros
  if ($artigos_query->max_num_pages > 1) {
    echo '<div class="artigos-pagination">';
    echo paginate_links(array(
      'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $artigos_query->max_num_pages,
      'prev_text' => __('&laquo; Anterior'),
      'next_text' => __('Próximo &raquo;'),
      'add_args' => array_filter(array(
        'ano' => $ano_get,
        'autor' => $autor_get,
        'evento' => $evento_get,
        'buscar' => $buscar_get,
      )),
    ));
    echo '</div>';
  }
  ?>
</div>

<?php get_footer(); ?>