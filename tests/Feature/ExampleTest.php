<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Verifica que la raíz del sistema ejecute una redirección segura hacia el login.
     */
    public function test_the_application_redirects_unauthenticated_user_to_login(): void
    {
        $response = $this->get('/');

        // Cambiamos el assert para validar la redirección real (302)
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}