@extends('layouts.public')

@section('content')
<div class="p-8 pt-12 flex flex-col h-full">
    <!-- Header Indicator -->
    <div class="flex items-center gap-2 mb-8">
        <div class="w-2 h-2 rounded-full bg-theme-mustard"></div>
        <span class="text-[10px] tracking-widest text-gray-300 font-medium">ALIMENTACIÓN &middot; SENA</span>
    </div>

    <div class="text-xs text-theme-mustard font-semibold tracking-wider mb-2">PASO 1 DE 2</div>
    <h2 class="text-3xl font-extrabold text-white leading-tight mb-4">Ingresa tu número de documento</h2>
    
    <p class="text-gray-300 text-sm mb-10 leading-relaxed font-light">
        Lo usamos para ubicar tu registro y generar tu ficho. No necesitas contraseña.
    </p>

    @if($errors->any())
        <div class="bg-red-900/50 text-red-200 p-3 rounded-md mb-6 text-sm border border-red-800 text-left">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('aprendiz.buscar') }}" method="POST" class="mt-auto flex flex-col h-full">
        @csrf
        <div class="mb-4">
            <label class="block text-xs font-mono text-gray-400 mb-2 uppercase tracking-wide">Documento de identidad</label>
            <input type="text" name="documento" placeholder="10 45x xx8 12" required 
                class="w-full bg-theme-panel text-white font-mono text-lg px-4 py-3 rounded-xl border border-theme-mustard focus:outline-none focus:ring-1 focus:ring-theme-mustard transition-colors">
        </div>
        
        <div class="mt-8 flex-grow flex flex-col justify-end pb-4">
            <button type="submit" class="w-full py-4 bg-theme-mustard text-[#593d05] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-lg flex items-center justify-center gap-2">
                Ver mi ficho &rarr;
            </button>
            <p class="text-xs text-gray-400 text-center mt-6 px-2 font-light leading-relaxed">
                ¿Tu documento no aparece? Acércate al stand de soporte cerca a la entrada principal.
            </p>
        </div>
    </form>
</div>
@endsection
