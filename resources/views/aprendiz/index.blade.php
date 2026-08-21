<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día del Aprendiz - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="border-b border-white/10 bg-theme-panel/60 backdrop-blur-sm sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sena rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-[10px] leading-none text-center">SE<br>NA</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm leading-tight">Día del Aprendiz</div>
                    <div class="text-gray-500 text-[10px] tracking-widest uppercase">Sistema de Fichos</div>
                </div>
            </div>
            <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Staff / Admin
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md">

            <!-- Hero Text -->
            <div class="text-center mb-10">
                <div class="inline-block px-3 py-1 rounded-full bg-sena/20 border border-sena/30 text-sena text-xs font-semibold tracking-wider mb-4">
                    ● SISTEMA DE VALES ACTIVO
                </div>
                <h1 class="text-4xl font-extrabold text-white leading-tight mb-3">
                    Consulta tu<br><span class="text-theme-mustard">ficho</span>
                </h1>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Ingresa tu número de documento para ver el estado de tus actividades y códigos de validación.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-2xl p-8">
                @if($errors->any())
                    <div class="bg-red-900/40 border border-red-700/40 text-red-300 rounded-xl p-4 mb-6 text-sm flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('aprendiz.buscar') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="documento" class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">
                            Número de documento
                        </label>
                        <input
                            id="documento"
                            type="text"
                            name="documento"
                            value="{{ old('documento') }}"
                            placeholder="Ej: 1045234812"
                            required
                            autofocus
                            class="w-full bg-theme-bg border border-white/20 text-white font-mono text-xl px-5 py-4 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard transition-colors placeholder-gray-700 tracking-wider"
                        >
                    </div>

                    <button type="submit" class="w-full py-4 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 active:scale-95 font-extrabold rounded-xl transition-all shadow-lg text-base flex items-center justify-center gap-2">
                        Ver mi ficho
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                </form>

                <p class="text-center text-xs text-gray-600 mt-6 leading-relaxed">
                    ¿No apareces en el sistema? Acércate al stand de soporte cerca de la entrada principal.
                </p>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-5 text-center">
        <p class="text-xs text-gray-700">&copy; {{ date('Y') }} SENA &middot; Todos los derechos reservados</p>
    </footer>

</body>
</html>
