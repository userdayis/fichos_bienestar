<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Día del Aprendiz - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans flex items-center justify-center min-h-screen relative">
    <div class="absolute top-0 w-full bg-sena h-3 shadow-md"></div>
    <div class="max-w-xl w-full mx-4 bg-white rounded-xl shadow-lg p-10 text-center border-t-4 border-sena">
        <h1 class="text-4xl font-extrabold text-sena mb-2 uppercase tracking-wide">SENA</h1>
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Día del Aprendiz</h2>
        <p class="text-gray-500 mb-8 text-lg">Bienvenido al sistema de registro y control de fichos y actividades.</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-sena hover:bg-sena-dark text-white rounded-lg font-semibold transition-colors shadow-md">
                        Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-sena hover:bg-sena-dark text-white rounded-lg font-semibold transition-colors shadow-md">
                        Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-semibold transition-colors shadow-sm">
                            Registrarse
                        </a>
                    @endif
                @endauth
            @endif
        </div>
        
        <div class="mt-12 text-sm text-gray-400 font-medium">
            &copy; {{ date('Y') }} SENA - Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
