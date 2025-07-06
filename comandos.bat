@echo off
title Sistema de Reserva de Aulas - Comandos de Desarrollo

:menu
cls
echo ===============================================
echo    SISTEMA DE RESERVA DE AULAS
echo    Comandos de Desarrollo
echo ===============================================
echo.
echo 1. Iniciar servidor de desarrollo
echo 2. Ejecutar migraciones
echo 3. Ejecutar seeders
echo 4. Limpiar cache
echo 5. Compilar assets (desarrollo)
echo 6. Compilar assets (producción)
echo 7. Resetear base de datos
echo 8. Ver estado de migraciones
echo 9. Salir
echo.
set /p opcion=Selecciona una opción (1-9): 

if "%opcion%"=="1" goto servidor
if "%opcion%"=="2" goto migraciones
if "%opcion%"=="3" goto seeders
if "%opcion%"=="4" goto cache
if "%opcion%"=="5" goto assets_dev
if "%opcion%"=="6" goto assets_prod
if "%opcion%"=="7" goto reset_db
if "%opcion%"=="8" goto estado_migraciones
if "%opcion%"=="9" goto salir

echo Opción no válida. Presiona cualquier tecla para continuar...
pause >nul
goto menu

:servidor
echo Iniciando servidor de desarrollo...
echo.
echo Credenciales de acceso:
echo Admin: admin@ejemplo.com / password
echo Profesores: profesor1@ejemplo.com / password
echo.
php artisan serve --host=localhost --port=8000
pause
goto menu

:migraciones
echo Ejecutando migraciones...
php artisan migrate
echo.
echo Migraciones completadas.
pause
goto menu

:seeders
echo Ejecutando seeders...
php artisan db:seed
echo.
echo Seeders completados.
pause
goto menu

:cache
echo Limpiando cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo.
echo Cache limpiado.
pause
goto menu

:assets_dev
echo Compilando assets para desarrollo...
npm run dev
echo.
echo Assets compilados para desarrollo.
pause
goto menu

:assets_prod
echo Compilando assets para producción...
npm run build
echo.
echo Assets compilados para producción.
pause
goto menu

:reset_db
echo ¿Estás seguro de que quieres resetear la base de datos? (S/N)
set /p confirm=
if /i "%confirm%"=="S" (
    echo Reseteando base de datos...
    php artisan migrate:fresh --seed
    echo.
    echo Base de datos reseteada.
) else (
    echo Operación cancelada.
)
pause
goto menu

:estado_migraciones
echo Estado de las migraciones:
php artisan migrate:status
echo.
pause
goto menu

:salir
echo Saliendo...
exit
