<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Editar Actividad: {{ $actividad->nombre }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl p-8">
                @if($errors->any())
                    <div class="bg-red-900/40 text-red-300 p-4 rounded-xl mb-6 border border-red-800/40 text-sm">
                        <ul class="list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.actividades.update', $actividad) }}">
                    @csrf @method('PUT')
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $actividad->nombre) }}" required
                            class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard">
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Descripción</label>
                        <textarea name="descripcion" rows="2" class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard">{{ old('descripcion', $actividad->descripcion) }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Ícono</label>
                            <input type="text" name="icono" value="{{ old('icono', $actividad->icono) }}" class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Orden</label>
                            <input type="number" name="orden" value="{{ old('orden', $actividad->orden) }}" min="0" class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="activa" value="0">
                            <input type="checkbox" name="activa" value="1" {{ $actividad->activa ? 'checked' : '' }}
                                class="rounded border-white/20 bg-theme-bg text-theme-mustard focus:ring-theme-mustard">
                            <span class="text-sm text-gray-300">Actividad activa</span>
                        </label>
                    </div>
                    <div class="flex justify-between mt-8">
                        <a href="{{ route('admin.actividades.index') }}" class="px-5 py-3 bg-white/5 border border-white/10 text-gray-400 hover:bg-white/10 font-semibold rounded-xl transition-colors text-sm">← Volver</a>
                        <button type="submit" class="px-6 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-sm">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
