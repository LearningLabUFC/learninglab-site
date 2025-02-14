<?php get_header(); ?>

<div class="container-header">
    <div class="content-header">
        <div class="title">
            <h1>Entre em contato conosco</h1>
        </div>
    </div>
</div>

<div class="container">

    <section class="container-contato">

        <div class="conteudo">
            <p>Caso você tenha alguma dúvida, pergunta ou sugestão, fique à vontade de entrar em contato conosco por um dos canais abaixo ou por meio do formulário.</p>
            <div class="canais">
                <a href="mailto:learninglab@ufc.br"><i class="fa-regular fa-envelope"></i>learninglab@ufc.br</a>
                <a href="https://instagram.com/learninglabufc"><i class="fa-brands fa-instagram"></i>@learninglabufc</a>
                <a href="https://www.linkedin.com/company/projeto-learninglab/"><i class="fa-brands fa-linkedin-in"></i>Projeto LearningLab</a>
            </div>
        </div>

        <div class="formulario">
            <?php echo do_shortcode('[contact-form-7 id="6104283" title="Formulário de contato 1"]'); ?>
        </div>
    </section>

</div>
    <?php get_footer(); ?>