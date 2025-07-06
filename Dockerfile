FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP para PostgreSQL
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario no-root
RUN groupadd -r appuser && useradd -r -g appuser appuser

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Crear archivo .env temporal para el build
RUN cp .env.build .env

# Crear directorios necesarios y configurar permisos
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database && \
    touch database/database.sqlite && \
    chmod -R 755 storage bootstrap/cache && \
    chown -R appuser:appuser . && \
    chmod -R 755 .

# Cambiar a usuario no-root
USER appuser

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias Node.js y construir assets
RUN npm install && npm run build

# Cambiar de vuelta a root para el comando final
USER root

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["sh", "-c", "chown -R appuser:appuser /var/www && su appuser -c 'php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8080'"]