<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Valores por defecto de autenticación
    |--------------------------------------------------------------------------
    |
    | Esta opción define el "guard" de autenticación y el "broker" de
    | restablecimiento de contraseña que se usan por defecto. Puedes
    | cambiarlos si lo necesitas, pero sirven para la mayoría de los casos.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards de autenticación
    |--------------------------------------------------------------------------
    |
    | Aquí se definen los guards de la aplicación. La configuración por
    | defecto usa sesiones junto con el proveedor de usuarios Eloquent.
    |
    | Todos los guards tienen un proveedor de usuarios, que define cómo se
    | obtienen los usuarios desde la base de datos u otro almacenamiento.
    | Normalmente se usa Eloquent.
    |
    | Soportado: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Proveedores de usuarios
    |--------------------------------------------------------------------------
    |
    | Todos los guards tienen un proveedor de usuarios, que define cómo se
    | obtienen los usuarios desde la base de datos u otro almacenamiento.
    | Normalmente se usa Eloquent.
    |
    | Si tienes varias tablas o modelos de usuarios, puedes configurar varios
    | proveedores y asignarlos a los guards adicionales que definas.
    |
    | Soportado: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Restablecimiento de contraseñas
    |--------------------------------------------------------------------------
    |
    | Estas opciones definen cómo funciona el restablecimiento de contraseña:
    | la tabla donde se guardan los tokens y el proveedor que obtiene a los
    | usuarios.
    |
    | El tiempo de expiración son los minutos que un token se considera
    | válido. Mantenerlo corto reduce el riesgo de que alguien lo adivine.
    |
    | El throttle son los segundos que un usuario debe esperar antes de
    | generar otro token. Así se evita crear muchos tokens seguidos.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    | Aquí se define cuántos segundos pasan antes de que expire la
    | confirmación de contraseña y se vuelva a pedir al usuario. Por defecto
    | dura tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];