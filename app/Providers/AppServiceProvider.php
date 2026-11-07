<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fuerza a Laravel a usar HTTPS en todos los formularios y redirecciones si no es local o mediante proxy
        if (config('app.env') !== 'local' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }

        // Configuración explícita de URL raíz para GitHub Codespaces
        if (isset($_SERVER['CODESPACE_NAME'])) {
            $codespaceName = $_SERVER['CODESPACE_NAME'];
            $port = 8000; // El puerto donde corre Laravel
            $url = "https://{$codespaceName}-{$port}.app.github.dev";
            
            URL::forceRootUrl($url);
            URL::forceScheme('https');
        }
    }
}