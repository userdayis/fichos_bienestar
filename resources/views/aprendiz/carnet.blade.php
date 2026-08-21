<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Ficho - Día del Aprendiz SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
                    <div class="text-white font-bold text-sm">Día del Aprendiz</div>
                </div>
            </div>
            <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors">
                ← Nueva búsqueda
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow px-4 py-10">
        <div class="max-w-lg mx-auto">
            
            <!-- Encabezado del Carnet -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-extrabold text-white">{{ $aprendiz->nombre }}</h1>
                <div class="text-gray-400 text-sm font-mono mt-1">
                    Doc. {{ $aprendiz->documento }} &middot; Ficha <span class="text-theme-mustard font-bold">{{ $aprendiz->ficha }}</span>
                </div>
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sena/20 border border-sena/30 text-sena text-xs font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $entregados }} de {{ $totalActividades }} reclamadas
                </div>
            </div>

            <!-- Lista de Fichos/Actividades -->
            <div class="space-y-3">
                @foreach($fichos as $ficho)
                <div class="bg-theme-panel rounded-2xl border {{ $ficho->estado === 'entregado' ? 'border-white/5 opacity-60' : 'border-white/20 hover:border-theme-mustard/40' }} transition-all overflow-hidden">
                    <div class="flex items-center gap-4 p-5">

                        <!-- QR o Check -->
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden
                            {{ $ficho->estado === 'entregado' ? 'bg-white/5' : 'bg-white p-1' }} flex items-center justify-center">
                            @if($ficho->estado === 'entregado')
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    {!! QrCode::size(72)->margin(0)->generate($ficho->codigo_qr) !!}
                                </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-grow min-w-0">
                            <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">{{ $ficho->actividad->nombre }}</div>
                            <div class="font-mono text-xl font-extrabold {{ $ficho->estado === 'entregado' ? 'text-gray-600 line-through' : 'text-white' }} tracking-widest">
                                {{ $ficho->codigo_respaldo }}
                            </div>
                            @if($ficho->estado === 'entregado')
                                <div class="mt-1 text-[10px] text-gray-500">
                                    Entregado {{ $ficho->entregado_en?->format('h:i a') }}
                                </div>
                            @else
                                <div class="mt-2">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-sena/20 border border-sena/30 text-sena text-[10px] font-bold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sena"></span>
                                        PENDIENTE
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Estado Badge -->
                        @if($ficho->estado === 'entregado')
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <p class="text-center text-xs text-gray-600 mt-8 leading-relaxed px-4">
                Muestra el código QR o el código alfanumérico al operador en cada punto de entrega.
                Cada código es válido <strong class="text-gray-400">una sola vez</strong>.
            </p>
        </div>
    </main>

</body>
</html>
