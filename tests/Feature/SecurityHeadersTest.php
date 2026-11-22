<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Verifica que las respuestas web incluyan las cabeceras de seguridad del middleware SecurityHeaders.
 */
class SecurityHeadersTest extends TestCase
{
    public function test_las_respuestas_web_incluyen_cabeceras_de_seguridad(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Content-Security-Policy');
    }
}