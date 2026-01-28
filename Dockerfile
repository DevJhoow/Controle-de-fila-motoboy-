FROM php:8.2-apache

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Apache
RUN a2enmod rewrite

# 🔥 CONFIG DO APACHE PARA LARAVEL
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Projeto
COPY . /var/www/html
WORKDIR /var/www/html

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

RUN php artisan config:clear && php artisan cache:clear 

# Migrations automáticas (Render Free)
RUN php artisan migrate --force || true

EXPOSE 80
