<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email" :value="old('email')"
                class="block w-full bg-theme-bg border border-white/20 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard transition-colors placeholder-gray-600"
                placeholder="admin@sena.edu.co"
                required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Contraseña</label>
            <input id="password" type="password" name="password"
                class="block w-full bg-theme-bg border border-white/20 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard transition-colors placeholder-gray-600"
                placeholder="••••••••"
                required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-white/20 bg-theme-bg text-theme-mustard shadow-sm focus:ring-theme-mustard" name="remember">
                <span class="text-sm text-gray-400">Recordarme</span>
            </label>
        </div>

        <div class="mt-6 flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-xs text-gray-500 hover:text-theme-mustard transition-colors" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <button type="submit" class="px-6 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-sm">
                Ingresar →
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-xs text-gray-600 border-t border-white/10 pt-4">
        <a href="{{ url('/') }}" class="text-gray-500 hover:text-theme-mustard transition-colors">
            ← Volver al portal de aprendices
        </a>
    </div>
</x-guest-layout>
