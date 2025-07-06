#!/bin/bash
set -e

echo "🚀 Iniciando Sistema de Reservas..."

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando conexión a la base de datos..."
php artisan migrate:status || echo "Base de datos no disponible aún"

# Crear directorios necesarios
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache

# Configurar permisos
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generando clave de aplicación..."
    php artisan key:generate --force
fi

# Limpiar y optimizar
echo "🧹 Limpiando caché..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders si es necesario
if [ "$RUN_SEEDERS" = "true" ]; then
    echo "🌱 Ejecutando seeders..."
    php artisan db:seed --force
fi

echo "✅ Sistema de Reservas iniciado correctamente!"

# Iniciar Apache
exec apache2-foreground
