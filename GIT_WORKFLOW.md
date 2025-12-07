# Guia Completo de Git/GitHub para o Projeto LearningLab

Este guia foi elaborado para auxiliar a equipe do projeto LearningLab (site WordPress) a utilizar o Git/GitHub de forma eficiente e padronizada. Aqui você encontrará instruções detalhadas sobre o fluxo de trabalho, manipulação de branches, convenções de nomenclatura e configuração inicial.

## Sumário

1. [Configuração Inicial](#configuração-inicial)
2. [Estrutura de Branches](#estrutura-de-branches)
3. [Fluxo de Trabalho](#fluxo-de-trabalho)
4. [Convenções de Nomenclatura](#convenções-de-nomenclatura)
5. [Comandos Úteis](#comandos-úteis)
6. [Pull Requests](#pull-requests)
7. [Referência Rápida](#referência-rápida)

## Configuração Inicial

### 1. Instalando o Git

#### Instalação do Git

**Windows:**

- Acesse https://git-scm.com/download/win e baixe o instalador
- Execute o instalador com as opções padrão

**Mac:**

- Via Homebrew: `brew install git`
- Ou baixe o instalador em https://git-scm.com/download/mac

**Linux:**

- Ubuntu/Debian: `sudo apt-get install git`
- Fedora: `sudo dnf install git`

### 2. Configurando sua identidade no Git

```bash
# Via linha de comando
git config --global user.name "Seu Nome"
git config --global user.email "seuemail@exemplo.com"
```

**No VS Code:**

- Acesse as configurações (Ctrl+, ou Cmd+,)
- Pesquise por "git user" e preencha os campos

### 3. Clonando o Repositório do LearningLab

**Via linha de comando:**

```bash
git clone https://github.com/caminho-do-repositorio/LearningLab.git
cd LearningLab
```

**No VS Code:**

1. Pressione Ctrl+Shift+P (ou Cmd+Shift+P no Mac)
2. Digite "Git: Clone"
3. Cole a URL do repositório
4. Selecione onde salvar o projeto

## Estrutura de Branches

O projeto LearningLab possui duas branches principais:

1. **main** - Branch de produção, contém o código estável
2. **develop** - Branch de desenvolvimento, recebe novas funcionalidades antes da produção

### Visualizando branches

**Via linha de comando:**

```bash
# Listar branches disponíveis localmente
git branch

# Listar todas as branches (locais e remotas)
git branch -a
```

**No VS Code:**

1. Clique no nome da branch atual na barra de status (canto inferior esquerdo)
2. Um menu aparecerá mostrando todas as branches disponíveis

## Fluxo de Trabalho

O fluxo de trabalho recomendado segue estas etapas:

### 1. Sempre comece a partir da branch develop atualizada

**Via linha de comando:**

```bash
# Mudar para a branch develop
git checkout develop

# Atualizar a branch com as últimas alterações do repositório remoto
git pull origin develop
```

**No VS Code:**

1. Clique no nome da branch na barra de status
2. Selecione "develop" da lista
3. Clique no ícone de sincronização na barra de status ou use Ctrl+Shift+G e clique em "Pull"

### 2. Crie uma nova branch para sua funcionalidade/correção

**Via linha de comando:**

```bash
# Crie uma nova branch a partir da develop e mude para ela
git checkout -b feature/nome-da-funcionalidade
```

**No VS Code:**

1. Clique no nome da branch na barra de status
2. Clique em "+ Create new branch"
3. Digite o nome seguindo a convenção (ex: feature/nome-da-funcionalidade)

### 3. Desenvolva sua funcionalidade e faça commits frequentes

**Via linha de comando:**

```bash
# Adicione os arquivos modificados
git add .

# Ou adicione arquivos específicos
git add caminho/do/arquivo

# Faça o commit com uma mensagem descritiva
git commit -m "feat: adiciona formulário de contato"
```

**No VS Code:**

1. Na aba Source Control (Ctrl+Shift+G)
2. Veja as alterações e clique no "+" ao lado do arquivo para staged
3. Digite uma mensagem de commit na caixa de texto
4. Clique em "✓" (Commit)

### 4. Envie sua branch para o repositório remoto

**Via linha de comando:**

```bash
git push origin feature/nome-da-funcionalidade
```

**No VS Code:**

1. Na aba Source Control
2. Clique em "..." e selecione "Push"
3. Na primeira vez, selecione "Publish Branch"

### 5. Crie um Pull Request

Quando sua funcionalidade estiver pronta, crie um Pull Request da sua branch para a branch develop.

## Convenções de Nomenclatura

### Branches

Siga este formato para nomes de branches:

1. **feature/nome-da-funcionalidade** - Para novas funcionalidades

   - Exemplo: `feature/formulario-contato`

2. **fix/nome-do-problema** - Para correções de bugs

   - Exemplo: `fix/menu-responsivo`

3. **hotfix/nome-do-problema** - Para correções urgentes em produção

   - Exemplo: `hotfix/erro-login`

4. **refactor/nome-componente** - Para refatoração de código

   - Exemplo: `refactor/estrutura-css`

5. **docs/nome-documento** - Para atualização de documentação
   - Exemplo: `docs/readme-update`

### Commits

Use prefixos nas mensagens de commit para indicar o tipo de alteração:

1. **feat:** - Nova funcionalidade

   - Exemplo: `feat: adiciona página de blog`

2. **fix:** - Correção de bug

   - Exemplo: `fix: corrige responsividade no menu mobile`

3. **docs:** - Atualização de documentação

   - Exemplo: `docs: atualiza README com instruções de instalação`

4. **style:** - Mudanças que não afetam o significado do código (espaçamento, formatação, etc.)

   - Exemplo: `style: formata código CSS seguindo padrões`

5. **refactor:** - Refatoração de código

   - Exemplo: `refactor: simplifica lógica de validação do formulário`

6. **chore:** - Atualizações de tarefas de build, configurações, etc.
   - Exemplo: `chore: atualiza dependências do WordPress`

**Regras para mensagens de commit:**

- Use o tempo presente ("adiciona" em vez de "adicionado")
- Não use ponto final no título do commit
- Seja conciso mas descritivo
- Use no máximo 50 caracteres para o título

## Comandos Úteis

### Verificar Status

**Via linha de comando:**

```bash
# Ver arquivos modificados, staged e não staged
git status
```

**No VS Code:**

- A aba Source Control (Ctrl+Shift+G) mostra automaticamente o status

### Visualizar Histórico

**Via linha de comando:**

```bash
# Ver histórico de commits
git log

# Ver histórico simplificado em uma linha
git log --oneline

# Ver histórico com gráfico
git log --graph --oneline --all
```

**No VS Code:**

1. Na aba Source Control, clique em "..."
2. Selecione "View History"

### Desfazer Alterações

**Via linha de comando:**

```bash
# Desfazer alterações não commitadas em um arquivo
git checkout -- nome-do-arquivo

# Desfazer alterações staged (após git add)
git reset HEAD nome-do-arquivo

# Desfazer o último commit mantendo as alterações
git reset --soft HEAD~1

# Desfazer o último commit descartando as alterações (cuidado!)
git reset --hard HEAD~1
```

**No VS Code:**

1. Na aba Source Control, clique com o botão direito no arquivo
2. Selecione "Discard Changes" para desfazer alterações não commitadas

### Mudando entre Branches

**Via linha de comando:**

```bash
# Mudar para outra branch
git checkout nome-da-branch

# Criar e mudar para nova branch
git checkout -b nome-da-nova-branch
```

**No VS Code:**

1. Clique no nome da branch na barra de status
2. Selecione a branch desejada da lista

### Atualizar seu Repositório Local

**Via linha de comando:**

```bash
# Atualizar branch atual
git pull

# Buscar todas as atualizações sem aplicá-las
git fetch --all
```

**No VS Code:**

- Clique no ícone de sincronização na barra de status

### Resolver Conflitos

**Via linha de comando:**

```bash
# Após um conflito durante merge ou pull
git status  # para ver arquivos com conflito
# Edite os arquivos para resolver os conflitos
git add .   # Marque os conflitos como resolvidos
git commit  # Finalize o merge
```

**No VS Code:**

1. Os arquivos com conflito serão destacados
2. Clique em "Resolve in Editor"
3. Escolha "Accept Current Change", "Accept Incoming Change", "Accept Both Changes" ou edite manualmente
4. Adicione os arquivos resolvidos e faça commit

## Pull Requests

### Criando um Pull Request

1. Acesse o repositório no GitHub
2. Clique em "Pull Requests" e depois em "New Pull Request"
3. Escolha sua branch como "compare" e "develop" como "base"
4. Clique em "Create Pull Request"
5. Preencha:
   - **Título**: Breve descrição da funcionalidade
   - **Descrição**: Detalhes sobre o que foi implementado, como testar, screenshots se aplicável
6. Adicione reviewers (colegas de equipe para revisar seu código)
7. Clique em "Create Pull Request"

### Revisando um Pull Request

1. Acesse o Pull Request no GitHub
2. Verifique as alterações na aba "Files changed"
3. Deixe comentários em linhas específicas clicando no "+" que aparece ao passar o mouse
4. Aprove ou solicite mudanças no menu "Review changes"

## Referência Rápida

### Ciclo de Trabalho Diário

1. Atualize a branch develop: `git checkout develop && git pull`
2. Crie sua branch de trabalho: `git checkout -b feature/sua-funcionalidade`
3. Faça alterações e commits frequentes
4. Envie sua branch para o repositório: `git push origin feature/sua-funcionalidade`
5. Crie um Pull Request para a branch develop quando finalizar

### Convenções Importantes

| Tipo de Branch | Formato                     | Exemplo                |
| -------------- | --------------------------- | ---------------------- |
| Feature        | feature/nome-funcionalidade | feature/pagina-contato |
| Correção       | fix/nome-problema           | fix/erro-formulario    |
| Urgente        | hotfix/nome-problema        | hotfix/falha-seguranca |

| Tipo de Commit      | Formato             | Exemplo                                 |
| ------------------- | ------------------- | --------------------------------------- |
| Nova funcionalidade | feat: descrição     | feat: adiciona sistema de login         |
| Correção            | fix: descrição      | fix: corrige erro na validação de email |
| Documentação        | docs: descrição     | docs: atualiza instruções de instalação |
| Refatoração         | refactor: descrição | refactor: otimiza queries do banco      |

---

## Considerações Finais

Este guia foi desenvolvido para padronizar e facilitar o trabalho da equipe no projeto LearningLab. Lembre-se:

- **Sempre** trabalhe em uma branch separada, nunca diretamente na main ou develop
- **Faça commits frequentes** com mensagens claras e descritivas
- **Mantenha suas branches atualizadas** antes de começar a trabalhar
- **Comunique-se com a equipe** sobre o que está desenvolvendo

Se tiver dúvidas ou sugestões para melhorar este guia, fale com o coordenador do projeto.

Bom trabalho!
