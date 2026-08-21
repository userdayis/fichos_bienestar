<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Día del Aprendiz - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans flex items-center justify-center min-h-screen relative">
    <div class="max-w-lg w-full mx-4 text-center">
        <!-- Header -->
        <div class="mb-10">
            <div class="text-xs tracking-[0.2em] text-theme-mustard font-semibold mb-2 uppercase">Día del aprendiz · SENA</div>
            <h1 class="text-5xl font-extrabold text-white mb-4">El ficho</h1>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Sistema de registro y control de vales para el Día del Aprendiz.</p>
        </div>

        <!-- Card -->
        <div class="bg-theme-panel rounded-2xl shadow-2xl p-8 text-left border border-white/10">
            <h2 class="text-2xl font-bold text-white mb-2">Bienvenido</h2>
            <p class="text-gray-400 mb-8 text-sm leading-relaxed">Inicia sesión para acceder al panel de control o validación de fichos.</p>
            
            <div class="flex flex-col gap-4">
                <a href="{{ route('login') }}" class="w-full py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-center text-lg">
                    Iniciar Sesión
                </a>
                <a href="{{ url('/') }}" class="w-full py-3 bg-white/5 border border-white/20 text-gray-300 hover:bg-white/10 font-bold rounded-xl transition-colors text-center">
                    Ver mi ficho (Aprendiz)
                </a>
            </div>
        </div>

        <div class="mt-6 text-xs text-gray-600">
            &copy; {{ date('Y') }} SENA &middot; Sistema de Fichos
        </div>
    </div>
</body>
</html>
