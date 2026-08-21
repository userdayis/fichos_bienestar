<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Nuevo Usuario</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-xl p-8">
                @if($errors->any())
                    <div class="bg-red-900/40 text-red-300 p-4 rounded-xl mb-6 border border-red-800/40 text-sm">
                        <ul class="list-disc ml-4">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard placeholder-gray-600"
                            placeholder="Ej: María Gómez">
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard placeholder-gray-600"
                            placeholder="usuario@sena.edu.co">
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Contraseña</label>
                        <input type="password" name="password" required minlength="6"
                            class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard placeholder-gray-600"
                            placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Rol</label>
                            <select name="role" required class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard">
                                <option value="operador" {{ old('role') === 'operador' ? 'selected' : '' }}>Operador</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Actividad asignada</label>
                            <select name="actividad_id" class="w-full bg-theme-bg border border-white/20 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard">
                                <option value="">— Ninguna —</option>
                                @foreach($actividades as $act)
                                    <option value="{{ $act->id }}" {{ old('actividad_id') == $act->id ? 'selected' : '' }}>{{ $act->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between mt-8">
                        <a href="{{ route('admin.usuarios.index') }}" class="px-5 py-3 bg-white/5 border border-white/10 text-gray-400 hover:bg-white/10 font-semibold rounded-xl transition-colors text-sm">← Volver</a>
                        <button type="submit" class="px-6 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-sm">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
