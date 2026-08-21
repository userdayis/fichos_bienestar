<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-theme-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 5.197h-6m2-10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Usuarios / Operadores
            </h2>
            <a href="{{ route('admin.usuarios.create') }}" class="px-4 py-2 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-bold rounded-xl transition-colors text-sm">
                + Nuevo Usuario
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
                    @forelse($usuarios as $usuario)
                    <div class="px-6 py-5 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ $usuario->role === 'admin' ? 'bg-theme-mustard' : 'bg-sena' }} flex items-center justify-center text-white font-bold text-sm">
                                {{ substr($usuario->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-white font-semibold">{{ $usuario->name }}</div>
                                <div class="text-gray-500 text-xs">{{ $usuario->email }}</div>
                                @if($usuario->actividad)
                                    <div class="text-theme-mustard text-xs mt-0.5">Punto: {{ $usuario->actividad->nombre }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $usuario->role === 'admin' ? 'bg-theme-mustard/20 text-theme-mustard' : 'bg-sena/20 text-sena' }}">
                                {{ $usuario->role }}
                            </span>
                            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors">Editar</a>
                            @if($usuario->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:text-red-400 transition-colors">Eliminar</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">No hay usuarios registrados.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
