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

        <!-- Contraseña -->
        <div style="margin-bottom: 1.5rem;">
            <label for="password">Contraseña</label>
            <input id="password" class="input-dark" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: #f87171; font-size: 0.85rem; margin-top: 0.5rem;" />
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
</x-guest-layout>
