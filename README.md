# Aplicación web de gestión

Aplicación web desarrollada con Laravel para administrar clientes y contenedores relacionados. Incluye operaciones CRUD, validaciones, relaciones Eloquent, migraciones, seeders y pruebas automatizadas.

## Funcionalidades

### Clientes

- Crear, listar, consultar, editar y eliminar clientes.
- Validar que el documento no esté repetido.
- Mostrar la cantidad de contenedores asociados a cada cliente.

### Contenedores

- Crear, listar, consultar, editar y eliminar contenedores.
- Asociar cada contenedor con un cliente.
- Validar que el código del contenedor no esté repetido.
- Manejar los tipos `Seco` e `Isotanque`.
- Manejar los estados `Almacenado`, `En lavado` y `En reparación`.
- Impedir que un contenedor `Seco` sea guardado con estado `En lavado`.
- Usar `Almacenado` como estado predeterminado.

## Tecnologías

- PHP 8.3 o superior.
- Laravel 13.
- SQLite como base de datos predeterminada.
- Composer.
- Blade para las vistas.
- Bootstrap cargado desde CDN.
- PHPUnit para pruebas automatizadas.

La aplicación utiliza Blade para renderizar las páginas. En el estado actual no requiere Node.js, npm, Vite ni `npm run dev` para instalarse o ejecutarse.

## Requisitos previos

Verifica que la máquina tenga instalado PHP y Composer:

```bash
php --version
composer --version
```

Se recomienda utilizar:

- PHP 8.3 o superior.
- Composer 2.
- SQLite habilitado en PHP.

### Instalar PHP

Descarga PHP desde [php.net](https://www.php.net/downloads.php) o utiliza el gestor de paquetes de tu sistema operativo.

En Windows puedes utilizar herramientas como Laragon, XAMPP o una instalación independiente de PHP. Asegúrate de agregar PHP al `PATH` del sistema.

### Instalar Composer

Descarga Composer desde [getcomposer.org](https://getcomposer.org/download/).

Después de instalarlo, valida la instalación:

```bash
composer --version
```

### Instalar Laravel

Para ejecutar este proyecto no es necesario instalar Laravel globalmente. Laravel se instala como dependencia local del proyecto mediante Composer.

Si deseas instalar también el instalador global de Laravel, puedes hacerlo con:

```bash
composer global require laravel/installer
```

Esto es opcional y no reemplaza la instalación de las dependencias del proyecto.

## Instalación en otra máquina

### 1. Descargar el proyecto

Clona el repositorio y entra en la carpeta del proyecto:

```bash
git clone <URL_DEL_REPOSITORIO>
cd <CARPETA_DEL_PROYECTO>
```

Reemplaza los valores entre `< >` con los datos reales del repositorio.

### 2. Instalar las dependencias de PHP

```bash
composer install
```

### 3. Crear el archivo de configuración

En macOS o Linux:

```bash
cp .env.example .env
```

En Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

No copies el archivo `.env` de otra máquina. Cada instalación debe tener su propia configuración local.

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Configurar SQLite

La configuración predeterminada utiliza SQLite. Si el archivo de base de datos no existe, créalo.

En macOS o Linux:

```bash
touch database/database.sqlite
```

En Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

En `.env`, confirma la conexión:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Si tu instalación requiere una ruta absoluta, configura la ruta completa del archivo SQLite.

También puedes utilizar MySQL o PostgreSQL modificando las variables `DB_*` del archivo `.env` y creando previamente la base de datos.

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

Las migraciones crean las tablas de la aplicación y las tablas internas requeridas por Laravel.

### 7. Cargar datos de prueba

El seeder genera:

- 10 clientes.
- 30 contenedores.
- Relaciones entre clientes y contenedores.
- Estados válidos de acuerdo con el tipo de contenedor.

Ejecuta:

```bash
php artisan db:seed
```

Para reconstruir la base de datos desde cero y volver a cargar los datos de prueba:

```bash
php artisan migrate:fresh --seed
```

> `migrate:fresh --seed` elimina los datos existentes de la base de datos configurada. Utilízalo únicamente cuando quieras reiniciar el entorno.

### 8. Iniciar la aplicación

```bash
php artisan serve
```

La aplicación estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

## Ejecutar las pruebas

Para ejecutar toda la suite PHPUnit:

```bash
php artisan test
```

También puedes ejecutar PHPUnit directamente:

```bash
vendor/bin/phpunit
```

Las pruebas utilizan SQLite en memoria y no modifican la base de datos local configurada en `.env`.

Las pruebas cubren, entre otros casos:

- Creación de clientes.
- Conteo de contenedores asociados.
- Documentos duplicados.
- Creación de contenedores secos.
- Estado predeterminado de nuevos contenedores.
- Restricción de `Seco` con estado `En lavado`.
- Permiso de `Isotanque` con estado `En lavado`.
- Redirección inicial de la aplicación.

## Comandos útiles

Limpiar la caché de configuración:

```bash
php artisan config:clear
```

Limpiar todas las cachés:

```bash
php artisan optimize:clear
```

Consultar las rutas disponibles:

```bash
php artisan route:list
```

Consultar el estado de las migraciones:

```bash
php artisan migrate:status
```

Formatear el código PHP con Laravel Pint:

```bash
vendor/bin/pint
```

## Estructura principal

```text
app/
├── Http/Controllers/
│   ├── ClientController.php
│   └── ContainerController.php
└── Models/
    ├── Client.php
    └── Container.php

database/
├── factories/
├── migrations/
└── seeders/

resources/views/
├── clients/
├── containers/
└── layouts/

routes/
└── web.php

tests/
├── Feature/
└── Unit/
```

## Solución de problemas

### `composer` no es reconocido

Composer no está instalado o no fue agregado al `PATH`. Instálalo nuevamente y reinicia la terminal.

### `php` no es reconocido

PHP no está instalado o no fue agregado al `PATH`. Verifica la instalación y la variable de entorno.

### Error relacionado con `APP_KEY`

Ejecuta:

```bash
php artisan key:generate
```

### Error de conexión con SQLite

Verifica que exista `database/database.sqlite` y que `.env` tenga:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Después ejecuta:

```bash
php artisan config:clear
php artisan migrate
```

### Error de permisos en `storage` o `bootstrap/cache`

Laravel necesita permisos de escritura en esas carpetas. Ajusta los permisos de acuerdo con el sistema operativo y el servidor web utilizado.