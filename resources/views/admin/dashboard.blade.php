<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de Administrador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Acciones Rápidas -->
            <div class="mb-6 flex gap-4">
                <a href="{{ route('admin.importar.show') }}" class="inline-flex items-center px-4 py-2 bg-theme-mustard border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Importar Aprendices (CSV)
                </a>
                <!-- El botón de exportar asumiremos que exporta el reporte completo o por actividad. Al no tener una ruta general, usamos href="#" para ser modificado o si existe admin.fichos.exportar lo adaptamos -->
                <button onclick="alert('Exportación de reporte general en desarrollo.')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sena focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar Reporte
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Tarjetas de Estadísticas -->
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-sena">
                    <h4 class="text-gray-500 text-sm uppercase font-bold">Total Aprendices</h4>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $totalAprendices }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-sena">
                    <h4 class="text-gray-500 text-sm uppercase font-bold">Total Fichos</h4>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $totalFichos }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-sena">
                    <h4 class="text-gray-500 text-sm uppercase font-bold">Entregados</h4>
                    <p class="text-3xl font-extrabold text-sena">{{ $totalEntregados }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-red-500">
                    <h4 class="text-gray-500 text-sm uppercase font-bold">Pendientes</h4>
                    <p class="text-3xl font-extrabold text-red-500">{{ $totalPendientes }}</p>
                </div>
            </div>

            <!-- Stats por Actividad -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Estadísticas por Actividad</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entregados</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendientes</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($statsPorActividad as $stat)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stat['nombre'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['total'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-bold">{{ $stat['entregados'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-bold">{{ $stat['pendientes'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                          <div class="bg-sena h-2.5 rounded-full" style="width: {{ $stat['porcentaje'] }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 mt-1">{{ $stat['porcentaje'] }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
