<?php

/**
 * Template Name: Membros
 * Description: Página personalizada para exibir Membros (Líderes, Membros Atuais e Egressos)
 */

get_header(); // Inclui o cabeçalho do tema
?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Conheça nossos membros</h1>
        </div>
    </div>
</div>

<div class="container">

    <!-- Seção Líderes -->
    <p>Mesmo tendo iniciado suas atividades em 2020, o LearningLab já possui uma equipe bastante completa, com membros distribuídos em seus vários clãs e setores. Nessa página, você poderá conhecer todo o nosso time e entender melhor quais atividades cada um dos integrantes desempenha!</p>

    <p>Dica: nossos membros ou ex-membros que já se formaram contam com uma borda verde em suas fotos!</p>

    <section class="coordenador">
        <h2>Nossa coordenadora</h2>
        <p>Antes de conhecermos os membros líderes de cada setor, cabe destacar a principal posição de liderança no projeto, a nossa coordenadora:</p>

        <?php
        // Consulta apenas para a categoria Egresso
        $egressos_query = new WP_Query([
            'post_type' => 'membro',
            'tax_query' => [
                [
                    'taxonomy' => 'tipo_de_membro',
                    'field'    => 'slug',
                    'terms'    => 'coordenador', // Apenas a categoria "Coordenador"
                ],
            ],
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
        ]);
        if ($egressos_query->have_posts()) :
        ?>
            <div class="membros-grid">
                <?php while ($egressos_query->have_posts()) : $egressos_query->the_post(); ?>
                    <div class="membro-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php the_title(); ?></h4>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </section>



    <section class="membros-lideres">
        <h2>Líderes</h2>

        <p>Cada setor ou clã no LearningLab conta com posições bem estabelecidas de liderança, as quais servem para auxiliar e orientar o trabalho dos demais integrantes na equipe.</p>
        <p>Conheça abaixo os líderes do LearningLab, bem como os setores os quais eles lideram.</p>

        <?php
        // Obtém a categoria principal "Líder"
        $lider_categoria = get_term_by('slug', 'lider', 'tipo_de_membro');

        if ($lider_categoria) {
            // Busca todas as subcategorias de "Líder"
            $lider_subcategorias = get_term_children($lider_categoria->term_id, 'tipo_de_membro');

            // Cria a consulta para pegar todos os membros dessas subcategorias
            $lideres_query = new WP_Query([
                'post_type' => 'membro',
                'tax_query' => [
                    [
                        'taxonomy' => 'tipo_de_membro',
                        'field'    => 'term_id',
                        'terms'    => $lider_subcategorias,
                        'operator' => 'IN',
                    ],
                ],
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
            ]);

            if ($lideres_query->have_posts()) :
        ?>



                <div class="membros-grid">
                    <?php while ($lideres_query->have_posts()) : $lideres_query->the_post(); ?>
                        <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                            <?php endif; ?>
                            <h4 class="membro-nome"><?php the_title(); ?></h4>

                            <!-- Exibição de rótulos dos setores -->
                            <?php
                            $setores = get_the_terms(get_the_ID(), 'tipo_de_membro');
                            if ($setores) :
                            ?>
                                <div class="membro-setores">
                                    <?php foreach ($setores as $setor) : ?>
                                        <?php
                                        // Exibe apenas os rótulos das subcategorias de "Líder"
                                        if (in_array($setor->term_id, $lider_subcategorias)) :
                                            $rotulo = str_replace('Líder ', '', $setor->name); // Remove o prefixo "Líder "
                                        ?>
                                            <span class="setor-<?php echo esc_attr($setor->slug); ?>">
                                                <?php echo esc_html($rotulo); ?>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
        <?php
            else :
                echo '<p>Nenhum líder encontrado.</p>';
            endif;
            wp_reset_postdata();
        } else {
            echo '<p>A categoria "Líder" não foi encontrada.</p>';
        }
        ?>
    </section>



    <!-- Seção Membros Atuais -->
    <section class="membros-atuais">
        <h2>Membros atuais</h2>
        <p>Nesta seção, vamos conhecer todos os membros que fazem parte atualmente do LearningLab (inclusive os líderes), bem como quais os setores nos quais eles fazem parte!</p>

        <?php
        // Consulta todos os membros marcados como "membro-atual"
        $atuais_query = new WP_Query([
            'post_type' => 'membro',
            'tax_query' => [
                [
                    'taxonomy' => 'tipo_de_membro',
                    'field'    => 'slug',
                    'terms'    => 'membro-atual',
                ],
            ],
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
        ]);

        if ($atuais_query->have_posts()) :
        ?>


            <div class="membros-grid">
                <?php while ($atuais_query->have_posts()) : $atuais_query->the_post(); ?>
                    <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php the_title(); ?></h4>

                        <!-- Exibição de rótulos (somente setores de Membros Atuais) -->
                        <?php
                        $setores = get_the_terms(get_the_ID(), 'tipo_de_membro');
                        if ($setores) :
                        ?>
                            <div class="membro-setores">
                                <?php foreach ($setores as $setor) : ?>
                                    <?php
                                    // Filtra subcategorias de "membro-atual" apenas
                                    $is_setor_de_membro = term_is_ancestor_of(
                                        get_term_by('slug', 'membro-atual', 'tipo_de_membro')->term_id,
                                        $setor->term_id,
                                        'tipo_de_membro'
                                    );
                                    if ($is_setor_de_membro) :
                                    ?>
                                        <span class="setor-<?php echo esc_attr($setor->slug); ?>">
                                            <?php echo esc_html($setor->name); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </section>

    <!-- Seção Egressos -->
    <section class="membros-egressos">
        <h2>Egressos</h2>
        <p>Ao longo desses aninhos de existência, muita gente boa já passou pelo Learning! Confira abaixo os membros egressos do projeto — ou seja, aqueles que já não fazem mais parte do nosso time.</p>

        <?php
        // Consulta apenas para a categoria Egresso
        $egressos_query = new WP_Query([
            'post_type' => 'membro',
            'tax_query' => [
                [
                    'taxonomy' => 'tipo_de_membro',
                    'field'    => 'slug',
                    'terms'    => 'egresso', // Apenas a categoria "Egresso"
                ],
            ],
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
        ]);
        if ($egressos_query->have_posts()) :
        ?>
            <div class="membros-grid">
                <?php while ($egressos_query->have_posts()) : $egressos_query->the_post(); ?>
                    <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php the_title(); ?></h4>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </section>
</div>

<?php
get_footer(); // Inclui o rodapé do tema
?>