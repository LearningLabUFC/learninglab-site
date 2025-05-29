<?php 

// Neste arquivo ficam as metatags Open Graph, que são adicionadas no <head> para que o tema suporte a pré-visualização de links

function add_custom_og_tags() {
    if (is_front_page() || is_home()) {
		echo '<meta property="og:title" content="LearningLab - Projeto de extensão da UFC Campus Russas" />' . "\n";
		echo '<meta property="og:description" content="Laboratório de Ensino, Pesquisa, Extensão e Desenvolvimento de Tecnologias Alinhadas à Gestão do Conhecimento e Inovação em Processos de Software." />' . "\n";
        echo '<meta property="og:image" content="https://learninglab.com.br/wp-content/uploads/2025/02/logo-colorida.png" />' . "\n";
        echo '<meta property="og:url" content="https://learninglab.com.br/" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
    }
}

add_action('wp_head', 'add_custom_og_tags');