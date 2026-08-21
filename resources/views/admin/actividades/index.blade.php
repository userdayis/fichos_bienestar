<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-theme-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Actividades
            </h2>
            <a href="{{ route('admin.actividades.create') }}" class="px-4 py-2 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-bold rounded-xl transition-colors text-sm">
                + Nueva Actividad
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-sena/20 border border-sena/30 text-green-300 rounded-xl p-4 mb-6 text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-900/40 border border-red-800/40 text-red-300 rounded-xl p-4 mb-6 text-sm">{{ session('error') }}</div>
            @endif

            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl overflow-hidden">
                <div class="divide-y divide-white/5">
                    @forelse($actividades as $actividad)
                    <div class="px-6 py-5 flex items-center justify-between">
                        <div>
                            <div class="text-white font-bold">{{ $actividad->nombre }}</div>
                            <div class="text-gray-500 text-xs mt-0.5">{{ $actividad->descripcion ?? 'Sin descripción' }} · Orden: {{ $actividad->orden }}</div>
                            <div class="flex gap-3 mt-2 text-xs">
                                <span class="text-sena font-semibold">{{ $actividad->fichos()->entregado()->count() }} entregados</span>
                                <span class="text-gray-500">{{ $actividad->fichos()->pendiente()->count() }} pendientes</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $actividad->activa ? 'bg-sena/20 text-sena' : 'bg-red-900/30 text-red-400' }}">
                                {{ $actividad->activa ? 'ACTIVA' : 'INACTIVA' }}
                            </span>
                            <a href="{{ route('admin.actividades.edit', $actividad) }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors">Editar</a>
                            <form method="POST" action="{{ route('admin.actividades.destroy', $actividad) }}" onsubmit="return confirm('¿Eliminar esta actividad?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:text-red-400 transition-colors">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">No hay actividades creadas aún.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
