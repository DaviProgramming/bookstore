# Descrição do Projeto

#### O projeto é um sistema de gerenciamento de livros desenvolvido para permitir aos usuários criar, editar e excluir livros de uma biblioteca digital. A aplicação oferece um sistema de autenticação baseado em JSON Web Tokens (JWT) para garantir a segurança e a privacidade das operações realizadas pelos usuários.

# Finalidade
####  A finalidade deste sistema é oferecer uma plataforma eficiente e segura para o gerenciamento de livros, ideal para bibliotecas digitais e catálogos de livros online

# Guia de Instalação e Configuração do Projeto Laravel

Este guia fornece instruções passo a passo para instalar e configurar o projeto Laravel, incluindo a instalação de dependências PHP e JavaScript e a configuração do banco de dados PostgreSQL usando Docker.

## Pré-requisitos

Certifique-se de que você tem as seguintes ferramentas instaladas:

- **PHP** (versão 8.x ou superior)
- **Composer** (gerenciador de dependências PHP)
- **Node.js** (versão 16.x ou superior)
- **npm** (gerenciador de pacotes Node.js)
- **Docker** (versão 20.x ou superior)
- **Docker Compose** (versão 1.29.x ou superior)

## Passos para Instalação

### 1. Clonar o Repositório

Clone o repositório do projeto para sua máquina local:

```bash
git clone https://github.com/DaviProgramming/bookstore
cd bookstore
```

### 2. Configurar o Docker

Certifique-se de que o Docker está configurado corretamente para o banco de dados PostgreSQL.

1. **Iniciar o Docker e o Banco de Dados**

   Execute os seguintes comandos para iniciar o banco de dados PostgreSQL no Docker:

   ```bash
   docker-compose up -d
   ```

   O Docker irá construir e iniciar o contêiner do banco de dados PostgreSQL conforme definido no arquivo `docker-compose.yml`.

### 3. Configurar as Variáveis de Ambiente

1. **Copiar o Arquivo `.env`**

   O arquivo `.env` contém as variáveis de ambiente para o seu projeto. Você deve copiar o arquivo `.env.example` para `.env`:

   ```bash
   cp .env.example .env
   ```

2. **Configurar as Variáveis de Ambiente**

   Abra o arquivo `.env` e configure as variáveis de ambiente de acordo com seu ambiente de desenvolvimento. Certifique-se de configurar:

   - Conexão com o banco de dados
   - Configurações JWT

   **Exemplo de configuração para PostgreSQL:**

   ```plaintext
   DB_CONNECTION=pgsql
   DB_HOST=localhost
   DB_PORT=5432
   DB_DATABASE=bookstore
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

   **Exemplo de configuração para JWT:**

   ```plaintext
   JWT_SECRET=<sua_chave_secreta_gerada>
   JWT_ALGO=HS256
   JWT_REFRESH_TTL=20160
   ```

   - Para gerar a chave secreta JWT, execute o comando:

     ```bash
     php artisan jwt:secret
     ```

### 4. Instalar Dependências PHP

Instale as dependências PHP usando Composer:

```bash
composer install
```

### 5. Instalar Dependências JavaScript

Instale as dependências JavaScript:

```bash
npm install
```

### 6. Executar Migrações do Banco de Dados

Execute as migrações do banco de dados para criar as tabelas necessárias:

```bash
php artisan migrate
```

### 7. Verificar o Funcionamento

Acesse o aplicativo via navegador em `http://localhost:8000` para garantir que tudo está funcionando corretamente.

### 8. Documentação da API

A documentação completa da API está disponível para consulta, onde você pode encontrar informações detalhadas sobre os endpoints, parâmetros e exemplos de requisição e resposta.

Acesse a documentação da API aqui: [Documentação](https://documenter.getpostman.com/view/38198843/2sAXjRWpUt#intro)

## Comandos Úteis

- **Parar o Docker e o banco de dados**: `docker-compose down`
- **Verificar logs do Docker**: `docker-compose logs`
- **Executar comandos dentro do contêiner Docker**: `docker-compose exec <nome_do_serviço> <comando>`

## Problemas Comuns

- **Erro de conexão com o banco de dados**: Verifique as configurações no arquivo `.env` e certifique-se de que o contêiner do banco de dados está rodando.
- **Problemas com JWT**: Verifique se a chave secreta JWT está configurada corretamente e se o arquivo `config/jwt.php` está atualizado.
- **Dependências não instaladas**: Certifique-se de ter executado `composer install` e `npm install` corretamente.

