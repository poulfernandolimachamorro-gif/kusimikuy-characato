<?php

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Laravel\Sanctum\Http\Middleware\AuthenticateSession;
use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Dominios con estado (stateful)
    |--------------------------------------------------------------------------
    |
    | Las peticiones desde los siguientes dominios o hosts reciben cookies de
    | autenticación con estado para la API. Normalmente se incluyen tus
    | dominios locales y de producción que acceden a la API desde un
    | frontend SPA.
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort(),
        // Sanctum::currentRequestHost(),
    ))),

    /*
    |--------------------------------------------------------------------------
    | Guards de Sanctum
    |--------------------------------------------------------------------------
    |
    | Este arreglo contiene los guards de autenticación que Sanctum revisa
    | al intentar autenticar una petición. Si ninguno puede autenticarla,
    | Sanctum usa el token bearer que venga en la petición.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Minutos de expiración
    |--------------------------------------------------------------------------
    |
    | Este valor controla los minutos que pasan hasta que un token emitido se
    | considera expirado. Reemplaza cualquier valor del atributo
    | "expires_at" del token, pero no afecta a las sesiones propias.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Prefijo de los tokens
    |--------------------------------------------------------------------------
    |
    | Sanctum puede poner un prefijo a los tokens nuevos para aprovechar los
    | escáneres de seguridad de plataformas de código abierto, que avisan a
    | los desarrolladores si suben tokens a un repositorio.
    |
    | Ver: https://docs.github.com/en/code-security/secret-scanning/about-secret-scanning
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Middleware de Sanctum
    |--------------------------------------------------------------------------
    |
    | Al autenticar tu SPA propia con Sanctum, quizá necesites personalizar
    | algunos middleware que Sanctum usa al procesar la petición. Puedes
    | cambiar los middleware de abajo según lo necesites.
    |
    */

    'middleware' => [
        'authenticate_session' => AuthenticateSession::class,
        'encrypt_cookies' => EncryptCookies::class,
        'validate_csrf_token' => ValidateCsrfToken::class,
    ],

];