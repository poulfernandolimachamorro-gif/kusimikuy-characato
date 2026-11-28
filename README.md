# KusiMikuy Characato (Comida Alegre)
### Gestión de asistencia, almacén y caja para el Comedor Popular "Niño Jesús" de Characato, Arequipa

**Universidad Continental · Facultad de Ingeniería · Programación Web (NRC 40537, 2026-20)**
Integrantes: Angie Daniela Huaman Alarcon · Poul Fernando Lima Chamorro

🔗 **Aplicación en línea:** https://kusimikuy-characato.onrender.com

> La aplicación está en el plan gratuito de Render: si lleva más de 15 minutos sin uso, la primera carga puede tardar cerca de un minuto. Los datos son de demostración y **se regeneran cada vez que el servicio se reinicia**.

---

## 1. Descripción

KusiMikuy es una aplicación web sobre **Laravel 13** que reemplaza los cuadernos manuales del comedor: unifica el padrón de familias, el marcado diario de asistencia con cobro automático de cuotas, el control del almacén (Kardex) con el tope municipal de 6.00 kg de arroz por día, los gastos, los lotes, los menús, los documentos legales y el informe mensual en PDF para la Municipalidad Provincial de Arequipa.

## 2. Funcionalidades

| Código | Funcionalidad |
|---|---|
| RF-01 | Inicio de sesión con contraseñas Bcrypt y dos roles: Encargada y Voluntario. |
| RF-02 | Padrón de beneficiarios (CRUD con baja lógica y paginación), identificados con códigos anonimizados (BEN-CHA-001). |
| RF-03 | Registro de asistencia: la cuota (S/ 5.00 socio, S/ 8.00 público) se toma del padrón; un solo marcado por día y por persona; límite de raciones por persona; exoneración por vulnerabilidad autorizada solo por la Encargada. |
| RF-04 | Bloqueo transaccional al superar 6.00 kg de arroz diarios (40 raciones de 0.15 kg). |
| RF-05 | Documentos legales con alerta de vigencia (Vigente / Por vencer / Vencido). |
| RF-06 | Informe mensual de rendición de cuentas en PDF: ingresos, gastos, consumo de arroz del Kardex y mermas del mes elegido. |
| RF-07 a RF-10 | Insumos (con protección del Arroz Común y autonomía estimada del almacén), gastos, lotes con semáforo de calidad, menús y recetas (sin insumos agotados). |
| RF-11 | Control de asistencia diaria: quién asistió y quién no, cupo disponible y suplentes sugeridos (ausentes con menos asistencias en 30 días). |

El panel principal alerta de lotes defectuosos o por vencer, insumos con stock bajo o agotado y documentos por vencer.

### Permisos por rol

| Módulo | Encargada | Voluntario |
|---|---|---|
| Registrar asistencia y Control de asistencia | ✅ | ✅ |
| Kardex (consulta de stock) | ✅ | ✅ |
| Padrón, insumos, gastos, lotes, menús, documentos y reportes | ✅ | ❌ (HTTP 403) |
| Exonerar una cuota | ✅ | ❌ |

El registro público (`/register`) está bloqueado: las cuentas las crea el equipo mediante el seeder o por consola.

## 3. Tecnologías

Laravel 13 (PHP 8.4) · Laravel Breeze (autenticación) · Eloquent y Query Builder · Blade con CSS propio (modo oscuro / glassmorphism) · Font Awesome · DomPDF (informes) · SQLite en desarrollo, pruebas y demostración (MySQL 8 documentado para producción) · Docker · Render.

## 4. Instalación local

Requisitos: **PHP 8.4 o superior** (con las extensiones `gd`, `zip` y `sqlite`), **Composer 2** y Git.

```bash
git clone https://github.com/poulfernandolimachamorro-gif/kusimikuy-characato.git
cd kusimikuy-characato
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```
Abre http://127.0.0.1:8000. En `.env.example`, `APP_DEBUG` viene en `false`; para ver el detalle de los errores al programar, cámbialo a `true` solo en tu `.env` local.

## 5. Cuentas de demostración

Las cuentas demo (Encargada y Voluntario) toman su contraseña de las variables de entorno DEMO_ENCARGADA_PASSWORD y DEMO_VOLUNTARIO_PASSWORD, que no están en el repositorio y se entregan al docente por separado. En la sección 9, agrega esas dos variables a la lista de Render.

## 6. Datos de demostración

`php artisan migrate:fresh --seed` ejecuta `DatabaseSeeder` y `DemoDataSeeder`. Se crean 80 familias anonimizadas, 10 días de asistencias con su ingreso en caja, gastos con comprobante, lotes (uno defectuoso y uno por vencer), menús, documentos (una resolución por vencer) e insumos con el semáforo en sus tres estados. Todos los datos son **ficticios**. Los seeders son idempotentes: pueden ejecutarse varias veces sin duplicar registros.

La jornada de hoy queda con unas 34 raciones servidas: al registrar dos comensales con 4 raciones cada uno, el segundo será rechazado por el tope de 6 kg.

## 7. Pruebas automatizadas

```bash
php artisan test
```
Ejecuta **46 pruebas** sobre SQLite en memoria: autenticación y perfil (Breeze, incluido el bloqueo de `/register`), asistencia (tarifa desde el padrón, duplicado, límite por persona y tope de 6 kg), control de asistencia (acceso por rol, resumen, cupo y suplentes), validación de formularios, protección del Arroz Común, autonomía del almacén, informe mensual y cabeceras de seguridad.

## 8. Seguridad

Referencia: OWASP Top 10 (2021).

| Categoría | Medidas aplicadas |
|---|---|
| A01 Control de acceso | Rutas privadas con `auth`; middleware `rol` apoyado en un Gate; autorización dentro de cada Form Request; exoneración solo de la Encargada; sin borrado de cuenta desde el perfil. |
| A02 Criptografía | Contraseñas con Bcrypt; HTTPS con HSTS; cookies de sesión `Secure` y `HttpOnly`. |
| A03 Inyección | Eloquent y Query Builder con parámetros (las únicas expresiones `DB::raw` llevan constantes); escape de Blade (`{{ }}`) sin `{!! !!}`; validación en el servidor con Form Requests, listas permitidas (`in`, `exists`) y datos entregados solo vía `validated()`. |
| A04 Diseño inseguro | Límite global de 100 peticiones por minuto y por IP; recuperación de contraseña con respuesta genérica (no revela si un correo existe); un solo marcado de asistencia por día, también con índice UNIQUE. |
| A05 Configuración | `APP_DEBUG=false` en producción; cabeceras `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, COOP y CORP; `X-Powered-By` oculto; PHP sin mostrar errores. Limitación conocida: la política CSP admite estilos y scripts en línea porque las vistas actuales los incluyen. |
| A06 Componentes | `composer audit` y `npm audit` sin vulnerabilidades; Laravel actualizado. |
| A07 Autenticación | Login limitado a 5 intentos; regeneración de sesión; registro público bloqueado. |
| A08 Integridad | Font Awesome con integridad de subrecursos (SRI). |
| A09 Registro | Se registran los inicios de sesión fallidos y los accesos denegados (solo IP y agente, nunca contraseñas). |

El archivo `.env`, la carpeta `vendor` y las credenciales no se versionan. CSRF activo con `@csrf` en todos los formularios.

## 9. Despliegue en Render (Docker)

El `Dockerfile` (imagen `php:8.4-cli`) y el script `start.sh` de la raíz construyen y arrancan la aplicación: crean la base SQLite, ejecutan `php artisan migrate --force --seed` y levantan el servidor en el puerto que asigna Render. Cada cambio en `main` se redespliega automáticamente.

Variables de entorno del servicio (configuradas en Render, no en el repositorio): `APP_NAME`, `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY`, `APP_URL`, `APP_TIMEZONE=America/Lima`, `DB_CONNECTION=sqlite`, `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`, `SESSION_SECURE_COOKIE=true`, `LOG_CHANNEL=stderr` y `LOG_LEVEL=warning`. Ruta de salud: `/up`.

Respaldo: etiqueta `v1.0-respaldo` y rama `respaldo-estable` en este repositorio.

Limitaciones: el plan gratuito suspende el servicio tras 15 minutos sin tráfico y no tiene disco persistente, por lo que la base se recrea en cada arranque. La aplicación usa el servidor integrado de PHP, adecuado para la demostración; para uso real se plantea un VPS con Nginx, PHP-FPM y MySQL 8.

## 10. Estructura principal

```
app/Http/Controllers/   Beneficiario, ControlAsistencia, Kardex, Insumo, Gasto, Lote, Menu, Documento, Reporte, Dashboard
app/Http/Requests/      Form Requests con las reglas y mensajes en español
app/Http/Middleware/    CheckRole (alias "rol") y SecurityHeaders
app/Services/           KardexService (transacciones, tope de 6 kg y tarifas)
database/seeders/       DatabaseSeeder y DemoDataSeeder
resources/views/        Vistas Blade
tests/Feature/          Pruebas automatizadas
```

## 11. Uso de inteligencia artificial

Se empleó un asistente de IA como apoyo en la revisión de seguridad, las pruebas automatizadas, la depuración del despliegue y la redacción técnica. Todo el código fue revisado, aplicado y verificado por los integrantes.