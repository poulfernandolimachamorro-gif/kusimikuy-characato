<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery as Middleware;

/**
 * Protección CSRF de Laravel sin la cookie XSRF-TOKEN. Esa cookie solo sirve a librerías JavaScript
 * (Axios, Angular) que envían el token en una cabecera; esta aplicación no hace peticiones AJAX:
 * sus formularios incluyen el token con @csrf.
 */
class PreventRequestForgery extends Middleware
{
    protected $addHttpCookie = false;
}