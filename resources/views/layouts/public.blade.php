<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día del Aprendiz - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans flex flex-col items-center justify-center min-h-screen relative overflow-x-hidden pt-10">
    <div class="text-center mb-8 flex flex-col items-center z-10">
        <div class="text-xs tracking-[0.2em] text-theme-mustard font-semibold mb-2 uppercase">Día del aprendiz · Sistema de vales</div>
        <h1 class="text-5xl font-extrabold text-white mb-4">El ficho</h1>
        <p class="text-gray-400 text-sm max-w-md">Boceto de las 3 pantallas clave: consulta del aprendiz, ticket con QR, y validación en el punto de entrega.</p>
    </div>

    <!-- Navigation Pills -->
    <div class="flex flex-wrap gap-2 mb-12 z-10 justify-center">
        <div class="px-5 py-2 rounded-full border border-gray-600 @if(request()->routeIs('aprendiz.index')) bg-theme-mustard text-black font-semibold border-none @else bg-transparent text-gray-400 text-sm @endif">
            01 &middot; Ingreso por documento
        </div>
        <div class="px-5 py-2 rounded-full border border-gray-600 @if(request()->routeIs('aprendiz.carnet')) bg-theme-mustard text-black font-semibold border-none @else bg-transparent text-gray-400 text-sm @endif">
            02 &middot; El ficho (ticket)
        </div>
        <div class="px-5 py-2 rounded-full border border-gray-600 @if(request()->routeIs('validacion.*')) bg-theme-mustard text-black font-semibold border-none @else bg-transparent text-gray-400 text-sm @endif">
            03 &middot; Validación en punto
        </div>
    </div>

    <main class="w-full max-w-[340px] z-10 mb-8 relative">
        <!-- Phone Frame Wrapper -->
        <div class="bg-[#121c15] rounded-[40px] p-2 shadow-2xl border-4 border-[#0e1610] relative">
            <!-- Notch -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-[#0e1610] rounded-b-xl z-20"></div>
            <!-- Content -->
            <div class="bg-theme-panel rounded-[32px] overflow-hidden min-h-[600px] relative">
                @yield('content')
            </div>
        </div>
    </main>
    
    <div class="text-xs text-gray-500 mb-8 z-10 font-mono text-center">Boceto de referencia &middot; los datos mostrados son de ejemplo</div>
</body>
</html>
