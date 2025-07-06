#!/bin/bash
set -e

echo "🚀 Iniciando Sistema de Reservas..."

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
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

# Esperar a que la base de datos esté disponible
echo "⏳ Esperando conexión a la base de datos..."
until php artisan migrate:status 2>/dev/null; do
    echo "Esperando base de datos..."
    sleep 5
done

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
