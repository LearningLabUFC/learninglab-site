<?php


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


    <?php
    // ========================================
    // SEÇÃO: Cursos em andamento
    // ========================================
    $andamento_args = array(
        'post_type' => 'curso',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'status_curso',
                'field'    => 'slug',
                'terms'    => 'curso-em-andamento',
            ),
        ),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $andamento_query = new WP_Query($andamento_args);

    if ($andamento_query->have_posts()) :
    ?>
    <section class="cursos-em-andamento">
        <h2>Cursos em andamento</h2>
        <div class="cards-grid">
            <?php
            while ($andamento_query->have_posts()) : $andamento_query->the_post();

                $terms = get_the_terms(get_the_ID(), 'status_curso');
                $inscricoes_abertas = false;
                $inscricoes_encerradas = false;

                if ($terms) {
                    foreach ($terms as $term) {
                        if ($term->slug === 'inscricoes-abertas') {
                            $inscricoes_abertas = true;
                        }
                        if ($term->slug === 'inscricoes-encerradas') {
                            $inscricoes_encerradas = true;
                        }
                    }
                }

                if ($inscricoes_abertas) {
                    $badge_text  = 'inscrições abertas';
                    $badge_class = 'aberto';
                } elseif ($inscricoes_encerradas) {
                    $badge_text  = 'inscrições encerradas';
                    $badge_class = 'encerrado';
                } else {
                    $badge_text  = 'em andamento';
                    $badge_class = 'em-andamento';
                }

                get_template_part('template-parts/content', 'card', array(
                    'show_badge'  => true,
                    'badge_text'  => $badge_text,
                    'badge_class' => $badge_class,
                ));

            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endif; ?>


    <?php
    // ========================================
    // SEÇÃO: Cursos futuros
    // ========================================
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
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $futuros_query = new WP_Query($futuros_args);

    if ($futuros_query->have_posts()) :
    ?>
    <section class="cursos-futuros">
        <h2>Cursos futuros</h2>
        <div class="cards-grid">
            <?php
            while ($futuros_query->have_posts()) : $futuros_query->the_post();

                $terms = get_the_terms(get_the_ID(), 'status_curso');
                $inscricoes_abertas = false;
                $inscricoes_encerradas = false;

                if ($terms) {
                    foreach ($terms as $term) {
                        if ($term->slug === 'inscricoes-abertas') {
                            $inscricoes_abertas = true;
                        }
                        if ($term->slug === 'inscricoes-encerradas') {
                            $inscricoes_encerradas = true;
                        }
                    }
                }

                if ($inscricoes_abertas) {
                    $badge_text  = 'inscrições abertas';
                    $badge_class = 'aberto';
                } elseif ($inscricoes_encerradas) {
                    $badge_text  = 'inscrições encerradas';
                    $badge_class = 'encerrado';
                } else {
                    $badge_text  = 'em breve';
                    $badge_class = 'em-breve';
                }

                get_template_part('template-parts/content', 'card', array(
                    'show_badge'  => true,
                    'badge_text'  => $badge_text,
                    'badge_class' => $badge_class,
                ));

            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endif; ?>


    <?php
    // ========================================
    // SEÇÃO: Cursos passados (sempre exibe)
    // ========================================
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
    ?>
    <section class="cursos-passados">
        <h2>Cursos passados</h2>
        <div class="cards-grid">
            <?php
            if ($passados_query->have_posts()) :
                while ($passados_query->have_posts()) : $passados_query->the_post();

                    get_template_part('template-parts/content', 'card');

                endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Não há cursos passados disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </section>

</div>

<?php get_footer(); ?>
