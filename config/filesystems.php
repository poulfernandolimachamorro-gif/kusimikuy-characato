<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disco de archivos por defecto
    |--------------------------------------------------------------------------
    |
    | Aquí se indica el disco de archivos que usa el framework por defecto.
    | El disco "local" y varios discos en la nube están disponibles para que
    | tu aplicación guarde archivos.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Discos de archivos
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar todos los discos que necesites, incluso varios
    | para el mismo driver. Se incluyen ejemplos de la mayoría de los
    | drivers soportados como referencia.
    |
    | Drivers soportados: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Enlaces simbólicos
    |--------------------------------------------------------------------------
    |
    | Aquí se configuran los enlaces simbólicos que se crean al ejecutar el
    | comando de Artisan `storage:link`. Las claves del arreglo son las
    | ubicaciones de los enlaces y los valores son sus destinos.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];