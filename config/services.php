<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Servicios de terceros
    |--------------------------------------------------------------------------
    |
    | Este archivo sirve para guardar las credenciales de servicios de
    | terceros, como Resend, Postmark, AWS y otros. Es la ubicación
    | habitual para este tipo de datos, y permite que los paquetes tengan
    | un archivo convencional donde buscar las credenciales.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];