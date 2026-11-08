<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de tu aplicación. Laravel lo usa cuando necesita
    | mostrarlo en una notificación o en otros elementos de la interfaz.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor indica en qué entorno se está ejecutando la aplicación
    | (local, producción, etc.) y puede cambiar cómo se configuran algunos
    | servicios. Se define en el archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de depuración
    |--------------------------------------------------------------------------
    |
    | Con el modo debug activado, cada error muestra un mensaje detallado con
    | su traza. Si está desactivado, solo se muestra una página de error
    | genérica.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la aplicación
    |--------------------------------------------------------------------------
    |
    | Artisan usa esta URL para generar enlaces correctos desde la consola.
    | Debe apuntar a la raíz de tu aplicación.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona horaria de la aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí se define la zona horaria por defecto que usan las funciones de
    | fecha y hora de PHP. Por defecto es "UTC", que sirve para la mayoría
    | de los casos.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Configuración de idioma
    |--------------------------------------------------------------------------
    |
    | El idioma (locale) define qué idioma usan por defecto los métodos de
    | traducción de Laravel. Puede ser cualquier idioma para el que tengas
    | textos traducidos.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Clave de cifrado
    |--------------------------------------------------------------------------
    |
    | Los servicios de cifrado de Laravel usan esta clave, que debe ser una
    | cadena aleatoria de 32 caracteres para que los datos cifrados estén
    | seguros. Defínela antes de desplegar la aplicación.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver del modo mantenimiento
    |--------------------------------------------------------------------------
    |
    | Estas opciones definen el driver que controla el estado de "modo
    | mantenimiento". El driver "cache" permite controlarlo desde varias
    | máquinas a la vez.
    |
    | Drivers disponibles: "file", "cache", "array"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];