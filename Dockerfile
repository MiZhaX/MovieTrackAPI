# Usa la imagen oficial de PHP con FPM
FROM php:8.2-fpm

# Instala dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    zip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todos los archivos al contenedor
COPY . .

# Instala dependencias de PHP con Composer
RUN composer install --optimize-autoloader --no-dev

# Corre las optimizaciones de Laravel para producción
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000

# Inicia PHP-FPM
CMD ["php-fpm"]
