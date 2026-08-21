#!/bin/sh

# Ejecutar migraciones y comandos de optimización de Laravel
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar PHP-FPM en segundo plano
php-fpm -D

# Iniciar Nginx en primer plano (para mantener el contenedor vivo)
nginx -g "daemon off;"
