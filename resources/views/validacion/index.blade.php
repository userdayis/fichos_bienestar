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
</head>
<body class="bg-theme-bg text-theme-cream antialiased font-sans min-h-screen flex flex-col">

    <!-- Header -->
    <header class="border-b border-white/10 bg-theme-panel/80">
        <div class="max-w-3xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-sena rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-[10px] leading-none text-center">SE<br>NA</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm">Panel de Validación</div>
                    <div class="text-theme-mustard text-[10px] font-bold tracking-wider">{{ $actividad->nombre ?? 'Sin actividad asignada' }}</div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-500">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition-colors">Salir</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-10">
        <div class="w-full max-w-sm">

            <!-- Status Area -->
            <div id="status-area" class="mb-6 hidden">
                <!-- Se llena via JS -->
            </div>

            <!-- Input de Código -->
            <div class="bg-theme-panel rounded-2xl border border-white/10 shadow-2xl p-6 mb-4">
                <div class="text-xs text-gray-500 font-semibold uppercase tracking-widest mb-3">Ingresa el código del ficho</div>
                
                <div class="flex gap-2">
                    <input 
                        id="codigo-input"
                        type="text" 
                        placeholder="Ej: ABC-1234"
                        maxlength="50"
                        class="flex-grow bg-theme-bg border border-white/20 text-white font-mono text-lg px-4 py-3 rounded-xl focus:outline-none focus:border-theme-mustard focus:ring-1 focus:ring-theme-mustard transition-colors placeholder-gray-700 uppercase tracking-widest"
                    >
                    <button 
                        id="validar-btn"
                        onclick="validarCodigo()"
                        class="px-5 py-3 bg-theme-mustard text-[#4a3200] hover:bg-yellow-500 active:scale-95 font-extrabold rounded-xl transition-all shadow-lg text-sm">
                        ✓
                    </button>
                </div>
                <p class="text-xs text-gray-600 mt-3 text-center">El operador puede escribir el código alfanumérico o escanear el QR con el dispositivo.</p>
            </div>

            <!-- Actividad del operador -->
            @if($actividad)
            <div class="bg-theme-panel/50 rounded-xl border border-white/5 px-5 py-4 text-center">
                <div class="text-xs text-gray-500 mb-1">Punto asignado</div>
                <div class="font-bold text-white text-lg">{{ $actividad->nombre }}</div>
                <input type="hidden" id="actividad-id" value="{{ $actividad->id }}">
            </div>
            @endif

        </div>
    </main>

    <script>
    document.getElementById('codigo-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') validarCodigo();
    });

    async function validarCodigo() {
        const codigo = document.getElementById('codigo-input').value.trim().toUpperCase();
        const actividadId = document.getElementById('actividad-id')?.value;
        const statusArea = document.getElementById('status-area');
        const btn = document.getElementById('validar-btn');

        if (!codigo) return;

        btn.disabled = true;
        btn.textContent = '...';
        statusArea.classList.add('hidden');

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
            mostrarResultado({ status: 'error', message: 'Error de conexión. Intenta de nuevo.' });
        }

        btn.disabled = false;
        btn.textContent = '✓';
        document.getElementById('codigo-input').value = '';
        document.getElementById('codigo-input').focus();
    }

    function mostrarResultado(data) {
        const statusArea = document.getElementById('status-area');
        let html = '';
        let clases = '';

        if (data.status === 'entregado') {
            clases = 'bg-sena/20 border border-sena/30';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-sena flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <div class="text-sena font-extrabold text-sm uppercase tracking-wider">¡Entregado ahora!</div>
                        <div class="text-white font-bold text-lg mt-0.5">${data.aprendiz_nombre}</div>
                        <div class="text-gray-400 text-xs font-mono">Doc. ${data.aprendiz_documento} · Ficha ${data.aprendiz_ficha}</div>
                        <div class="text-gray-500 text-xs mt-1">${data.entregado_en}</div>
                    </div>
                </div>`;
        } else if (data.status === 'ya_entregado') {
            clases = 'bg-yellow-900/30 border border-yellow-700/30';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-yellow-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-yellow-400 font-extrabold text-sm uppercase tracking-wider">Ya fue reclamado</div>
                        <div class="text-white font-bold mt-0.5">${data.aprendiz_nombre}</div>
                        <div class="text-gray-400 text-xs">Entregado a las ${data.entregado_en} por ${data.entregado_por}</div>
                    </div>
                </div>`;
        } else {
            clases = 'bg-red-900/30 border border-red-800/30';
            html = `
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <div class="text-red-400 font-extrabold text-sm uppercase tracking-wider">No válido</div>
                        <div class="text-gray-300 text-sm mt-0.5">${data.message}</div>
                    </div>
                </div>`;
        }

        statusArea.className = `mb-6 rounded-2xl p-5 ${clases}`;
        statusArea.innerHTML = html;
        statusArea.classList.remove('hidden');
    }
    </script>
</body>
</html>
