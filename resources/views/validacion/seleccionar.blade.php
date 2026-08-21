<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Actividad - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans min-h-screen flex flex-col items-center justify-center px-4">

    <div class="w-full max-w-sm text-center">
        <div class="mb-8">
            <div class="w-12 h-12 bg-sena rounded-xl flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-black text-sm leading-none text-center">SE<br>NA</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white mb-2">Selecciona tu punto</h1>
            <p class="text-gray-400 text-sm">Elige la actividad que vas a validar en este turno.</p>
        </div>

        <div class="space-y-3">
            @foreach($actividades as $actividad)
                <a href="{{ route('validacion.index', ['actividad' => $actividad->id]) }}" 
                   class="block w-full bg-theme-panel border border-white/10 hover:border-theme-mustard/50 rounded-2xl p-5 text-left transition-all hover:shadow-lg group">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-white font-bold group-hover:text-theme-mustard transition-colors">{{ $actividad->nombre }}</div>
                            <div class="text-gray-500 text-xs mt-0.5">{{ $actividad->descripcion ?? 'Punto de entrega' }}</div>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 group-hover:text-theme-mustard transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition-colors">Cerrar sesión</button>
            </form>
        </div>
    </div>

</body>
</html>
