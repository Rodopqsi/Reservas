<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; width: 40px;" class="rounded-full shadow">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('calendario.index')" :active="request()->routeIs('calendario.*')">
                        {{ __('Calendario') }}
                    </x-nav-link>
                    @if(auth()->user()->isProfesor())
                        <x-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.*')">
                            {{ __('Mis Reservas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reservas.create')" :active="request()->routeIs('reservas.create')">
                            {{ __('Nueva Reserva') }}
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Panel Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.profesores.index')" :active="request()->routeIs('admin.profesores.*')">
                            {{ __('Profesores') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.asignaciones.index')" :active="request()->routeIs('admin.asignaciones.*')">
                            {{ __('Asignar Horarios') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notificaciones -->
                <div class="relative mr-4">
                    <a href="{{ route('notificaciones.index') }}" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition">
                        <i class="fas fa-bell text-lg"></i>
                        @if(auth()->user()->notificacionesNoLeidas()->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->notificacionesNoLeidas()->count() }}
                            </span>
                        @endif
                    </a>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendario.index')" :active="request()->routeIs('calendario.*')">
                {{ __('Calendario') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.*')">
                {{ __('Mis Reservas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reservas.create')" :active="request()->routeIs('reservas.create')">
                {{ __('Nueva Reserva') }}
            </x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                    {{ __('Panel Admin') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Notificaciones Flotantes -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
    <!-- Las notificaciones se insertarán aquí dinámicamente -->
</div>

<script>
// Sistema de notificaciones flotantes
function mostrarNotificacionFlotante(mensaje, tipo = 'info', duracion = 5000) {
    const container = document.getElementById('notification-container');
    const id = 'notif-' + Date.now();
    
    const colores = {
        'success': 'bg-green-500 border-green-600',
        'error': 'bg-red-500 border-red-600',
        'warning': 'bg-yellow-500 border-yellow-600',
        'info': 'bg-blue-500 border-blue-600'
    };
    
    const iconos = {
        'success': '✓',
        'error': '✗',
        'warning': '⚠',
        'info': 'ℹ'
    };
    
    const notificacion = document.createElement('div');
    notificacion.id = id;
    notificacion.className = `
        ${colores[tipo]} text-white px-4 py-3 rounded-lg shadow-lg border-l-4 
        transform transition-all duration-300 translate-x-full opacity-0
        max-w-sm cursor-pointer hover:shadow-xl
    `;
    
    notificacion.innerHTML = `
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-lg mr-2">${iconos[tipo]}</span>
                <span class="text-sm font-medium">${mensaje}</span>
            </div>
            <button onclick="cerrarNotificacion('${id}')" class="ml-2 text-white hover:text-gray-200">
                ✕
            </button>
        </div>
    `;
    
    container.appendChild(notificacion);
    
    // Animar entrada
    setTimeout(() => {
        notificacion.classList.remove('translate-x-full', 'opacity-0');
    }, 100);
    
    // Auto-cerrar
    setTimeout(() => {
        cerrarNotificacion(id);
    }, duracion);
    
    // Cerrar al hacer click
    notificacion.addEventListener('click', () => cerrarNotificacion(id));
}

function cerrarNotificacion(id) {
    const notificacion = document.getElementById(id);
    if (notificacion) {
        notificacion.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            notificacion.remove();
        }, 300);
    }
}

// Verificar notificaciones periódicamente
let ultimaVerificacion = 0;
let notificacionesMostradas = new Set();

function verificarNotificaciones() {
    fetch('/api/notificaciones/verificar-nuevas')
        .then(response => response.json())
        .then(data => {
            // Solo mostrar notificación si hay nuevas notificaciones
            if (data.nuevas > 0 && !notificacionesMostradas.has(data.total)) {
                const mensaje = data.nuevas === 1 ? 
                    'Tienes una nueva notificación' : 
                    `Tienes ${data.nuevas} notificaciones nuevas`;
                
                mostrarNotificacionFlotante(mensaje, 'info');
                notificacionesMostradas.add(data.total);
                
                // Limpiar cache después de 5 minutos
                setTimeout(() => {
                    notificacionesMostradas.delete(data.total);
                }, 300000);
            }
        })
        .catch(error => {
            // Silenciar errores para no molestar al usuario
        });
}

// Verificar cada 30 segundos
setInterval(verificarNotificaciones, 30000);

// Verificar al cargar la página
document.addEventListener('DOMContentLoaded', verificarNotificaciones);
</script>
