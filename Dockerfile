FROM php:8.2-fpm

# Instala dependências e extensões PHP
RUN apt-get update && apt-get install -y \
    iputils-ping \
    netcat-openbsd \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Copia o código-fonte para o contêiner
COPY . /var/www/html