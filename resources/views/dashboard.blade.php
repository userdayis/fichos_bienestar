<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border-t-4 border-sena">
                <div class="p-8 text-gray-800">
                    <h3 class="text-2xl font-bold text-sena mb-2">Bienvenido al Panel de Control</h3>
                    <p class="text-gray-600">Has iniciado sesión correctamente. Desde aquí podrás acceder a todas las funciones disponibles para tu perfil.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
