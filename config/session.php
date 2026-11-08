<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de sesión por defecto
    |--------------------------------------------------------------------------
    |
    | Esta opción define el driver de sesión que se usa por defecto en las
    | peticiones entrantes. Laravel soporta varias opciones de
    | almacenamiento para guardar los datos de sesión. El almacenamiento en
    | base de datos es una buena opción por defecto.
    |
    | Soportados: "file", "cookie", "database", "memcached",
    |             "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Duración de la sesión
    |--------------------------------------------------------------------------
    |
    | Aquí se indican los minutos que una sesión puede permanecer inactiva
    | antes de expirar. Si quieres que expire apenas se cierre el
    | navegador, puedes indicarlo con la opción expire_on_close.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Cifrado de la sesión
    |--------------------------------------------------------------------------
    |
    | Esta opción permite indicar que todos los datos de sesión se cifren
    | antes de guardarse. Laravel hace el cifrado automáticamente y puedes
    | usar la sesión con normalidad.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Ubicación de los archivos de sesión
    |--------------------------------------------------------------------------
    |
    | Con el driver "file", las sesiones se guardan en disco. Aquí se define
    | la ubicación por defecto, pero puedes indicar otra donde quieras
    | guardarlas.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexión de base de datos de la sesión
    |--------------------------------------------------------------------------
    |
    | Con los drivers "database" o "redis", puedes indicar la conexión que
    | administra las sesiones. Debe corresponder a una conexión de la
    | configuración de base de datos.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Tabla de sesiones en la base de datos
    |--------------------------------------------------------------------------
    |
    | Con el driver "database", puedes indicar la tabla donde se guardan las
    | sesiones. Ya hay un valor por defecto, pero puedes cambiarlo por
    | otra tabla.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Almacén de caché de la sesión
    |--------------------------------------------------------------------------
    |
    | Con los backends de sesión basados en caché, puedes definir el almacén
    | de caché que guarda los datos entre peticiones. Debe coincidir con
    | uno de tus almacenes de caché definidos.
    |
    | Afecta a: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Lotería de limpieza de sesiones
    |--------------------------------------------------------------------------
    |
    | Algunos drivers deben limpiar manualmente su almacenamiento para
    | eliminar sesiones viejas. Aquí se define la probabilidad de que eso
    | ocurra en una petición. Por defecto, 2 de cada 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nombre de la cookie de sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puedes cambiar el nombre de la cookie de sesión que crea el
    | framework. Normalmente no hace falta cambiarlo, porque no mejora la
    | seguridad de forma importante.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Ruta de la cookie de sesión
    |--------------------------------------------------------------------------
    |
    | La ruta de la cookie define desde qué ruta se considera disponible.
    | Normalmente es la raíz de tu aplicación, pero puedes cambiarla si
    | hace falta.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Dominio de la cookie de sesión
    |--------------------------------------------------------------------------
    |
    | Este valor define el dominio y los subdominios a los que está
    | disponible la cookie. Por defecto, está disponible para el dominio
    | raíz sin subdominios. Normalmente no se cambia.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Cookies solo HTTPS
    |--------------------------------------------------------------------------
    |
    | Si esta opción es true, las cookies de sesión solo se envían de vuelta
    | al servidor cuando el navegador usa una conexión HTTPS. Así se evita
    | enviarlas cuando no se puede hacer de forma segura.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Acceso solo por HTTP
    |--------------------------------------------------------------------------
    |
    | Si este valor es true, JavaScript no puede leer el valor de la cookie
    | y esta solo es accesible mediante el protocolo HTTP. Es poco probable
    | que debas desactivar esta opción.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Cookies Same-Site
    |--------------------------------------------------------------------------
    |
    | Esta opción define cómo se comportan tus cookies en peticiones entre
    | sitios y sirve para mitigar ataques CSRF. Por defecto se usa "lax",
    | que permite peticiones seguras entre sitios.
    |
    | Ver: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Soportados: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Cookies particionadas
    |--------------------------------------------------------------------------
    |
    | Si este valor es true, la cookie queda ligada al sitio de nivel
    | superior en un contexto entre sitios. El navegador acepta cookies
    | particionadas cuando están marcadas como "secure" y el atributo
    | Same-Site es "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | Serialización de la sesión
    |--------------------------------------------------------------------------
    |
    | Este valor controla cómo se serializan los datos de sesión, por
    | defecto en JSON. Con "php" se pueden guardar objetos PHP en la
    | sesión, pero la aplicación puede quedar vulnerable a ataques de
    | serialización "gadget chain" si se filtra la APP_KEY.
    |
    | Soportados: "json", "php"
    |
    */

    'serialization' => 'json',

];
