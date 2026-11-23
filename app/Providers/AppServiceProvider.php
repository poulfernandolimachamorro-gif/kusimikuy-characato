<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Autorización por rol (A01): el middleware CheckRole consulta este Gate
        Gate::define('rol', fn ($usuario, string $rol) => $usuario->rol === $rol);

        // A09: se registran los inicios de sesión fallidos (solo IP y agente; nunca la contraseña)
        Event::listen(Failed::class, function (Failed $evento) {
            Log::warning('Intento de inicio de sesión fallido', [
                'ip'     => request()->ip(),
                'agente' => substr((string) request()->userAgent(), 0, 120),
            ]);
        });

        // Fuerza HTTPS si el entorno no es local o si viene a través de un Proxy HTTPS
        if (config('app.env') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }

        // Configuración explícita de URL raíz para el entorno de GitHub Codespaces
        if (isset($_SERVER['CODESPACE_NAME'])) {
            $codespaceName = $_SERVER['CODESPACE_NAME'];
            $port = 8000; // Puerto por defecto del servidor de desarrollo de Laravel
            $url = "https://{$codespaceName}-{$port}.app.github.dev";
            
            URL::forceRootUrl($url);
            URL::forceScheme('https');
        }
    }
}