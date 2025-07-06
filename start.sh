#!/bin/bash
set -e

echo "🚀 Iniciando Sistema de Reservas..."

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
                \$pdo = new PDO(
                    'pgsql:host=' . (\$_ENV['DATABASE_HOST'] ?? '127.0.0.1') . 
                    ';port=' . (\$_ENV['DATABASE_PORT'] ?? '5432') . 
                    ';dbname=' . (\$_ENV['DATABASE_NAME'] ?? 'reserva_aulas_z6gw'),
                    \$_ENV['DATABASE_USERNAME'] ?? 'root',
                    \$_ENV['DATABASE_PASSWORD'] ?? 'PBTCcvkFvAELvXknzQQdrxGyWb6zDGWm'
                );
                echo 'Connected';
                exit(0);
            } catch (Exception \$e) {
                exit(1);
            }
        " > /dev/null 2>&1; then
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
