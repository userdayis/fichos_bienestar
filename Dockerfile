FROM php:8.3-fpm

# Configurar variables de entorno para Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y Node.js para Vite
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www

# Copiar archivos existentes (excepto los de .dockerignore)
COPY . /var/www

# Instalar dependencias de Composer (optimizadas para producción)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Instalar dependencias de Node y compilar assets (Vite)
RUN npm install && npm run build

# Configurar Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Script de entrada
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Permisos
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto
EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
