<?php
/*
Template Name: Cursos
*/

get_header(); ?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Nossos cursos</h1>
        </div>
    </div>
</div>

<div class="container">

    <p>Um dos setores de maior destaque no LearningLab é o de cursos. Ao longo da nossa história, já ministramos 7 cursos e impactamos mais de 150 estudantes com eles — 130 deles sendo certificados!</p>

    <p>Nessa página, você pode conferir todos os cursos já ministrados pelo LearningLab, bem como os que ainda estão por vir.</p>

    <p><strong>Dica útil:</strong> clique ou toque sobre um curso para realizar a inscrição (caso ela esteja aberta) ou visualizar detalhes sobre ele.</p>

    <!-- Seção: Cursos Futuros -->
    <section class="cursos-futuros">
        <h2>Cursos futuros</h2>
        <div class="cursos-grid">
            <?php
            // Query para Cursos Futuros
            $futuros_args = array(
                'post_type' => 'curso',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'status_curso',
                        'field'    => 'slug',
                        'terms'    => 'curso-futuro',
                    ),
                ),
                'orderby' => 'date', // Ordenar pela data
                'order' => 'DESC',   // Mais recentes primeiro
            );

            $futuros_query = new WP_Query($futuros_args);

            if ($futuros_query->have_posts()) :
                while ($futuros_query->have_posts()) : $futuros_query->the_post();

                    // Verificar se o curso está na subcategoria 'Inscrições abertas'
                    $terms = get_the_terms(get_the_ID(), 'status_curso');
                    $inscricoes_abertas = false;

                    if ($terms) {
                        foreach ($terms as $term) {
                            if ($term->slug === 'inscricoes-abertas') {
                                $inscricoes_abertas = true;
                                break;
                            }
                        }
                    }
                    ?>

                    <div class="curso-item">
                        <a href="<?php the_permalink(); ?>" class="curso-link">
                            <div class="curso-content">
                                <?php the_post_thumbnail('medium'); ?>
                                <div class="texto">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php the_excerpt(); ?></p>

                                </div>
                                <div class="curso-status">
                                        <?php if ($inscricoes_abertas) : ?>
                                            <span class="curso-badge aberto">inscrições abertas</span>
                                        <?php else : ?>
                                            <span class="curso-badge em-breve">em breve</span>
                                        <?php endif; ?>
                                    </div>
                            </div>
                        </a>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Não há cursos futuros disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Seção: Cursos Passados -->
    <section class="cursos-passados">
        <h2>Cursos passados</h2>
        <div class="cursos-grid">
            <?php
            // Query para Cursos Passados
            $passados_args = array(
                'post_type' => 'curso',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'status_curso',
                        'field'    => 'slug',
                        'terms'    => 'curso-passado',
                    ),
                ),
                'orderby' => 'title',
                'order' => 'ASC',
            );

            $passados_query = new WP_Query($passados_args);

            if ($passados_query->have_posts()) :
                while ($passados_query->have_posts()) : $passados_query->the_post(); ?>

                    <div class="curso-item">
                        <a href="<?php the_permalink(); ?>" class="curso-link">
                            <div class="curso-content">
                                <?php the_post_thumbnail('medium'); ?>
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_excerpt(); ?></p>

                            </div>
                        </a>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Não há cursos passados disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php get_footer(); ?>


