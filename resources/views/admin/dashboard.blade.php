<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex items-center gap-2">
            <svg class="w-5 h-5 text-theme-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Panel de Administrador
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Acciones Rápidas -->
            <div class="mb-8">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Acciones Rápidas</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.importar.show') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-bold rounded-xl transition-colors shadow-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Importar Aprendices
                    </a>
                    @foreach($actividades as $act)
                        <a href="{{ route('admin.fichos.exportar', $act) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/5 border border-white/20 text-gray-300 hover:bg-white/10 font-semibold rounded-xl transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Exportar: {{ $act->nombre }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Tarjetas de Estadísticas -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-theme-panel rounded-2xl p-6 border border-white/10 shadow-lg">
                    <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Aprendices</div>
                    <div class="text-4xl font-extrabold text-white">{{ $totalAprendices }}</div>
                </div>
                <div class="bg-theme-panel rounded-2xl p-6 border border-white/10 shadow-lg">
                    <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Fichos</div>
                    <div class="text-4xl font-extrabold text-white">{{ $totalFichos }}</div>
                </div>
                <div class="bg-theme-panel rounded-2xl p-6 border border-white/10 shadow-lg">
                    <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Entregados</div>
                    <div class="text-4xl font-extrabold text-sena">{{ $totalEntregados }}</div>
                </div>
                <div class="bg-theme-panel rounded-2xl p-6 border border-white/10 shadow-lg">
                    <div class="text-xs text-gray-500 uppercase font-semibold tracking-wider mb-1">Pendientes</div>
                    <div class="text-4xl font-extrabold text-theme-mustard">{{ $totalPendientes }}</div>
                </div>
            </div>

            <!-- Stats por Actividad -->
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
                    <h3 class="text-base font-bold text-white">Progreso por Actividad</h3>
                    <a href="{{ route('admin.fichos.index') }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors">Ver todos los fichos →</a>
                </div>
                <div class="divide-y divide-white/5">
                    @foreach($statsPorActividad as $stat)
                    <div class="px-6 py-5">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <div class="font-semibold text-white text-sm">{{ $stat['nombre'] }}</div>
                                <div class="text-xs text-gray-500">{{ $stat['entregados'] }} de {{ $stat['total'] }} entregados</div>
                            </div>
                            <div class="flex items-center gap-3 text-right">
                                <div class="text-xs">
                                    <span class="text-sena font-bold">{{ $stat['entregados'] }} ✓</span>
                                    <span class="text-gray-500 ml-2">{{ $stat['pendientes'] }} ⏳</span>
                                </div>
                                <div class="text-lg font-extrabold text-white w-12 text-right">{{ $stat['porcentaje'] }}%</div>
                            </div>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-1.5">
                            <div class="bg-sena h-1.5 rounded-full transition-all duration-500" style="width: {{ $stat['porcentaje'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
