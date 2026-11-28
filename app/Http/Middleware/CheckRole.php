<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Acepta uno o varios roles permitidos (p. ej. "rol:Encargada,Voluntario").
     * La decisión pasa por el Gate "rol" (AppServiceProvider); las denegaciones quedan registradas (A09).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $permitido = auth()->check()
            && collect($roles)->contains(fn (string $rol) => Gate::allows('rol', $rol));

        if (!$permitido) {
            Log::warning('Acceso denegado por rol', [
                'usuario' => auth()->id(),
                'ruta'    => $request->path(),
                'ip'      => $request->ip(),
            ]);
            abort(403, 'Acceso denegado. No tienes permisos de ' . implode(' o ', $roles));
        }

        return $next($request);
    }
}