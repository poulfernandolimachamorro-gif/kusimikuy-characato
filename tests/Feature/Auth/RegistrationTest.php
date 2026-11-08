<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_cannot_be_rendered_publicly(): void
    {
        $response = $this->get('/register');
        $this->assertTrue($response->status() === 404 || $response->status() === 403);
    }

    public function test_public_user_registration_is_blocked_by_server_policy(): void
    {
        $response = $this->post('/register', [
            'name' => 'Intruso Web',
            'email' => 'intruso@gmail.com',
            'password' => 'Hack2026*',
            'password_confirmation' => 'Hack2026*',
        ]);
        $this->assertTrue($response->status() === 404 || $response->status() === 403);
    }
}