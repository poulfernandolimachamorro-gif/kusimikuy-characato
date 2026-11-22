<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Agrega cabeceras HTTP de seguridad a todas las respuestas web (OWASP A05: configuración de seguridad).
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

        // Evita que la aplicación se muestre dentro de un iframe ajeno (clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');
        // El navegador no debe "adivinar" tipos MIME
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // No filtrar la URL completa hacia otros sitios
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        // La aplicación no necesita cámara, micrófono ni geolocalización
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        $response->headers->set('Content-Security-Policy', implode('; ', [
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
        ]));

        // HSTS solo tiene sentido cuando la petición llegó por HTTPS (en local no se envía)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}