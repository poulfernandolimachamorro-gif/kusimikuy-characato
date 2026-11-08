# Plataforma Web KusiMikuy - Gestión Integral de Asistencias y Almacén

### 🏛️ Universidad Continental - Facultad de Ingeniería
**Proyecto de Ingeniería de Software y Programación Web**
*Entorno de Aplicación:* Comedor Popular "Niño Jesús" de Characato, Arequipa.

---

## 📝 1. Descripción del Sistema
KusiMikuy es una plataforma web desarrollada sobre la arquitectura de **Laravel 13.x** diseñada para disolver la brecha analógica y mitigar la carga burocrática del Comedor Popular de Characato. El sistema unifica bajo principios transaccionales inmutables el padrón cerrado de familias beneficiarias, el marcaje diario de asistencia con liquidación automática de cuotas diferenciadas, y el control de existencias en el almacén mediante bloqueos pesimistas sobre el Kardex.

## 🛠️ 2. Requisitos del Sistema
Para el despliegue y auditoría técnica del entorno de laboratorio, asegúrese de contar con los siguientes componentes mínimos instalados:
*   **PHP:** v8.2 o superior.
*   **Composer:** Dependency Manager para PHP v2.x.
*   **Node.js:** v18.x o superior junto al empaquetador npm.
*   **Motor de Base de Datos:** SQLite Engine v3.x (nativo e integrado).

## 🚀 3. Instrucciones de Instalación y Despliegue Técnico
Siga de manera secuencial los comandos descritos a continuación en su terminal de desarrollo para inicializar el ecosistema de software desde cero:

### Paso 1: Clonación del Repositorio Oficial
```bash
git clone https://github.com/poulfernandolimachamorro-gif/kusimikuy-characato.git
cd kusimikuy-characato
```

### Paso 2: Instalación de Dependencias del Backend
```bash
composer install
```

### Paso 3: Inicialización del Archivo de Persistencia Local
```bash
touch database/database.sqlite
```

### Paso 4: Configuración de Variables de Entorno (.env)
```bash
cp .env.example .env
```
*(Nota: El framework viene preconfigurado por defecto para detectar de forma automática el conector nativo `DB_CONNECTION=sqlite` sin requerir credenciales externas).*

### Paso 5: Ejecución del Suministro y Poblamiento de Datos (Seeds)
```bash
php artisan migrate:fresh --seed
```

### Paso 6: Compilación de Recursos Estáticos del Frontend
```bash
npm install
npm run build
```

### Paso 7: Arranque del Servidor de Desarrollo Local
```bash
php artisan serve
```
El sistema estará disponible para su auditoría en el navegador web local a través de la URL de bucle de retorno: `http://127.0.0.1:8000`.

## 👥 4. Credenciales de Acceso para Auditoría Académica (RBAC)
Las cuentas demo aprovisionadas de forma automatizada por el Seeder del sistema para validar la matriz de control de accesos son las siguientes:

*   **Rol Encargada (Acceso Total de Gestión):**
    *   *Email:* `felipe.characato@gmail.com`
    *   *Password:* `Characato2026*`
*   **Rol Voluntario (Operaciones de Cocina):**
    *   *Email:* `voluntario.characato@gmail.com`
    *   *Password:* `Voluntario2026*`

## 🧪 5. Suite de Pruebas Automatizadas
Para verificar la integridad del código, el aislamiento de endpoints públicos y la robustez de las transacciones atómicas del Kardex, ejecute la suite de verificación nativa:
```bash
php artisan test
```