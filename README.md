# KusiMikuy Characato

Sistema web de gestión operativa, control de Kardex y transparencia de caja para el Comedor Popular "Niño Jesús" de Characato, Arequipa.

## Descripción
Plataforma desarrollada en Laravel 13.x que implementa una arquitectura MVC con capa de servicios (Service Layer) para automatizar el registro de asistencia, controlar el límite municipal de 6kg de arroz, gestionar el padrón de beneficiarios, y exportar informes contables en PDF para la fiscalización de la MPA.

## Requisitos
- PHP 8.3+
- Composer
- Node.js & NPM
- SQLite (Desarrollo) / MySQL (Producción)

## Instalación
1. Clonar el repositorio: `git clone https://github.com/poulfernandolimachamorro-gif/kusimikuy-characato.git`
2. Instalar dependencias: `composer install`
3. Copiar el archivo de entorno: `cp .env.example .env`
4. Generar la clave de la aplicación: `php artisan key:generate`
5. Ejecutar las migraciones y seeders: `php artisan migrate --seed`
6. Instalar dependencias frontend: `npm install && npm run build`
7. Iniciar el servidor: `php artisan serve --host=0.0.0.0 --port=8000`

## Usuarios Demo
- **Rol Encargada:** `felipe.characato@gmail.com` / Contraseña: `Characato2026*`
- **Rol Voluntario:** (Se puede crear/editando el rol del usuario anterior en la base de datos).

## Estructura del Proyecto
- `app/Http/Controllers`: Controladores delgados (Thin Controllers).
- `app/Services`: Lógica de negocio centralizada (KardexService).
- `app/Models`: Modelos Eloquent con SoftDeletes.
- `resources/views`: Vistas Blade con diseño responsivo (Mobile-First).
- `routes/web.php`: Enrutamiento protegido por middlewares de autenticación y roles.