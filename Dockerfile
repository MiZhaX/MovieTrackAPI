# Imagen base oficial PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    zip unzip git curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia todo el proyecto al contenedor
COPY . /var/www/html/

# Establece permisos a las carpetas necesarias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cambia el DocumentRoot al directorio public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Habilita mod_rewrite en Apache (importante para Laravel routes)
RUN a2enmod rewrite

# Instala dependencias de PHP (sin dev)
RUN composer install --no-dev --optimize-autoloader

# Cache de configuración y rutas
RUN php artisan config:cache && php artisan route:cache

# Expone el puerto (Render usará esto)
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
