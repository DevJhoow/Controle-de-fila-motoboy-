FROM php:8.2-apache

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Apache
RUN a2enmod rewrite

# Projeto
COPY . /var/www/html
WORKDIR /var/www/html

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Laravel deps
RUN composer install --no-dev --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# 🔥 RODA MIGRATIONS AUTOMATICAMENTE
RUN php artisan key:generate || true
RUN php artisan migrate --force || true

EXPOSE 80
