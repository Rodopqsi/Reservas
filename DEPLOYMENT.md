# Sistema de Reservas de Aulas

## Deployment en Render

### Configuración Manual

1. **Crear cuenta en Render.com**
   - Ve a [render.com](https://render.com) y crea una cuenta
   - Conecta tu repositorio de GitHub

2. **Crear Base de Datos PostgreSQL**
   - En el dashboard de Render, crea una nueva base de datos PostgreSQL
   - Anota las credenciales generadas (ya tienes: `reserva_aulas_z6gw`)

3. **Crear Web Service**
   - Crea un nuevo Web Service
   - Conecta tu repositorio GitHub
   - Configura las siguientes variables de entorno:

```bash
APP_NAME=Sistema de Reservas
APP_ENV=production
APP_KEY=base64:9hI95u98rZa5om8cdclWoGQATjMXW3pg3ZohW7K+3XY=
APP_DEBUG=false
APP_URL=https://tu-app.onrender.com
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
LOG_LEVEL=error
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Variables de base de datos PostgreSQL (se auto-generan si usas render.yaml)
DATABASE_URL=postgresql://usuario:password@host:puerto/database
```

4. **Configurar Build**
   - Build Command: `docker build -t sistema-reservas .`
   - Start Command: `/start.sh`

### Usando render.yaml (Recomendado)

1. Haz push del archivo `render.yaml` a tu repositorio
2. En Render, selecciona "New from repo" y elige tu repositorio
3. Render detectará automáticamente la configuración

### Variables de Entorno Importantes

- `APP_KEY`: Genera una nueva clave con `php artisan key:generate`
- `APP_URL`: Cambia por tu URL real de Render
- `RUN_SEEDERS`: Establece en `true` si quieres ejecutar seeders en el primer deploy

### Notas

- El plan gratuito de Render tiene limitaciones de recursos
- La base de datos se suspende después de 90 días de inactividad (plan gratuito)
- Para producción, considera usar un plan pago

### Comandos Útiles

```bash
# Generar nueva clave de aplicación
php artisan key:generate

# Ejecutar migraciones manualmente
php artisan migrate --force

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```
