@extends('layouts.public')

@section('content')
<div class="p-4 pt-12 flex flex-col h-full items-center">
    <!-- Header Indicator -->
    <div class="flex items-center gap-2 mb-6 self-start px-4">
        <div class="w-2 h-2 rounded-full bg-theme-mustard"></div>
        <span class="text-[10px] tracking-widest text-gray-300 font-medium">PANEL DE VALIDACIÓN</span>
    </div>

    <div class="w-full px-4 mb-4 text-left">
        <div class="text-[10px] text-theme-mustard font-semibold tracking-wider mb-1">PUNTO ASIGNADO</div>
        <h2 class="text-2xl font-extrabold text-white leading-tight">{{ $actividad->nombre ?? 'Actividad 2' }}</h2>
    </div>

    <!-- Scanner Window Overlay (simulated UI) -->
    <div class="w-full px-4 mb-4 relative flex justify-center">
        <!-- Frame corners -->
        <div class="w-full h-12 border-l-2 border-r-2 border-white relative">
            <div class="absolute top-1/2 left-0 w-full h-[2px] bg-theme-mustard shadow-[0_0_8px_#e6ad43]"></div>
        </div>
    </div>

    <!-- Status Card -->
    <div class="w-full bg-theme-ticket-bg rounded-2xl relative shadow-lg text-black p-6 mb-8 mt-2">
        <div class="inline-block px-3 py-1 bg-[#478f65] text-white text-[10px] font-bold rounded-md mb-4 flex items-center gap-1 w-max">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            ENTREGADO AHORA
        </div>
        
        <h3 class="text-xl font-extrabold text-[#2d2a26] leading-tight mb-2">Dayam Ospina B.</h3>
        <div class="text-[11px] text-gray-600 font-mono">
            Doc. 10.45X.XX8 &middot; Ficha 3147211<br>
            &middot; 12:04 p.m.
        </div>
    </div>

    <!-- Actions -->
    <div class="w-full flex gap-3 px-4 mt-auto pb-6">
        <button class="flex-1 py-3 bg-theme-mustard text-[#593d05] hover:bg-yellow-500 font-extrabold rounded-xl transition-colors shadow-lg text-xs">
            Simular válido
        </button>
        <button class="flex-1 py-3 bg-transparent border border-gray-600 text-gray-400 font-bold rounded-xl hover:bg-[#1a2c20] transition-colors text-xs">
            Simular ya<br>usado
        </button>
    </div>
</div>
@endsection
