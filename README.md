
# Guia de Instalação do Projeto Laravel

Este guia fornece as instruções passo a passo para instalar e configurar o projeto Laravel, incluindo a instalação de dependências PHP e JavaScript.

## Pré-requisitos

Antes de começar, certifique-se de que você tem as seguintes ferramentas instaladas:

- **PHP** (versão 8.x ou superior)
- **Composer** (gerenciador de dependências PHP)
- **Node.js** (versão 16.x ou superior)
- **npm** (gerenciador de pacotes Node.js)

## Passos para Instalação

### 1. Clonar o Repositório

Clone o repositório do projeto para sua máquina local:

```bash
git clone <URL_DO_REPOSITORIO>
cd <NOME_DA_PASTA_DO_PROJETO>
```

### 2. Instalar Dependências PHP

Instale as dependências PHP do projeto usando o Composer. Se você não tiver o Composer instalado, siga as instruções na [documentação oficial do Composer](https://getcomposer.org/download/).

```bash
composer install
```

### 3. Configurar o Ambiente

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

### 4. Instalar Dependências JavaScript

Instale as dependências JavaScript usando o npm. Se você não tiver o Node.js e o npm instalados, siga as instruções na [documentação oficial do Node.js](https://nodejs.org/).

```bash
npm install
```

### 5. Executar Migrações do Banco de Dados

Execute as migrações do banco de dados para criar as tabelas necessárias:

```bash
php artisan migrate
```

### 6. Iniciar o Servidor de Desenvolvimento

Inicie o servidor de desenvolvimento Laravel:

```bash
php artisan serve
```

### 7. Verificar o Funcionamento

Acesse o aplicativo via navegador em `http://localhost:8000` para garantir que tudo está funcionando corretamente.

## Comandos Úteis

- **Executar testes**: `php artisan test`
- **Rodar o linting de JavaScript**: `npm run lint`
- **Compilar os ativos (JavaScript e CSS)**: `npm run dev` para desenvolvimento, `npm run prod` para produção

## Problemas Comuns

- **Erro de conexão com o banco de dados**: Verifique as configurações no arquivo `.env` e certifique-se de que o banco de dados está rodando.
- **Problemas com JWT**: Verifique se a chave secreta JWT está configurada corretamente e se o arquivo `config/jwt.php` está atualizado.
- **Dependências não instaladas**: Certifique-se de ter executado `composer install` e `npm install` corretamente.

## Contribuindo

Se você deseja contribuir para o projeto, siga o fluxo de trabalho Git padrão: faça um fork do repositório, crie uma branch para suas alterações e envie um pull request.

---

Esse `README.md` fornece um guia completo para configurar o ambiente de desenvolvimento para um projeto Laravel, incluindo a instalação de dependências e configuração do ambiente. Ajuste conforme necessário para o seu projeto específico.