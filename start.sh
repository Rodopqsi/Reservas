#!/bin/bash
set -e

echo "🚀 Iniciando Sistema de Reservas..."

# Mostrar información de entorno
echo "📋 Información del entorno:"
echo "DB_CONNECTION: ${DB_CONNECTION:-'no configurado'}"
echo "DB_HOST: ${DB_HOST:-'no configurado'}"
echo "DB_PORT: ${DB_PORT:-'no configurado'}"
echo "DB_DATABASE: ${DB_DATABASE:-'no configurado'}"
echo "DB_USERNAME: ${DB_USERNAME:-'no configurado'}"
echo "APP_ENV: ${APP_ENV:-'no configurado'}"
echo "APP_DEBUG: ${APP_DEBUG:-'no configurado'}"

# Función para esperar a que la base de datos esté disponible
wait_for_db() {
    echo "⏳ Esperando a que la base de datos esté disponible..."
    
    # Intentar conectar a la base de datos hasta 30 veces
    for i in {1..30}; do
        if php artisan db:monitor > /dev/null 2>&1; then
            echo "✅ Base de datos conectada!"
            return 0
        fi
        
        # Si db:monitor no existe, usar una verificación simple
        if php -r "
            try {
                \$host = \$_ENV['DB_HOST'] ?? '127.0.0.1';
                \$port = \$_ENV['DB_PORT'] ?? '5432';
                \$dbname = \$_ENV['DB_DATABASE'] ?? 'reserva_aulas';
                \$username = \$_ENV['DB_USERNAME'] ?? 'root';
                \$password = \$_ENV['DB_PASSWORD'] ?? '';
                
                echo 'Intentando conectar a: ' . \$host . ':' . \$port . ' db=' . \$dbname . PHP_EOL;
                
                \$pdo = new PDO(
                    'pgsql:host=' . \$host . ';port=' . \$port . ';dbname=' . \$dbname,
                    \$username,
                    \$password
                );
                echo 'Connected successfully' . PHP_EOL;
                exit(0);
            } catch (Exception \$e) {
                echo 'Error: ' . \$e->getMessage() . PHP_EOL;
                exit(1);
            }
        " 2>&1; then
            echo "✅ Base de datos conectada!"
            return 0
        fi
        
        echo "⏳ Intento $i/30 - esperando base de datos..."
        sleep 2
    done
    
    echo "❌ No se pudo conectar a la base de datos después de 60 segundos"
    return 1
}

# Limpiar configuraciones
echo "🧹 Limpiando configuraciones..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Esperar a la base de datos
wait_for_db

# Configurar para producción
echo "⚡ Configurando para producción..."
php artisan config:cache

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders
echo "🌱 Ejecutando seeders..."
php artisan db:seed --force

echo "✅ ¡Sistema iniciado correctamente!"

# Iniciar servidor
echo "🌐 Iniciando servidor en puerto 8080..."
exec php artisan serve --host=0.0.0.0 --port=8080
