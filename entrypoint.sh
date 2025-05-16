#!/bin/sh
set -e

# Dar permisos correctos
chmod -R 777 storage bootstrap/cache

# Instalar dependencias si no existen
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-dev --optimize-autoloader
fi

# Generar clave de aplicación
php artisan key:generate || echo "⚠️ No se pudo generar la clave de la aplicación"

# Ejecutar migraciones
php artisan migrate --force || echo "⚠️ No se pudieron ejecutar las migraciones"

# Generar documentación de la API (opcional)
php artisan l5-swagger:generate || echo "⚠️ No se pudo generar Swagger"

# Iniciar Apache
apache2-foreground
dos2unix entrypoint.sh
chmod +x entrypoint.sh