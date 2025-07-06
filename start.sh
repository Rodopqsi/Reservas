#!/bin/bash

# Configurar permisos
chmod -R 755 storage bootstrap/cache

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders
php artisan db:seed --force

# Limpiar cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar servidor
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}