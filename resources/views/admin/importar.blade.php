<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Importar Aprendices
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-sena">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-sena mb-4">Cargar Archivo CSV</h3>
                    <p class="text-gray-600 mb-6">
                        Sube un archivo CSV con la lista de aprendices. El archivo debe tener las siguientes columnas: 
                        <span class="font-bold">documento, nombre, correo, ficha</span>.
                    </p>

                    @if(session('success'))
                        <div class="bg-green-50 text-green-700 p-4 rounded-md mb-6 border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-md mb-6 border border-red-200">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.importar.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Archivo CSV</label>
                            <input type="file" name="archivo" accept=".csv" required class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-green-50 file:text-sena
                              hover:file:bg-green-100
                            "/>
                        </div>
                        
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="bg-sena hover:bg-sena-dark text-white font-bold py-2 px-6 rounded shadow">
                                Subir e Importar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
