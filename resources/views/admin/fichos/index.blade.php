<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-theme-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                Gestión de Fichos
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-sena/20 border border-sena/30 text-green-300 rounded-xl p-4 mb-6 text-sm">{{ session('success') }}</div>
            @endif

            <!-- Búsqueda -->
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl p-6 mb-6">
                <form method="GET" action="{{ route('admin.fichos.index') }}" class="flex gap-3">
                    <input type="text" name="documento" value="{{ $documento }}" placeholder="Buscar por documento del aprendiz..."
                        class="flex-grow bg-theme-bg border border-white/20 text-white font-mono px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard placeholder-gray-600">
                    <button type="submit" class="px-6 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-bold rounded-xl transition-colors text-sm">
                        Buscar
                    </button>
                </form>
            </div>

            @if($aprendiz)
                <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/10">
                        <h3 class="text-white font-bold text-lg">{{ $aprendiz->nombre }}</h3>
                        <p class="text-gray-400 text-sm font-mono">Doc. {{ $aprendiz->documento }} · Ficha {{ $aprendiz->ficha }}</p>
                    </div>
                    <div class="divide-y divide-white/5">
                        @foreach($fichos as $ficho)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-white font-semibold text-sm">{{ $ficho->actividad->nombre }}</div>
                                <div class="text-gray-500 text-xs font-mono">{{ $ficho->codigo_respaldo }}</div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($ficho->estado === 'entregado')
                                    <span class="text-xs text-gray-500">{{ $ficho->entregado_en?->format('h:i a') }}</span>
                                    <span class="px-2 py-1 bg-white/10 text-gray-400 text-[10px] font-bold rounded-full">ENTREGADO</span>
                                    <form method="POST" action="{{ route('admin.fichos.resetear', $ficho) }}" onsubmit="return confirm('¿Resetear este ficho?')">
                                        @csrf
                                        <button class="text-xs text-red-400 hover:text-red-300 transition-colors">Resetear</button>
                                    </form>
                                @else
                                    <span class="px-2 py-1 bg-sena/20 text-sena text-[10px] font-bold rounded-full">PENDIENTE</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @elseif($documento)
                <div class="bg-theme-panel rounded-2xl border border-white/10 p-8 text-center">
                    <p class="text-gray-400">No se encontró ningún aprendiz con el documento <strong class="text-white font-mono">{{ $documento }}</strong></p>
                </div>
            @else
                <div class="bg-theme-panel rounded-2xl border border-white/10 p-8 text-center">
                    <p class="text-gray-500">Ingresa un número de documento para buscar los fichos de un aprendiz.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
