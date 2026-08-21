<nav x-data="{ open: false }" class="bg-theme-bg border-b border-white/10 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-sena rounded-md flex items-center justify-center">
                            <span class="text-white font-extrabold text-xs leading-none">SE<br>NA</span>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-white font-bold text-sm leading-tight">Día del Aprendiz</div>
                            <div class="text-gray-400 text-[10px] tracking-wide">Panel de Control</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ms-8 sm:flex">
                    @auth
                        @if(auth()->user()->esAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('admin.dashboard') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.importar.show') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('admin.importar.*') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Importar
                            </a>
                            <a href="{{ route('admin.actividades.index') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('admin.actividades.*') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Actividades
                            </a>
                            <a href="{{ route('admin.usuarios.index') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('admin.usuarios.*') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 5.197h-6m2-10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                Usuarios
                            </a>
                            <a href="{{ route('admin.fichos.index') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('admin.fichos.*') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                Fichos
                            </a>
                        @else
                            <a href="{{ route('validacion.index') }}"
                               class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                      {{ request()->routeIs('validacion.*') ? 'bg-sena text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                                Validación
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-white/20 text-sm leading-4 font-medium rounded-lg text-gray-300 bg-white/5 hover:bg-white/10 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div class="w-6 h-6 bg-sena rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                @if(auth()->user()->esAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.importar.show')" :active="request()->routeIs('admin.importar.*')">
                        Importar Aprendices
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.actividades.index')" :active="request()->routeIs('admin.actividades.*')">
                        Actividades
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.*')">
                        Usuarios / Operadores
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.fichos.index')" :active="request()->routeIs('admin.fichos.*')">
                        Fichos
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('validacion.index')" :active="request()->routeIs('validacion.*')">
                        Validación
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
