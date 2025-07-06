# Sistema de Reservas de Aulas

## Deployment en Render

### Configuración Automática con render.yaml ✅

El proyecto está configurado para deployment automático usando el archivo `render.yaml`.

#### Pasos para deployment:

1. **Crear cuenta en Render.com**
   - Ve a [render.com](https://render.com) y crea una cuenta
   - Conecta tu repositorio de GitHub

2. **Crear desde repositorio**
   - En el dashboard de Render, haz clic en "New +"
   - Selecciona "Blueprint"
   - Conecta tu repositorio GitHub
   - Render detectará automáticamente el archivo `render.yaml`

3. **Configuración automática**
   - Render creará automáticamente:
     - Base de datos PostgreSQL (`reserva-aulas-db`)
     - Web Service (`reserva-aulas`)
     - Todas las variables de entorno necesarias

#### Variables de entorno configuradas automáticamente:
```yaml
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generada automáticamente>
APP_URL=https://reserva-aulas.onrender.com
DB_CONNECTION=pgsql
DB_HOST=<hostname interno de la base de datos>
DB_PORT=5432
DB_DATABASE=reserva_aulas
DB_USERNAME=reserva_user
DB_PASSWORD=<generada automáticamente>
```

### Proceso de Deployment

1. **Build del contenedor Docker**
2. **Instalación de dependencias PHP**
3. **Configuración de permisos**
4. **Inicio del servicio**:
   - ⏳ Verificación de conectividad a la base de datos
   - 🧹 Limpieza de configuraciones
   - 📊 Ejecución de migraciones
   - 🌱 Ejecución de seeders
   - 🌐 Inicio del servidor en puerto 8080

### Arquitectura

```
├── Dockerfile              # Configuración del contenedor
├── start.sh                # Script de inicio con validaciones
├── render.yaml             # Configuración de Render (automática)
├── .dockerignore          # Archivos excluidos del build
├── .env.example           # Ejemplo de variables de entorno
└── DEPLOYMENT.md          # Esta documentación
```

### Troubleshooting

#### Error de conexión a la base de datos
- Verificar que la base de datos esté creada y disponible
- Revisar logs del deployment en Render
- El script `start.sh` incluye debug detallado de la conexión

#### Problemas de permisos
- El Dockerfile configura los permisos necesarios
- Si persisten problemas, verificar logs del contenedor

#### Verificar deployment
- URL: `https://reserva-aulas.onrender.com`
- Logs disponibles en el dashboard de Render
- El script de inicio incluye información detallada del entorno

### Comandos Útiles para Debug Local

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

# Verificar conectividad a la base de datos
php artisan tinker
# En tinker: DB::connection()->getPdo();
```

### Limitaciones del Plan Gratuito

- CPU y memoria limitados
- Base de datos se suspende después de 90 días de inactividad
- Para producción, considerar usar un plan pago

### Próximos Pasos

1. Hacer push de los cambios al repositorio
2. Crear el Blueprint en Render usando el archivo `render.yaml`
3. Monitorear el deployment en el dashboard de Render
4. Verificar que la aplicación esté funcionando correctamente
