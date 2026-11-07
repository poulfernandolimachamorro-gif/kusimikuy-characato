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