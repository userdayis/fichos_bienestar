<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Importar Aprendices
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-theme-panel text-theme-cream overflow-hidden shadow-xl rounded-2xl border border-white/10">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-theme-mustard/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-theme-mustard" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-extrabold text-white">Cargar Archivo CSV</h3>
                            <p class="text-gray-400 text-sm">El archivo debe tener columnas: <span class="font-bold text-theme-mustard font-mono">documento, nombre, correo, ficha</span></p>
                        </div>
                    </div>

                    @if(session('resultado'))
                        @php $res = session('resultado'); @endphp
                        <div class="bg-sena/20 text-green-300 p-4 rounded-xl mb-6 border border-sena/30">
                            <div class="font-bold mb-1 text-green-200">✅ Importación completada</div>
                            <ul class="text-sm space-y-1">
                                <li>Aprendices nuevos: <strong>{{ $res['creados'] }}</strong></li>
                                <li>Actualizados: <strong>{{ $res['actualizados'] }}</strong></li>
                                <li>Fichos generados: <strong>{{ $res['fichos_generados'] }}</strong></li>
                                @if(!empty($res['errores']))
                                    <li class="text-yellow-300 mt-2">⚠ Errores: {{ count($res['errores']) }}</li>
                                    @foreach($res['errores'] as $e)
                                        <li class="text-xs ml-2 text-yellow-400">- {{ $e }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif

                    @if(session('errores_validacion'))
                        <div class="bg-red-900/40 text-red-300 p-4 rounded-xl mb-6 border border-red-800/40">
                            <div class="font-bold mb-2">Errores de validación:</div>
                            <ul class="list-disc ml-4 space-y-1 text-xs">
                                @foreach(session('errores_validacion') as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-900/40 text-red-300 p-4 rounded-xl mb-6 border border-red-800/40 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.importar.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center hover:border-theme-mustard/50 transition-colors cursor-pointer" onclick="document.getElementById('archivo').click()">
                            <svg class="w-12 h-12 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <div id="file-label" class="text-gray-400 text-sm">
                                <span class="text-theme-mustard font-semibold">Haz clic para seleccionar</span> o arrastra tu archivo aquí
                            </div>
                            <div class="text-gray-600 text-xs mt-1">CSV, XLS o XLSX &mdash; máx. 10MB</div>
                            <input type="file" id="archivo" name="archivo" accept=".csv,.xlsx,.xls" required class="hidden"
                                onchange="document.getElementById('file-label').innerHTML = this.files[0].name">
                        </div>
                        
                        <div class="flex justify-between mt-8 gap-4">
                            <a href="{{ route('admin.dashboard') }}" class="flex-1 py-3 bg-white/5 border border-white/10 text-gray-400 hover:bg-white/10 font-semibold rounded-xl transition-colors text-center text-sm">
                                ← Volver
                            </a>
                            <button type="submit" class="flex-1 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-sm">
                                Subir e Importar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
