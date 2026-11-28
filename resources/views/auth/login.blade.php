<x-guest-layout>
    <!-- Estado de la sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo Electrónico -->
        <div>
            <label for="email">Correo Electrónico</label>
            <input id="email" class="input-dark" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.85rem; margin-top: 0.4rem;" />
        </div>

        <!-- Contraseña con botón de ojo -->
        <div style="margin-top: 1.25rem;">
            <label for="password">Contraseña</label>
            <div style="position: relative; width: 100%; margin-top: 0.5rem;">
                <input id="password" 
                       class="input-dark" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password" 
                       style="margin-top: 0 !important; padding-right: 3rem !important;" />
                
                <button type="button" 
                        id="toggle-password"
                        title="Mostrar u ocultar contraseña"
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none !important; border: none !important; color: #94a3b8 !important; cursor: pointer; padding: 0.25rem !important; margin: 0 !important; width: auto !important; min-height: auto !important; box-shadow: none !important; z-index: 10;">
                    <i class="fa-solid fa-eye" id="icon-password" style="font-size: 1.1rem;"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.85rem; margin-top: 0.4rem;" />
        </div>

        <!-- Recordarme -->
        <div style="margin-top: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <input id="remember_me" type="checkbox" name="remember" style="margin: 0;">
            <label for="remember_me" style="margin: 0; font-weight: 400; cursor: pointer;">Recordarme</label>
        </div>

        <!-- Olvidaste tu contraseña -->
        <div style="text-align: center; margin-top: 1.25rem;">
            @if (Route::has('password.request'))
                <a class="text-link" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Botón de Iniciar Sesión -->
        <div style="margin-top: 1rem;">
            <button type="submit" class="btn-premium">
                <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
            </button>
        </div>
    </form>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('icon-password');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</x-guest-layout>