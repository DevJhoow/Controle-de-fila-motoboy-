FROM php:8.2-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia configuração do Apache (IMPORTANTE)
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia o projeto Laravel
COPY . /var/www/html

WORKDIR /var/www/html

# Instala composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissões para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
