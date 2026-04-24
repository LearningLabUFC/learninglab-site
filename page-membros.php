<?php

get_header();
?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Conheça nossos membros</h1>
        </div>
    </div>
</div>

<div class="container">

    <section class="gestao-topo">
        <div class="membros-grid">
            <?php
            // 1. Coordenador
            $coord_query = new WP_Query([
                'post_type' => 'membro',
                'tax_query' => [
                    [
                        'taxonomy' => 'tipo_de_membro',
                        'field'    => 'slug',
                        'terms'    => 'coordenador', 
                    ],
                ],
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
            ]);
            
            if ($coord_query->have_posts()) :
                while ($coord_query->have_posts()) : $coord_query->the_post(); ?>
                    <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                        <i class="fa-solid fa-graduation-cap icon-formado"></i>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
                        <?php learninglab_render_membro_socials(get_the_ID()); ?>
                        <div class="membro-setores">
                            <span class="setor-coordenadora">Coordenadora</span>
                        </div>
                    </div>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
        
        <div class="membros-grid row-administrativo" style="margin-top: -20px;">
            <?php
            // 2.A Cofundadoras (Primeiras na fila)
            $cofund_query = new WP_Query([
                'post_type' => 'membro',
                'tax_query' => [
                    [
                        'taxonomy' => 'tipo_de_membro',
                        'field'    => 'slug',
                        'terms'    => 'cofundadora',
                    ],
                ],
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
            ]);
            
            if ($cofund_query->have_posts()) :
                while ($cofund_query->have_posts()) : $cofund_query->the_post(); ?>
                    <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                        <i class="fa-solid fa-graduation-cap icon-formado"></i>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
                        <?php learninglab_render_membro_socials(get_the_ID()); ?>
                        
                        <div class="membro-setores">
                            <span class="setor-cofundadora">Cofundadora</span>
                        </div>
                    </div>
                <?php endwhile;
            endif;
            wp_reset_postdata();

            // 2.B Administrativo (Logo em seguida)
            $admin_query = new WP_Query([
                'post_type' => 'membro',
                'tax_query' => [
                    [
                        'taxonomy' => 'tipo_de_membro',
                        'field'    => 'slug',
                        'terms'    => 'administrativo',
                    ],
                ],
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order'   => 'ASC',
            ]);
            
            if ($admin_query->have_posts()) :
                while ($admin_query->have_posts()) : $admin_query->the_post(); ?>
                    <div class="membro-item <?php echo is_membro_formado(get_the_ID()) ? 'formado' : ''; ?>">
                        <i class="fa-solid fa-graduation-cap icon-formado"></i>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
                        <?php learninglab_render_membro_socials(get_the_ID()); ?>
                        
                        <div class="membro-setores">
                            <span class="setor-administrativo">Administrativo</span>
                        </div>
                    </div>
                <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <section class="membros-lideres">
        <h2>Líderes</h2>

        <?php
        $lider_categoria = get_term_by('slug', 'lider', 'tipo_de_membro');

        if ($lider_categoria) {
            $lider_subcategorias = get_term_children($lider_categoria->term_id, 'tipo_de_membro');
            
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
                            <i class="fa-solid fa-graduation-cap icon-formado"></i>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                            <?php endif; ?>
                            <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
                            <?php learninglab_render_membro_socials(get_the_ID()); ?>
                            
                            <?php
                            $setores = get_the_terms(get_the_ID(), 'tipo_de_membro');
                            if ($setores) :
                            ?>
                                <div class="membro-setores">
                                    <?php foreach ($setores as $setor) : ?>
                                        <?php
                                        if (in_array($setor->term_id, $lider_subcategorias)) :
                                            $rotulo = str_replace('Líder ', '', $setor->name);
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

    <section class="membros-atuais">
        <h2>Membros atuais</h2>

        <?php
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
                        <i class="fa-solid fa-graduation-cap icon-formado"></i>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
                        <?php learninglab_render_membro_socials(get_the_ID()); ?>
                        
                        <?php
                        $setores = get_the_terms(get_the_ID(), 'tipo_de_membro');
                        if ($setores) :
                        ?>
                            <div class="membro-setores">
                                <?php foreach ($setores as $setor) : ?>
                                    <?php
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

    <section class="membros-egressos">
        <h2>Egressos</h2>

        <?php
        $egressos_query = new WP_Query([
            'post_type' => 'membro',
            'tax_query' => [
                [
                    'taxonomy' => 'tipo_de_membro',
                    'field'    => 'slug',
                    'terms'    => 'egresso', 
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
                        <i class="fa-solid fa-graduation-cap icon-formado"></i>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="membro-avatar"><?php the_post_thumbnail('thumbnail'); ?></div>
                        <?php endif; ?>
                        <h4 class="membro-nome"><?php learninglab_membro_nome_duas_linhas(); ?></h4>
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
get_footer(); 
?>