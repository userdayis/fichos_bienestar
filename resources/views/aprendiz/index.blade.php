@extends('layouts.public')

@section('content')
    <div class="max-w-md w-full mx-4 bg-white rounded-xl shadow-lg p-8 text-center border-t-4 border-sena">
        <h1 class="text-3xl font-extrabold text-sena mb-2 uppercase">El Ficho</h1>
        <p class="text-gray-500 mb-8">Ingresa tu número de documento para consultar el estado de tu carnet y actividades.</p>
        
        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-md mb-6 text-sm border border-red-200 text-left">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('aprendiz.buscar') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div>
                <input type="text" name="documento" placeholder="Ej: 1045234812" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-sena focus:border-sena outline-none transition-colors">
            </div>
            <button type="submit" class="w-full py-3 bg-sena hover:bg-sena-dark text-white font-bold rounded-lg transition-colors shadow-md text-lg">
                Ver mi ficho &rarr;
            </button>
        </form>
        
        <div class="mt-6 text-sm">
            <a href="{{ route('login') }}" class="text-sena hover:underline">Acceso Staff / Admin</a>
        </div>
    </div>
@endsection
