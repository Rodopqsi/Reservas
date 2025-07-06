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
    libpq-dev

# Instalar extensiones PHP para PostgreSQL
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Crear directorio build y manifest con la estructura correcta
RUN mkdir -p public/build/assets && \
    echo '{"resources/css/app.css":{"file":"assets/app-C2HWaN36.css","src":"resources/css/app.css","isEntry":true},"resources/js/app.js":{"file":"assets/app-Bf4POITK.js","name":"app","src":"resources/js/app.js","isEntry":true}}' > public/build/manifest.json && \
    touch public/build/assets/app-C2HWaN36.css && \
    touch public/build/assets/app-Bf4POITK.js

# Copiar y configurar script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD ["/start.sh"]
