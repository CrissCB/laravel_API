# API con Laravel y Docker

Este es un proyecto que utiliza Laravel y Docker para la creación de una API de manera rápida y sencilla.

## Instalación

Sigue estos pasos para instalar y ejecutar la API:

1. **Clona o descarga el proyecto:**

   ```sh
   git clone https://github.com/CrissCB/laravel_API.git
   cd laravel_API
   ```

2. **Abre una terminal en la carpeta del proyecto.**

3. **Levanta los contenedores con Docker Compose:**

   ```sh
   docker-compose up -d
   ```

4. **Accede al contenedor de la API:**

   ```sh
   docker-compose exec api bash
   ```

5. **Instala las dependencias de Laravel:**

   ```sh
   composer install
   ```

6. **Ejecuta las migraciones de la base de datos:**

   ```sh
   php artisan migrate
   ```

Con estos pasos, ya tendrás tu API en un contenedor Docker lista para usarse.

## Notas

- Asegúrate de tener **Docker** y **Docker Compose** instalados en tu sistema.
- Puedes acceder a la API a través de `http://localhost` (o el puerto configurado en `docker-compose.yml`).

