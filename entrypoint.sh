#!/bin/bash

set -e  # Detener ejecución si hay errores

echo "Iniciando configuración de Laravel..."

# Instalar dependencias solo si no están instaladas
if [ ! -d "vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Asignar permisos a las carpetas necesarias
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Esperar a la base de datos antes de continuar
echo "Esperando a que PostgreSQL esté listo..."
sleep 10  # Ajusta según sea necesario

# Ejecutar migraciones
php artisan migrate --force

# Generar clave de Laravel si no existe .env
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Iniciar Apache
exec apache2-foreground