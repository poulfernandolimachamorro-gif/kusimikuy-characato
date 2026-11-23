<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // La decisión pasa por el Gate "rol" (AppServiceProvider); las denegaciones quedan registradas (A09)
        if (!auth()->check() || Gate::denies('rol', $rol)) {
            Log::warning('Acceso denegado por rol', [
                'usuario' => auth()->id(),
                'ruta'    => $request->path(),
                'ip'      => $request->ip(),
            ]);
            abort(403, 'Acceso denegado. No tienes permisos de ' . $rol);
        }
        return $next($request);
    }
}