@extends('layouts.public')

@section('content')
    <div class="card">
        <h1>El Ficho</h1>
        <p>Ingresa tu número de documento para ver tu carnet de actividades.</p>
        
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('aprendiz.buscar') }}" method="POST">
            @csrf
            <input type="text" name="documento" placeholder="Ej: 1045234812" required>
            <br>
            <button type="submit">Ver mi ficho &rarr;</button>
        </form>
    </div>
@endsection
