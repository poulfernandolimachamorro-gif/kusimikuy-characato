<x-guest-layout>
    <!-- Estado de la sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" style="color: #4ade80; margin-bottom: 1rem;" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo electrónico -->
        <div style="margin-bottom: 1.5rem;">
            <label for="email">Correo Electrónico</label>
            <input id="email" class="input-dark" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@kusimikuy.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: #f87171; font-size: 0.85rem; margin-top: 0.5rem;" />
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
                       placeholder="••••••••"
                       style="margin-top: 0 !important; padding-right: 3rem !important;" />

                <button type="button"
                        data-toggle-password="password"
                        aria-label="Mostrar contraseña"
                        aria-pressed="false"
                        title="Mostrar u ocultar contraseña"
                        style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); background: none !important; border: none !important; color: #94a3b8 !important; cursor: pointer; padding: 0.25rem !important; margin: 0 !important; width: auto !important; min-height: auto !important; box-shadow: none !important; z-index: 10; line-height: 0;">
                    <!-- Ojo abierto: la contraseña está oculta -->
                    <svg class="icono-ojo" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <!-- Ojo tachado: la contraseña está visible -->
                    <svg class="icono-ojo-tachado" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display: none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.85rem; margin-top: 0.4rem;" />
        </div>

        <!-- Recordarme -->
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
            <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; cursor: pointer;">
            <label for="remember_me" style="margin: 0; font-weight: 400; color: #94a3b8; cursor: pointer;">Recordarme</label>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; flex-direction: column; gap: 1rem;">
            @if (Route::has('password.request'))
                <a class="text-link" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <button type="submit" class="btn-premium">
                <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
            </button>
        </div>
    </form>

    <script src="{{ asset('js/mostrar-contrasena.js') }}" defer></script>
</x-guest-layout>