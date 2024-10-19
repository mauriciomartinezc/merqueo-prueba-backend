# Proyecto Laravel: Simulador de Torneos

Este proyecto es una aplicación desarrollada con el framework Laravel que permite gestionar torneos deportivos. Incluye funcionalidades para administrar equipos, jugadores y partidas, y simular torneos con rondas eliminatorias hasta determinar el ganador final.

## Requisitos Previos

Antes de comenzar, asegúrate de tener los siguientes requisitos:

- **PHP** >= 8.2
- **Composer** (para gestionar dependencias de PHP)
- **Docker** y **Docker Compose** (opcional, para un entorno de desarrollo más consistente)
- **Node.js** y **npm** (para gestionar los assets del frontend)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto:

1. **Clonar el repositorio**:

2. **Instalar las dependencias de PHP**:

3. **Instalar las dependencias de Node.js**:

4. **Configurar el archivo de entorno**:
   Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`. Luego, ajusta las configuraciones necesarias:

   Genera la clave de aplicación de Laravel:

5. **Ejecutar las migraciones** para crear las tablas de base de datos:

6. **Levantar el entorno con Docker Compose**:
   Si prefieres usar Docker para gestionar el entorno, puedes ejecutar:

   El archivo `docker-compose.yml` define los siguientes servicios:

    - **app**: El servicio principal de Laravel, expuesto en el puerto `8000` tanto en el contenedor como en la máquina local.
    - **db**: Un contenedor de MySQL, configurado para correr en el puerto `3306` dentro del contenedor, pero no está expuesto directamente al host.

## Uso

El proyecto permite gestionar equipos, jugadores y simular torneos. Las principales funcionalidades incluyen:

- **Administración de Equipos**: Crear, editar, ver y eliminar equipos.
- **Administración de Jugadores**: Crear, editar, ver y eliminar jugadores.
- **Simulación de Torneos**: Generar partidos, agruparlos por rondas y visualizar el avance del torneo hasta la final.

### Estructura del Proyecto

A continuación, se detalla la estructura principal del proyecto, incluyendo modelos, servicios, controladores, validaciones de solicitudes, vistas y comandos:

#### Modelos

- **Country**: Representa los países participantes en el torneo.
- **Team**: Representa los equipos, incluyendo su país de origen y detalles adicionales.
- **Player**: Define los jugadores asociados a los equipos.
- **Game**: Representa los juegos del torneo, incluyendo detalles como los equipos participantes, resultados y estado del juego.

#### Servicios

- **Team Services**: Servicios para gestionar la lógica de negocios relacionada con los equipos:
    - `TeamStoreService`: Crea un nuevo equipo.
    - `TeamUpdateService`: Actualiza la información de un equipo.
    - `TeamIndexService`: Lista todos los equipos.
    - `TeamShowService`: Muestra los detalles de un equipo específico.
    - `TeamDestroyService`: Elimina un equipo.
- **Player Services**: Servicios para gestionar la lógica de los jugadores:
    - `PlayerStoreService`: Crea un nuevo jugador.
    - `PlayerUpdateService`: Actualiza la información de un jugador.
    - `PlayerIndexService`: Lista todos los jugadores.
    - `PlayerShowService`: Muestra los detalles de un jugador específico.
    - `PlayerDestroyService`: Elimina un jugador.
- **GameService**: Gestiona la lógica relacionada con los juegos del torneo, incluyendo la agrupación por rondas y la obtención del juego final y el de tercer puesto.

#### Controladores

- **TeamController**: Controlador para gestionar las solicitudes relacionadas con los equipos, incluyendo crear, editar, eliminar y listar equipos.
- **PlayerController**: Controlador para gestionar las solicitudes relacionadas con los jugadores, incluyendo crear, editar, eliminar y listar jugadores.
- **TournamentController**: Controlador para manejar la simulación de torneos y la organización de juegos.

#### Validaciones de Solicitudes

- **TeamRequest**: Válida los datos de entrada para las solicitudes relacionadas con los equipos, asegurando que la información requerida esté presente y en el formato adecuado.
- **PlayerRequest**: Válida los datos de entrada para las solicitudes relacionadas con los jugadores.

#### Vistas

- Las vistas del proyecto están diseñadas para mostrar la información de los equipos, jugadores y los torneos, utilizando Blade como el motor de plantillas de Laravel. Las vistas incluyen tablas para listar los equipos y jugadores, así como paneles para ver los detalles de los juegos y el progreso del torneo.

#### Comandos

- **SimulateGames**: Comando de consola que permite simular los juegos de un torneo completo. Agrupa los juegos en rondas y muestra los resultados de cada una hasta llegar a la final.

  Para ejecutarlo, usa el siguiente comando:
  
`docker-compose exec app php artisan simulate:games`

## Pruebas

El proyecto incluye un conjunto de pruebas unitarias para verificar la lógica de los servicios y controladores.

Para ejecutar las pruebas:

`docker-compose exec app php artisan test`

O usando PHPUnit directamente:

Las pruebas incluyen validaciones para los servicios de jugadores, equipos y simulación de juegos, asegurando el correcto funcionamiento de la lógica del negocio.

