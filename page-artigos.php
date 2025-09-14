<?php
/*
 * página de artigos 
*/

get_header(); ?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Confira nossos artigos</h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="artigos-filters">
        <div class="filter-group">
            <label for="filter-ano">Ano</label>
            <select id="filter-ano" name="ano">
                <option value="">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-autor">Autor</label>
            <select id="filter-autor" name="autor">
                <option value="">Jacilane Rabelo</option>
                <?php
                // Buscar todos os autores de artigos
                $authors = get_users(array(
                    'who' => 'authors',
                    'has_published_posts' => array('artigo'),
                ));
                foreach ($authors as $author) {
                    echo '<option value="' . $author->ID . '">' . $author->display_name . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-evento">Evento</label>
            <select id="filter-evento" name="evento">
                <option value="">Sociedade Brasileira de Computação</option>
                <?php
                // Buscar termos da taxonomia de eventos (se existir)
                $eventos = get_terms(array(
                    'taxonomy' => 'evento_artigo',
                    'hide_empty' => true,
                ));
                if (!is_wp_error($eventos)) {
                    foreach ($eventos as $evento) {
                        echo '<option value="' . $evento->slug . '">' . $evento->name . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        
        <div class="filter-group search-group">
            <label for="filter-buscar">Buscar</label>
            <div class="search-input-wrapper">
                <input type="text" id="filter-buscar" name="buscar" placeholder="Título ou palavra-chave">
                <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </div>
        </div>
        
        <button class="filter-btn" id="filtrar-artigos">Filtrar</button>
    </div>

    <div class="artigos-container" id="artigos-results">
        <?php
        // Query para todos os artigos
        $artigos_args = array(
            'post_type' => 'artigo',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $artigos_query = new WP_Query($artigos_args);

        if ($artigos_query->have_posts()) :
            while ($artigos_query->have_posts()) : $artigos_query->the_post();
                
                // Obter metadados do artigo
                $ano = get_post_meta(get_the_ID(), 'ano_publicacao', true) ?: date('Y');
                $evento = get_post_meta(get_the_ID(), 'evento', true) ?: 'SBC BRASIL';
                $premio = get_post_meta(get_the_ID(), 'premio', true);
                $autores = get_post_meta(get_the_ID(), 'autores', true);
                
                ?>
                <article class="artigo-card">
                    <div class="artigo-badges">
                        <span class="badge ano-badge"><?php echo esc_html($ano); ?></span>
                        <span class="badge evento-badge"><?php echo esc_html($evento); ?></span>
                        <?php if ($premio) : ?>
                            <span class="badge premio-badge">
                                <svg class="trophy-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                    <path d="M4 22h16"></path>
                                    <path d="M10 14.66V17c0 .55.47.98.97 1.21C11.25 18.54 11.6 19 12 19s.75-.46 1.03-.79c.5-.23.97-.66.97-1.21v-2.34"></path>
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                </svg>
                                <?php echo esc_html($premio); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="artigo-content">
                        <h2 class="artigo-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="artigo-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <?php if ($autores) : ?>
                            <div class="artigo-autores">
                                <?php
                                $autores_array = explode(',', $autores);
                                foreach ($autores_array as $index => $autor) {
                                    $autor = trim($autor);
                                    echo '<div class="autor-avatar">';
                                    echo '<div class="avatar-circle">' . strtoupper(substr($autor, 0, 1)) . '</div>';
                                    echo '<span class="autor-nome">' . esc_html($autor) . '</span>';
                                    echo '</div>';
                                    if ($index < count($autores_array) - 1) {
                                        echo '<span class="autor-separator">,</span>';
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p class="no-articles">Não há artigos disponíveis no momento.</p>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtrarBtn = document.getElementById('filtrar-artigos');
    const anoSelect = document.getElementById('filter-ano');
    const autorSelect = document.getElementById('filter-autor');
    const eventoSelect = document.getElementById('filter-evento');
    const buscarInput = document.getElementById('filter-buscar');
    
    filtrarBtn.addEventListener('click', function() {
        console.log('Filtros aplicados:', {
            ano: anoSelect.value,
            autor: autorSelect.value,
            evento: eventoSelect.value,
            busca: buscarInput.value
        });
    });
});
</script>

<?php get_footer(); ?>
