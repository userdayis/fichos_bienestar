#!/bin/sh

# Asegurar directorios de almacenamiento necesarios
mkdir -p /var/www/storage/framework/cache/data
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

# Ejecutar descubrimiento de paquetes, migraciones y seeders
php artisan package:discover --ansi
php artisan migrate --force --seed

# Limpiar y recrear caché de configuración, rutas y vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajustar permisos para que el usuario del servidor web (www-data) pueda escribir en storage y bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Iniciar PHP-FPM en segundo plano
php-fpm -D

# Iniciar Nginx en primer plano
nginx -g "daemon off;"
