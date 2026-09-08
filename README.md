# 🔷 Roprepo - Um clone de Roblox com PHP

## 💻 Introdução

Um projeto web com PHP Vanilla com o intuito buscar, de acordo com as preferências do estudante, um tópico de interesse que esteja dentro das adequações do CRUD (Create, Read, Update, Delete) - As 4 operações básicas de um Banco de Dados. Este repositório escolheu imitar a interface padrão do Roblox.

Na prática, o projeto já conta com um front controller em `public/index.php`, autenticação via sessão PHP, e conexão com PostgreSQL via `backend/config/database.php`. A lógica de login/cadastro é tratada em `backend/auth/access.php` com respostas JSON para o frontend.

## 🧠 Contextualização

Roblox é uma plataforma de jogos online e um sistema de criação de jogos desenvolvido pela Roblox Corporation que permite aos usuários programar e jogar jogos criados por eles próprios ou por outros usuários. Foi criado por David Baszucki e Erik Cassel em 2004 e lançado ao público em 2006. Em fevereiro de 2025, a plataforma registrava uma média de 85.3 milhões de usuários ativos diários. Segundo a empresa, sua base mensal de jogadores inclui metade de todas as crianças norte-americanas com menos de 16 anos. Fonte: [Wikipedia](https://pt.wikipedia.org/wiki/Roblox)

## 🛑 Aviso de Isenção de Responsabilidade (Disclaimer)

**Este é um projeto estritamente acadêmico e sem fins lucrativos.** O **Roprepo** é um clone conceitual desenvolvido exclusivamente para fins de estudo de desenvolvimento web (PHP, Banco de Dados e operações CRUD). 

* **Sem Vínculo Oficial:** Este projeto não é afiliado, associado, autorizado, endossado ou de qualquer forma conectado oficialmente à Roblox Corporation, ou a qualquer uma de suas subsidiárias ou afiliadas.
* **Propriedade Intelectual:** O nome "Roblox", bem como marcas registradas, logotipos e identidades visuais mencionadas ou utilizadas neste repositório são de propriedade exclusiva de seus respectivos donos. Este projeto utiliza tais elementos sob o princípio de *Fair Use* (Uso Justo) para fins educacionais.
* **Monetização:** Não há transações financeiras reais nesta aplicação. O sistema de "Robux" e "Assinatura Plus" mencionado é puramente simulado por meio de lógica de programação local com persistência de dados.

## 📄 Planejamento Inicial

A aplicação buscará seguir as funcionalidades básicas da página web [Roblox](https://roblox.com), como sistema monetário (Robux), usuários únicos e jogos, que neste caso, serão experimentados pelo navegador e sem a possibilidade de serem criados pelos próprios jogadores.

## 🩻 Estrutura Estética

O site deverá seguir os elementos visuais encontrados na plataforma oficial do Roblox, como por exemplo a fonte `Builder Sans`, Ícones .svg de UX/UI e proposta de charts/catálogo para melhorar a experiência.

## 📑 Páginas Existentes

### 🔐 Cadastro/Login

Para usuários que não possuem uma sessão atual e devem criar uma conta para prosseguir.

Essa interface de login/cadastro está implementada em `public/login.html` com validação de formulário em `public/assets/js/pages/login.js`, e a API de autenticação é processada por `backend/auth/access.php`.

### 🏠 Home

Página introdutória. Seu propósito é saudar o usuário (recém logado no sistema) e perguntar qual das 3 outras páginas importantes ele deseja entrar: Charts, Catalog, Profile.

### 📃 Charts

Um grande painel com a função de renderizar para o navegador os jogos registrados no banco de dados (no momento, pelo próprio criador).

### 🛒 Catalog

Exibe os itens disponíveis para o usuário comprar com os pontos (Robux) acumulados. Limitados a títulos como cosméticos (c/ cor, preço e nome).

### 👤 Profile

O lugar de customização personalizada do usuário, com um painel lateral (inferior em telas pequenas) para modificar aspectos visuais do sistema.

### 💵 Robux

Página tutorial - Define os conceitos básicos de Robux (na plataforma Roprepo) para informar o usuário.

### ➕ Plus

Roblox Plus é o novo serviço de assinatura mensal da Roblox, lançado globalmente em 30 de abril de 2026, que substitui o Roblox Premium como a opção principal para novos usuários. O plano custa US$ 4,99 (ou R$ 29,90 no Brasil) por mês e foi projetado para ampliar o valor dos Robux através de benefícios exclusivos e descontos diretos.

Acessível através da página de Robux, esta será uma página onde aqueles que possuem quantia o suficiente podem navegar para adquirir as vantagens.

### 🎮 App - Jogos

#### 🔴 Pong - Solo

Com o objetivo de não deixar a bola cair no chão, o jogador irá acumular pontos que no fim serão multiplicados por 0,35 para obter robux na plataforma.

#### 🎰 Cassino

Alto risco, alto ganho - O jogador poderá apostar os seus robux atuais para obter a chance de ganhar mais... Ou perdê-los.
Os jogos são protótipos localizados em `public/app/games/` e, no estado atual do projeto, ainda não estão integrados ao fluxo de rotas dinâmicas do front controller.
#### 🐀 Jogo da Toupeira

Múltiplas entidades aparecerão na tela em questão de segundos. O objetivo é acertar o máximo de toupeiras possível antes que atinja um alvo que encerre o jogo.

#### 🧠 Outras Possibilidades (Brainstorming)

##### 🖐 Pedra, Papel, Tesoura

O jogador escolherá entre as três possibilidades, e o computador sorteará um número de 0 a 2 para enfrentá-lo. Ao vencer, o usuário ganhará 5 pontos, ao perder perderá 2 pontos e ao empatar, nenhum ponto será adicionado.

Os pontos ficarão guardados até que o jogo encerre de fato, para multiplicá-los finalmente por 0.15 pontos reais.

## 🧩 Modelagem de Dados

A modelagem de dados é a parte principal para determinar as entidades da aplicação. Em Roprepo, existirão três entidades principais: Users, Games, Titles. Seus esquemas estão presentes em `/docs/sql/ddl`.

O esquema real em `docs/sql/ddl.sql` inclui tabelas adicionais de relacionamento como `roles`, `user_roles` e `user_titles`, bem como campos de preferências do usuário (`dark_mode`, `is_plus`, `robux`).

## 🔧 Requisitos Técnicos

### Requisito 1 - Consistência e Reaproveitamento de Código

O desenvolvimento utilizará `/includes` como maneira de reutilizar elementos HTML existentes em (quase) todas as páginas, com o PHP replicando o conteúdo para o cliente.

> Inicialmente, o projeto utiliza-se de páginas estáticas `.html` para definir o layout antes da lógica.

### Requisito 2 - Cadastro Obrigatório

Todo usuário no qual não possui sessão atual ao sistema atribuído a uma tupla cadastrada do banco de dados não poderá acessar as funcionalidades do sistema.

### Requisito 3 - Sistema Monetário/de Pontuação (Robux)

Ao se deparar com os jogos existentes nos charts, o usuário conseguirá obter pontos com o progresso obtido e utilizar esta pontuação para adquirir cosméticos de títulos do catálogo ou Roprepo Plus.

### Requisito 4 - Contas de Usuário

Todo usuário deverá possuir por padrão, porém não limitado a:

* Cargo `user` para restringi-lo a permissões privilegiadas. Ex: Manipular o BD
* Título `player` como padrão
* Foto de Perfil `default.png` caso não haja personalização do próprio usuário.
* Total de 0 `robux` iniciais
* `dark_mode` habilitado
* Roprepo `plus` desabilitado
* As rotas públicas e privadas são separadas em `backend/routes/public_api.php` e `backend/routes/private_api.php` para proteger ações sem sessão.

## ✅ Boas Práticas

No desenvolvimento do back-end deste projeto, seguirá-se estas práticas:

* **NUNCA** Confiar no Cliente. Sempre valide entradas enviadas pelo navegador.
* Ao usuário atualizar sua foto de perfil, remova a anterior de `avatars/` imediatamente.
* Redirecionar clientes ao conteúdo da página `not_index.php` caso digite um GET inválido no URL.

## ⚒️ Ferramentas

Priorizando a documentação concisa, o projeto utilizará as seguintes ferramentas:

* [VS Code](https://code.visualstudio.com/) - IDE com Snippets PHP
* [Figma](https://www.figma.com/design/y4IJ5PIkA6FdPhkoohRL7q/Roprepo?t=1m7FP6U1ZjpxKs8j-1) - Prototipagem das Páginas
* [HTML](https://developer.mozilla.org/pt-BR/docs/Web/HTML) - Estruturação HTTP
* [CSS](https://developer.mozilla.org/pt-BR/docs/Web/CSS) - Estilização condizente à plataforma Roblox
* [JS](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript) - Manipulação Frontend, como DOM
* [Postgres](https://www.postgresql.org/) - Persistência dos dados dos usuários e seus atributos
* [PHP](https://www.php.net/) - Trata a lógica de credenciais (login e senha)

![Icons](https://skillicons.dev/icons?i=vscode,figma,html,css,js,postgres,php)

## 📃 Como Executar

Para que este projeto funcione conforme o esperado, é necessário configurar alguns elementos do PHP:

* Ativar a extensão `pdo_pgsql` em `php.ini` para permitir a conexão PDO com PostgreSQL.
* Caso sua distribuição PHP não carregue automaticamente, ative também `pgsql`.
* Ativar `mbstring` para permitir validações de tamanho de texto multibyte usadas em `backend/auth/access.php`.
* As demais funcionalidades usam módulos nativos do PHP, como `session`, `json`, `filter` e `password`.

**Configuração de Ambiente:**

* Copiar `.env.example` para `.env` na root `/` e configurar as credenciais do PostgreSQL:

``` plain
    DB_HOST=localhost
    DB_NAME=roprepo_db
    DB_USER=postgres
    DB_PASS=
```

* Importar o esquema + dados básicos banco com o arquivo `docs/sql/dump.sql` através do comando abaixo.
* Executar estas instruções no bash:

```bash
    createdb -U postgres roprepo_db
    psql -d roprepo_db -U postgres -f docs/sql/dump.sql   
    cd public
    php -S localhost:8080 index.php
```

Por padrão, os três campos pré-existentes no dump são:

* `title: Player`
* `role: user, admin`

> Levar isto em consideração quando forkar o projeto.

**Porquê mencionar index.php**: Considerando sua atuação como o Front-Controller do projeto, é necessário que todas as requisições passem por ele. Caso contrário, o cliente pode tentar acessar arquivos percorrendo caminhos internos do servidor. Além disso, o roteamento mantém as URLs limpas através de instruções simples, como `/catalog`, que só é executada por estar registrada em `backend/routes/render.php`

**Problema**: Seguindo esta abordagem, qualquer caminho que o navegador tentar acessar (como um arquivo css), será obrigatoriamente interceptado pelo servidor através do Front-Controller, não renderizando como o esperado. Para contorná-lo, existe uma lista de extensões permitidas em `backend/config/allowed_extensions.php` que é executada pelo index, o que permite a passagem destes arquivos considerados estáticos.

Sem um servidor Apache, esta é a forma mais limpa de resolver.
