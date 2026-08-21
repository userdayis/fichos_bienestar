<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Ficho - Día del Aprendiz SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="border-b border-white/10 bg-theme-panel/60 backdrop-blur-sm sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sena rounded-lg flex items-center justify-center shadow-md">
                    <span class="text-white font-black text-[10px] leading-none text-center">SE<br>NA</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Día del Aprendiz</div>
                </div>
            </div>
            <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-theme-mustard transition-colors flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Nueva búsqueda
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow px-4 py-8">
        <div class="max-w-lg mx-auto">
            
            <!-- Encabezado del Carnet -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-extrabold text-white">{{ $aprendiz->nombre }}</h1>
                <div class="text-gray-400 text-sm font-mono mt-1">
                    Doc. {{ $aprendiz->documento }} &middot; Ficha <span class="text-theme-mustard font-bold">{{ $aprendiz->ficha }}</span>
                </div>
                <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sena/20 border border-sena/30 text-sena text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-sena animate-pulse"></span>
                    <span id="reclamadas-badge">{{ $entregados }} de {{ $totalActividades }} reclamadas</span>
                </div>
            </div>

            <div class="text-[11px] text-gray-400 text-center mb-3">
                🔍 Toca cualquier QR pendiente para verlo en pantalla completa
            </div>

            <!-- Lista de Fichos/Actividades -->
            <div class="space-y-3" id="fichos-container">
                @foreach($fichos as $ficho)
                <div 
                    id="ficho-card-{{ $ficho->id }}" 
                    class="bg-theme-panel rounded-2xl border {{ $ficho->estado === 'entregado' ? 'border-white/5 opacity-60' : 'border-white/20 hover:border-theme-mustard/50 cursor-pointer active:scale-[0.99]' }} transition-all overflow-hidden shadow-lg"
                    @if($ficho->estado !== 'entregado')
                        onclick="abrirModalQR('{{ $ficho->id }}', '{{ $ficho->actividad->nombre }}', '{{ $ficho->codigo_respaldo }}')"
                    @endif
                >
                    <div class="flex items-center gap-4 p-5">

                        <!-- QR o Check -->
                        <div id="qr-box-{{ $ficho->id }}" class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden
                            {{ $ficho->estado === 'entregado' ? 'bg-white/5' : 'bg-white p-1' }} flex items-center justify-center relative group">
                            @if($ficho->estado === 'entregado')
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <div id="qr-svg-raw-{{ $ficho->id }}" class="w-full h-full flex items-center justify-center">
                                    {!! QrCode::size(72)->margin(0)->generate($ficho->codigo_qr) !!}
                                </div>
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-xl">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                </div>
                            @endif
                        </div>

                        <!-- Información -->
                        <div class="flex-grow min-w-0">
                            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                {{ $ficho->actividad->nombre }}
                                @if($ficho->estado !== 'entregado')
                                    <span class="text-[10px] text-theme-mustard font-normal">🔍 Ampliar</span>
                                @endif
                            </div>
                            <div id="codigo-label-{{ $ficho->id }}" class="font-mono text-xl font-extrabold {{ $ficho->estado === 'entregado' ? 'text-gray-600 line-through' : 'text-white' }} tracking-widest">
                                {{ $ficho->codigo_respaldo }}
                            </div>
                            <div id="estado-label-{{ $ficho->id }}">
                                @if($ficho->estado === 'entregado')
                                    <div class="mt-1 text-[10px] text-gray-500">
                                        Entregado {{ $ficho->entregado_en?->format('h:i a') }}
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-sena/20 border border-sena/30 text-sena text-[10px] font-bold rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sena"></span>
                                            PENDIENTE
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Estado Badge Icon -->
                        <div id="check-icon-{{ $ficho->id }}" class="flex-shrink-0 {{ $ficho->estado === 'entregado' ? '' : 'hidden' }}">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-sena" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <p class="text-center text-xs text-gray-600 mt-8 leading-relaxed px-4">
                Muestra el código QR ampliado o el código alfanumérico al operador en cada punto.
                Cada código es válido <strong class="text-gray-400">una sola vez</strong>.
            </p>
        </div>
    </main>

    <!-- Modal / Visor de QR en Pantalla Completa -->
    <div id="qr-modal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden flex items-center justify-center p-4 transition-all duration-300" onclick="cerrarModalQR(event)">
        <div class="bg-theme-panel border border-white/20 rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl relative text-center flex flex-col items-center animate-in fade-in zoom-in duration-200" onclick="event.stopPropagation()">
            
            <!-- Botón Cerrar (X) -->
            <button onclick="cerrarModalQR()" class="absolute top-4 right-4 text-gray-400 hover:text-white p-2 rounded-full hover:bg-white/10 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Encabezado Actividad -->
            <div class="text-[11px] text-theme-mustard font-extrabold uppercase tracking-widest mb-1" id="modal-actividad-nombre">Actividad</div>
            <div class="text-xs text-gray-400 font-mono mb-4">{{ $aprendiz->nombre }} &middot; Ficha {{ $aprendiz->ficha }}</div>

            <!-- Contenedor QR Gigante -->
            <div class="w-64 h-64 bg-white p-3.5 rounded-2xl shadow-[0_0_30px_rgba(255,255,255,0.15)] flex items-center justify-center mb-5 relative overflow-hidden" id="modal-qr-container">
                <!-- Se inyecta el SVG del QR agrandado -->
            </div>

            <!-- Código Alfanumérico Gigante -->
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-1">Código de respaldo</div>
            <div class="font-mono text-3xl font-black text-theme-mustard tracking-widest mb-6" id="modal-codigo-respaldo">
                ABC-1234
            </div>

            <button onclick="cerrarModalQR()" class="w-full py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-colors text-sm">
                Cerrar
            </button>
        </div>
    </div>

    <!-- Polling Silencioso en Tiempo Real -->
    <script>
    const documento = "{{ $aprendiz->documento }}";
    let pollInterval = null;
    let currentModalFichoId = null;

    // Abrir Modal de QR Ampliado
    function abrirModalQR(fichoId, actividadNombre, codigoRespaldo) {
        currentModalFichoId = fichoId;
        const rawSvgContainer = document.getElementById(`qr-svg-raw-${fichoId}`);
        if (!rawSvgContainer) return;

        document.getElementById('modal-actividad-nombre').textContent = actividadNombre;
        document.getElementById('modal-codigo-respaldo').textContent = codigoRespaldo;

        // Clonar el SVG y ajustarlo al tamaño gigante
        const modalContainer = document.getElementById('modal-qr-container');
        modalContainer.innerHTML = rawSvgContainer.innerHTML;
        const svg = modalContainer.querySelector('svg');
        if (svg) {
            svg.setAttribute('width', '100%');
            svg.setAttribute('height', '100%');
            svg.style.width = '100%';
            svg.style.height = '100%';
        }

        const modal = document.getElementById('qr-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Cerrar Modal
    function cerrarModalQR() {
        const modal = document.getElementById('qr-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        currentModalFichoId = null;
    }

    // Cerrar con Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') cerrarModalQR();
    });

    // Polling en Vivo
    async function actualizarEstadoCarnet() {
        try {
            const res = await fetch(`/carnet/${documento}/estado`);
            if (!res.ok) return;
            const data = await res.json();

            // Actualizar contador superior
            const badge = document.getElementById('reclamadas-badge');
            if (badge) {
                badge.textContent = `${data.entregados} de ${data.total} reclamadas`;
            }

            // Actualizar cada ficho si cambió su estado
            data.fichos.forEach(f => {
                const card = document.getElementById(`ficho-card-${f.id}`);
                const qrBox = document.getElementById(`qr-box-${f.id}`);
                const codigoLabel = document.getElementById(`codigo-label-${f.id}`);
                const estadoLabel = document.getElementById(`estado-label-${f.id}`);
                const checkIcon = document.getElementById(`check-icon-${f.id}`);

                if (f.estado === 'entregado') {
                    // Si el modal de este ficho estaba abierto, cerrarlo automáticamente
                    if (currentModalFichoId === String(f.id)) {
                        cerrarModalQR();
                    }

                    if (card && !card.classList.contains('opacity-60')) {
                        card.classList.add('opacity-60');
                        card.classList.remove('border-white/20', 'cursor-pointer', 'active:scale-[0.99]');
                        card.classList.add('border-white/5');
                        card.removeAttribute('onclick');
                    }
                    if (qrBox && !qrBox.classList.contains('bg-white/5')) {
                        qrBox.className = 'flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-white/5 flex items-center justify-center';
                        qrBox.innerHTML = `<svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                    }
                    if (codigoLabel && !codigoLabel.classList.contains('line-through')) {
                        codigoLabel.className = 'font-mono text-xl font-extrabold text-gray-600 line-through tracking-widest';
                    }
                    if (estadoLabel && !estadoLabel.innerHTML.includes('Entregado')) {
                        estadoLabel.innerHTML = `<div class="mt-1 text-[10px] text-gray-500">Entregado ${f.entregado_en || ''}</div>`;
                    }
                    if (checkIcon) {
                        checkIcon.classList.remove('hidden');
                    }
                }
            });
        } catch (e) {
            // Silencioso
        }
    }

    // Polling cada 3.5 segundos
    pollInterval = setInterval(actualizarEstadoCarnet, 3500);

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(pollInterval);
        } else {
            actualizarEstadoCarnet();
            pollInterval = setInterval(actualizarEstadoCarnet, 3500);
        }
    });
    </script>

</body>
</html>
