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
   docker-compose up --build
   ```

Con estos pasos, ya tendrás tu API en un contenedor Docker lista para usarse.

## Notas

- Asegúrate de tener **Docker** y **Docker Compose** instalados en tu sistema.
- Puedes acceder a la API a través de `http://localhost` (o el puerto configurado en `docker-compose.yml`).
- los puertos que utiliza por defecto son el `8000:80` para la pagina de laravel y el `5432:5432` para la base de datos si necesitas cambiar los puertos lo puedes hacer desde el archivo `docker-compose.yaml`.

