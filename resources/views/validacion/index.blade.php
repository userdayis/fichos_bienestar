<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Validación - SENA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        #reader {
            border: none !important;
        }
        #reader video {
            border-radius: 1rem;
            object-fit: cover;
            width: 100% !important;
        }
        #reader__scan_region {
            background: transparent !important;
        }
        #reader__dashboard {
            display: none !important;
        }
    </style>
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="border-b border-white/10 bg-theme-panel/80 sticky top-0 z-50 backdrop-blur-sm">
        <div class="max-w-3xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sena rounded-lg flex items-center justify-center shadow-md">
                    <span class="text-white font-black text-[10px] leading-none text-center">SE<br>NA</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Panel de Validación</div>
                    <div class="text-theme-mustard text-[10px] font-bold tracking-wider uppercase">{{ $actividad->nombre ?? 'Sin actividad asignada' }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400 hidden sm:inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition-colors font-medium">Salir</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-sm">

            <!-- Status Feedback Area -->
            <div id="status-area" class="mb-6 hidden transition-all duration-300">
                <!-- Se llena dinámicamente con JS -->
            </div>

            <!-- Scanner Camera Box -->
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-2xl p-5 mb-4">
                
                <!-- Botón de Activar/Desactivar Cámara -->
                <div class="mb-4">
                    <button 
                        id="toggle-camera-btn"
                        onclick="toggleCamera()"
                        class="w-full py-3.5 bg-sena hover:bg-sena-dark active:scale-[0.98] text-white font-bold rounded-xl transition-all shadow-lg text-sm flex items-center justify-center gap-2">
                        <svg id="camera-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span id="camera-btn-text">Abrir Cámara para Escanear</span>
                    </button>
                </div>

                <!-- Contenedor del video de la cámara -->
                <div id="camera-container" class="hidden mb-4">
                    <div class="relative rounded-xl overflow-hidden bg-black border border-white/20">
                        <div id="reader" class="w-full"></div>
                        <!-- Guía visual de escaneo -->
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="w-48 h-48 border-2 border-theme-mustard/80 rounded-2xl relative shadow-[0_0_15px_rgba(230,173,67,0.3)] animate-pulse">
                                <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-theme-mustard -mt-1 -ml-1"></div>
                                <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-theme-mustard -mt-1 -mr-1"></div>
                                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-theme-mustard -mb-1 -ml-1"></div>
                                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-theme-mustard -mb-1 -mr-1"></div>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-400 text-center mt-2">Apunta la cámara al código QR del carnet del aprendiz.</p>
                </div>

                <!-- Divisor O manual -->
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-white/10"></div>
                    <span class="flex-shrink mx-3 text-gray-500 text-[10px] uppercase font-bold tracking-widest">o código manual</span>
                    <div class="flex-grow border-t border-white/10"></div>
                </div>

                <!-- Input Manual -->
                <div class="mt-2">
                    <div class="flex gap-2">
                        <input 
                            id="codigo-input"
                            type="text" 
                            placeholder="Ej: ABC-1234"
                            maxlength="50"
                            class="flex-grow bg-theme-bg border border-white/20 text-white font-mono text-base px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard transition-colors placeholder-gray-600 uppercase tracking-widest"
                        >
                        <button 
                            id="validar-btn"
                            onclick="validarManual()"
                            class="px-5 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 active:scale-95 font-extrabold rounded-xl transition-all shadow-lg text-sm flex items-center justify-center">
                            ✓
                        </button>
                    </div>
                </div>
            </div>

            <!-- Información del Punto Asignado -->
            @if($actividad)
            <div class="bg-theme-panel/50 rounded-xl border border-white/5 px-5 py-3.5 text-center">
                <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-0.5">Punto asignado</div>
                <div class="font-extrabold text-white text-base">{{ $actividad->nombre }}</div>
                <input type="hidden" id="actividad-id" value="{{ $actividad->id }}">
            </div>
            @endif

        </div>
    </main>

    <script>
    let html5QrCode = null;
    let cameraActive = false;
    let scanningLocked = false;

    // Audio de confirmación usando Web Audio API
    function playBeep(type = 'success') {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.connect(gain);
            gain.connect(audioCtx.destination);

            if (type === 'success') {
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(1200, audioCtx.currentTime + 0.15);
                gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.2);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.2);
            } else {
                osc.frequency.setValueAtTime(300, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(200, audioCtx.currentTime + 0.25);
                gain.gain.setValueAtTime(0.4, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.3);
            }
        } catch (e) {
            console.log('Audio error:', e);
        }
    }

    // Toggle Cámara
    async function toggleCamera() {
        const container = document.getElementById('camera-container');
        const btnText = document.getElementById('camera-btn-text');
        const toggleBtn = document.getElementById('toggle-camera-btn');

        if (cameraActive) {
            await stopCamera();
        } else {
            container.classList.remove('hidden');
            btnText.textContent = 'Apagar Cámara';
            toggleBtn.classList.remove('bg-sena', 'hover:bg-sena-dark');
            toggleBtn.classList.add('bg-red-700', 'hover:bg-red-800');
            startCamera();
        }
    }

    async function startCamera() {
        try {
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0
            };

            await html5QrCode.start(
                { facingMode: "environment" }, // Preferir cámara trasera
                config,
                onScanSuccess,
                (errorMessage) => {
                    // Ignorar errores continuos de búsqueda de frames
                }
            );
            cameraActive = true;
        } catch (err) {
            console.error("Error al iniciar cámara:", err);
            alert("No se pudo acceder a la cámara. Asegúrate de dar los permisos correspondientes o usa el código manual.");
            stopCamera();
        }
    }

    async function stopCamera() {
        const container = document.getElementById('camera-container');
        const btnText = document.getElementById('camera-btn-text');
        const toggleBtn = document.getElementById('toggle-camera-btn');

        if (html5QrCode && cameraActive) {
            try {
                await html5QrCode.stop();
                html5QrCode.clear();
            } catch (e) {
                console.error(e);
            }
        }
        cameraActive = false;
        container.classList.add('hidden');
        btnText.textContent = 'Abrir Cámara para Escanear';
        toggleBtn.classList.remove('bg-red-700', 'hover:bg-red-800');
        toggleBtn.classList.add('bg-sena', 'hover:bg-sena-dark');
    }

    // Callback de éxito del escáner
    function onScanSuccess(decodedText, decodedResult) {
        if (scanningLocked) return;

        scanningLocked = true;
        validarCodigo(decodedText);

        // Desbloquear para siguiente escaneo después de 2.5 segundos
        setTimeout(() => {
            scanningLocked = false;
        }, 2500);
    }

    // Validación manual
    function validarManual() {
        const input = document.getElementById('codigo-input');
        const codigo = input.value.trim();
        if (!codigo) return;
        validarCodigo(codigo);
        input.value = '';
        input.focus();
    }

    document.getElementById('codigo-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') validarManual();
    });

    // Petición AJAX al backend
    async function validarCodigo(codigoRaw) {
        const codigo = codigoRaw.trim().toUpperCase();
        const actividadId = document.getElementById('actividad-id')?.value;
        const statusArea = document.getElementById('status-area');
        const btn = document.getElementById('validar-btn');

        if (!codigo || !actividadId) return;

        btn.disabled = true;
        btn.textContent = '...';

        try {
            const res = await fetch('{{ route("validacion.validar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ codigo, actividad_id: actividadId })
            });

            const data = await res.json();
            mostrarResultado(data);
        } catch (err) {
            mostrarResultado({ status: 'error', message: 'Error de red o conexión.' });
        }

        btn.disabled = false;
        btn.textContent = '✓';
    }

    function mostrarResultado(data) {
        const statusArea = document.getElementById('status-area');
        let html = '';
        let clases = '';

        if (data.status === 'entregado') {
            playBeep('success');
            clases = 'bg-sena/25 border-2 border-sena';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sena flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex-grow">
                        <div class="text-sena font-black text-xs uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-sena animate-ping"></span>
                            ¡Entregado exitosamente!
                        </div>
                        <div class="text-white font-extrabold text-xl mt-0.5 leading-tight">${data.aprendiz_nombre}</div>
                        <div class="text-gray-300 text-xs font-mono mt-1">Doc. ${data.aprendiz_documento} · Ficha ${data.aprendiz_ficha}</div>
                        <div class="text-gray-400 text-[11px] mt-1">Hora: ${data.entregado_en}</div>
                    </div>
                </div>`;
        } else if (data.status === 'ya_entregado') {
            playBeep('error');
            clases = 'bg-yellow-900/40 border-2 border-yellow-600';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-yellow-600 flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex-grow">
                        <div class="text-yellow-400 font-black text-xs uppercase tracking-wider">Ya fue reclamado</div>
                        <div class="text-white font-bold text-lg mt-0.5">${data.aprendiz_nombre}</div>
                        <div class="text-gray-300 text-xs mt-1">Reclamado a las <span class="font-bold text-white">${data.entregado_en}</span></div>
                        <div class="text-gray-400 text-xs">Entregado por: ${data.entregado_por}</div>
                    </div>
                </div>`;
        } else {
            playBeep('error');
            clases = 'bg-red-900/40 border-2 border-red-700';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-700 flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div class="flex-grow">
                        <div class="text-red-400 font-black text-xs uppercase tracking-wider">No válido</div>
                        <div class="text-gray-200 text-sm mt-1 leading-snug">${data.message}</div>
                    </div>
                </div>`;
        }

        statusArea.className = `mb-6 rounded-2xl p-5 shadow-2xl ${clases}`;
        statusArea.innerHTML = html;
        statusArea.classList.remove('hidden');
    }
    </script>
</body>
</html>
