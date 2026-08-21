@extends('layouts.public')

@section('content')
<div class="p-4 pt-12 flex flex-col h-full items-center">
    <!-- Header Indicator -->
    <div class="flex items-center gap-2 mb-6 self-start px-4">
        <div class="w-2 h-2 rounded-full bg-theme-mustard"></div>
        <span class="text-[10px] tracking-widest text-gray-300 font-medium">ALIMENTACIÓN &middot; SENA</span>
    </div>

    <!-- Ticket -->
    <div class="w-full bg-theme-ticket-bg rounded-2xl relative shadow-lg text-black overflow-hidden flex flex-col mt-2">
        <!-- Ticket Header (Top part) -->
        <div class="p-6 pb-8 border-b-2 border-dashed border-gray-300 relative">
            <!-- Cutouts for ticket effect -->
            <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-theme-panel rounded-full"></div>
            <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-theme-panel rounded-full"></div>

            <div class="text-[10px] text-gray-500 font-bold tracking-widest mb-2">CARNET DE ACTIVIDADES</div>
            <h2 class="text-2xl font-extrabold text-[#2d2a26] leading-tight mb-2">{{ $aprendiz->nombre }}</h2>
            <div class="text-xs text-gray-600 font-mono mb-4">
                Doc. {{ substr($aprendiz->documento, 0, -3) . 'XXX' }} &middot; Ficha {{ $aprendiz->ficha }}
            </div>
            
            <div class="inline-block px-3 py-1 bg-[#d5f0e1] text-[#1c603e] text-xs font-bold rounded-full">
                {{ $entregados }} de {{ $totalActividades }} reclamadas
            </div>
        </div>

        <!-- Ticket Body (Activities List) -->
        <div class="p-6 flex flex-col gap-5 relative bg-[#fdfbf6]">
            @foreach($fichos as $ficho)
                <div class="flex items-center gap-4 relative">
                    <!-- QR Placeholder or Activity Icon -->
                    <div class="w-12 h-12 rounded-lg flex-shrink-0 flex items-center justify-center 
                        @if($ficho->estado === 'entregado') bg-gray-200 opacity-50 @else bg-[#2d2a26] @endif">
                        <!-- Simulated QR blocks -->
                        @if($ficho->estado !== 'entregado')
                            <div class="grid grid-cols-2 gap-1 p-2 w-full h-full opacity-60">
                                <div class="bg-white rounded-[2px]"></div><div class="bg-white rounded-[2px]"></div>
                                <div class="bg-white rounded-[2px]"></div><div class="bg-white rounded-[2px] opacity-20"></div>
                            </div>
                        @else
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @endif
                    </div>
                    
                    <div class="flex-grow">
                        <h4 class="font-extrabold text-[#2d2a26] leading-tight @if($ficho->estado === 'entregado') text-gray-400 line-through @endif">{{ $ficho->actividad->nombre }}</h4>
                        <div class="text-[10px] text-gray-500 font-mono">{{ $ficho->codigo_qr }}</div>
                    </div>

                    <div>
                        @if($ficho->estado === 'entregado')
                            <span class="px-2 py-1 bg-gray-200 text-gray-500 text-[10px] font-bold rounded-full border border-gray-300 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                ENTREGADO
                            </span>
                        @else
                            <span class="px-2 py-1 bg-[#d5f0e1] text-[#1c603e] text-[10px] font-bold rounded-full">
                                PENDIENTE
                            </span>
                        @endif
                    </div>
                </div>
                
                @if(!$loop->last)
                    <div class="border-b border-dashed border-gray-200 w-full"></div>
                @endif
            @endforeach
        </div>
        
        <div class="bg-[#f5f1e8] p-4 text-center text-[10px] text-gray-500 border-t border-gray-200">
            Cada QR es válido una sola vez &middot; Presenta este ticket al operador
        </div>
    </div>
</div>
@endsection
