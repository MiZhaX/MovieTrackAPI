# Etapa 1: Construcción con PHP y Composer
FROM php:8.2-fpm AS build

RUN apt-get update && apt-get install -y \
    libzip-dev unzip zip git curl nginx \
    && docker-php-ext-install pdo_mysql zip

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Etapa 2: Imagen final con PHP-FPM y Nginx configurado
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y nginx

COPY --from=build /var/www/html /var/www/html

# Copia archivo de configuración nginx
COPY ./nginx.conf /etc/nginx/sites-enabled/default

# Ajusta permisos si hace falta (opcional)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80 HTTP para Render
EXPOSE 80

# Inicia PHP-FPM y Nginx juntos con supervisord o un script
CMD service php8.2-fpm start && nginx -g "daemon off;"
