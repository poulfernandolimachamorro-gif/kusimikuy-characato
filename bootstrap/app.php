<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Carga explicita de rutas de autenticación de Breeze
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Confiar en los cabezales proxy para GitHub Codespaces
        $middleware->trustProxies(at: '*');

        // Registro de alias para control de acceso por roles
        $middleware->alias([
            'rol' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Cabeceras de seguridad (CSP, X-Frame-Options, etc.) en todas las respuestas web
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
            'throttle:100,1',   // máx. 100 peticiones por minuto y por IP: frena escaneos y fuerza bruta
        ]);

        $middleware->web(replace: [
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class => \App\Http\Middleware\PreventRequestForgery::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();