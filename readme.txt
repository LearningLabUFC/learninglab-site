# Tema do site do LearningLab

Este é um tema do WordPress para o site do projeto de extensão LearningLab, da Universidade Federal do Ceará (campus Russas) com o objetivo de tornar mais prático o gerenciamento, a criação e edição de páginas e publicações pelos membros da organização.

## Funcionalidades

- **Responsivo**: O tema é totalmente responsivo, garantindo uma boa experiência em dispositivos móveis.
- **Customização**: Oferece diversas opções de personalização através do painel do WordPress.
- **SEO**: Construído com práticas recomendadas de SEO para garantir boa indexação nos motores de busca.

## Instalação

### Requisitos
- WordPress 5.0 ou superior
- PHP 7.4 ou superior
- MySQL 5.6 ou superior

### Passos para Instalação
1. Faça o download do tema, ou clone este repositório:
   ```bash
   git clone https://github.com/LearningLabUFC/Site-LearningLab-2.0.git
   ```

2.	Carregue o tema na sua instalação WordPress:

-	Acesse o painel do WordPress.
-	Vá em **Aparência > Temas**.
-	Clique em **Adicionar novo** e depois em **Enviar tema**.
-	Selecione a pasta do tema (ou o arquivo ZIP) e clique em Instalar.

3.	Ative o tema após a instalação.

### Personalização

Para personalizar o tema, acesse o painel **Aparência > Personalizar** e ajuste as opções disponíveis.

## Desenvolvimento (VSCode / IntelliSense)

Se você abre **apenas a pasta do tema** no VSCode, o autocomplete de funções do WordPress (ex.: `have_posts()`, `get_header()`) depende de *stubs* PHP.

### Requisitos
- Composer instalado na máquina
- Extensão VSCode: **PHP Intelephense** (`bmewburn.vscode-intelephense-client`)

### Passos
1. Na raiz do tema, rode:
   ```bash
   composer install
   ```
2. No VSCode:
   - `Cmd/Ctrl+Shift+P` → `Intelephense: Clear Cache`
   - `Cmd/Ctrl+Shift+P` → `Developer: Reload Window`

Observação: a pasta `vendor/` é gerada pelo Composer (não é pra editar manualmente). Se você apagá-la, é só rodar `composer install` novamente.
