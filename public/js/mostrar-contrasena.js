// Botón "ojo" para mostrar u ocultar la contraseña.
// Va en un archivo externo para que funcione con la política CSP (script-src 'self').
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-password]').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var input = document.getElementById(boton.getAttribute('data-toggle-password'));
            if (!input) { return; }

            var estabaVisible = input.type === 'text';
            input.type = estabaVisible ? 'password' : 'text';

            boton.setAttribute('aria-pressed', estabaVisible ? 'false' : 'true');
            boton.setAttribute('aria-label', estabaVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
            boton.querySelector('.icono-ojo').style.display = estabaVisible ? 'inline' : 'none';
            boton.querySelector('.icono-ojo-tachado').style.display = estabaVisible ? 'none' : 'inline';
        });
    });
});