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
        // Si estamos en GitHub Codespaces, forzamos la URL correcta
        if (isset($_SERVER['CODESPACE_NAME'])) {
            $codespaceName = $_SERVER['CODESPACE_NAME'];
            $port = 8000; // El puerto donde corre Laravel
            $url = "https://{$codespaceName}-{$port}.app.github.dev";
            
            URL::forceRootUrl($url);
            URL::forceScheme('https');
        } 
        // Si estamos en local, usamos lo que diga el .env
        elseif (config('app.env') === 'local') {
            URL::forceScheme('http');
        }
    }
}