<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Agrega cabeceras HTTP de seguridad a todas las respuestas web (OWASP A05).
 *
 * La política CSP permite 'unsafe-inline' en scripts y estilos porque las vistas del proyecto
 * incluyen <style> y <script> en línea; fuera de eso solo se admiten los CDN que ya usa la interfaz
 * (Font Awesome en cdnjs y Pico CSS en jsDelivr).
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        // Aísla la ventana de la app de otros orígenes
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
            "font-src 'self' data: https://cdnjs.cloudflare.com",
            "img-src 'self' data:",
            "connect-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];

        // Solo bajo HTTPS: HSTS y mejora automática de recursos inseguros (en local no se envían)
        if ($request->isSecure()) {
            $csp[] = 'upgrade-insecure-requests';
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        // No revelar la tecnología del servidor
        header_remove('X-Powered-By');
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}