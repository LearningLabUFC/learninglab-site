<?php get_header(); ?>

<main>
    <section class="background-container-inicial">
        <div class="container-inicial">
            <h2>Instigando sempre sua criatividade e inovação</h2>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imagem-painel-index.svg" alt="imagem com curiosidades">
        </div>
    </section>

    <section id="circulo"> </section>

    <section class="container-sobre">
        <div>
            <div>
                <h2>Sobre o projeto</h2>
                <p>
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </p>
                <a
                    class="<?php if (is_page('home')) {
                                echo 'ativo';
                            } ?>"
                    aria-current="home"
                    href="<?php echo esc_url(get_permalink(get_page_by_path('quem-somos'))); ?>"><button>conhecer mais</button>
                </a>
            </div>
        </div>
        <div class="sobre-imagem">
            <?php
            the_post_thumbnail();
            ?>

        </div>
    </section>


    <section class="container-cursos">
        <div class="background-container-cursos"></div>
        <div class="paineis-de-cursos">
            <div class="mais-cursos">
                <h2>Nossos Cursos</h2>
                <a
                    class="<?php if (is_page('home')) {
                                echo 'ativo';
                            } ?>"
                    aria-current="home"
                    href="<?php echo esc_url(get_permalink(get_page_by_path('nossos-cursos'))); ?>"><button>mais cursos</button>
                </a>
            </div>


            <?php
            // Query para os dois últimos cursos, sem considerar a taxonomia
            $cursos_args = array(
                'post_type' => 'curso',
                'posts_per_page' => 2, // Pega os dois últimos cursos
                'orderby' => 'date', // Ordena pela data
                'order' => 'DESC', // Mais recentes primeiro
            );

            $cursos_query = new WP_Query($cursos_args);

            if ($cursos_query->have_posts()) :
                while ($cursos_query->have_posts()) : $cursos_query->the_post();
                    // Verifica as categorias (status) do curso
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

                    <div class="painel-curso">
                        <a href="<?php the_permalink(); ?>" class="link-curso">
                            <!-- Imagem destacada do curso -->
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                            <div class="painel-descricao">
                                <!-- Título do curso -->
                                <h3><?php the_title(); ?></h3>
                                <!-- Excerpt do curso -->
                                <p><?php the_excerpt(); ?></p>

                                <!-- Status do curso (Em breve ou Inscrições abertas) -->
                                <div class="status">
                                    <?php
                                    // Verifica se o curso tem a taxonomia "Curso Passado"
                                    $terms = get_the_terms(get_the_ID(), 'status_curso');
                                    $curso_passado = false;

                                    if ($terms) {
                                        foreach ($terms as $term) {
                                            if ($term->slug === 'curso-passado') {
                                                $curso_passado = true;
                                                break;
                                            }
                                        }
                                    }

                                    // Se o curso for "Curso Passado", não exibe nada
                                    if ($curso_passado) {
                                        echo '';
                                    } else {
                                        // Caso contrário, verifica se as inscrições estão abertas
                                        if ($inscricoes_abertas) {
                                            echo '<span class="inscricoes-abertas">inscrições abertas</span>';
                                        } else {
                                            echo '<span class="em-breve">em breve</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Não há cursos disponíveis no momento.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="container-leitura">

        <div class="mais-noticias">
            <h2>Para leitura</h2>
            <a
                class="<?php if (is_page('home')) {
                            echo 'ativo';
                        } ?>"
                aria-current="home"
                href="<?php echo esc_url(get_permalink(get_page_by_path('blog'))); ?>"><button>mais publicações</button>
            </a>
        </div>
        <div class="swiper leitura-swiper">
            <div class="swiper-wrapper">
                <?php
                // Consulta para pegar as últimas publicações do blog
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 6, // Número de publicações exibidas
                );
                $query = new WP_Query($args);


                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>
                        <div class="swiper-slide">
                            <div class="swiper-slide">
                                <a href="<?php the_permalink(); ?>" class="card-leitura">
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>">
                                    <div class="conteudo-leitura">
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php the_excerpt(); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Sem posts no momento.</p>';
                endif;
                ?>

            </div>

            <!-- Botões e paginação -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="container-comentarios">

        <h2>O que dizem sobre nós</h2>
        <div class="swiper avaliacao-swiper">
            <div class="swiper-wrapper">
                <?php
                // Query para pegar os posts do CPT "avaliacoes"
                $args = array(
                    'post_type' => 'avaliacoes', // CPT de avaliações
                    'posts_per_page' => -1 // Pega todas as avaliações
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>
                        <div class="swiper-slide">
                            <div class="card-avaliacao">
                                <div class="imagem-avaliacao">
                                    <?php the_post_thumbnail('thumbnail'); // Imagem destacada 
                                    ?>
                                </div>
                                <div class="conteudo-avaliacao">
                                    <h3><?php the_title(); ?></h3> <!-- Nome da pessoa -->
                                    <p><?php the_content(); ?></p> <!-- Comentário -->
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Sem avaliações no momento.</p>';
                endif;
                ?>
            </div>
            <!-- Botões de navegação -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- Paginação -->
            <div class="swiper-pagination"></div>
        </div>

    </section>




</main>

<?php get_footer(); ?>