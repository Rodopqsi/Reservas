<nav class="bg-white border-b border-gray-100 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo y menú hamburguesa -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full shadow">
                </a>
                <!-- Desktop Nav -->
                <div class="hidden md:flex space-x-8 ml-10">
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
            <!-- Botón hamburguesa -->
            <div class="flex md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none" aria-label="Abrir menú">
                    <svg id="hamburger-open" class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="hamburger-close" class="h-7 w-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Acciones usuario desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                <div class="relative">
                    <a href="{{ route('notificaciones.index') }}" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition" title="Notificaciones">
                        <i class="fas fa-bell text-lg"></i>
                        @if(auth()->user()->notificacionesNoLeidas()->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->notificacionesNoLeidas()->count() }}
                            </span>
                        @endif
                    </a>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition" title="Perfil">
                    <i class="fas fa-user text-lg"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-gray-100 transition" title="Cerrar Sesión">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Menú móvil -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200 w-full z-50 absolute left-0">
        <div class="pt-2 pb-3 space-y-1 flex flex-col px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendario.index')" :active="request()->routeIs('calendario.*')">
                {{ __('Calendario') }}
            </x-responsive-nav-link>
            @if(auth()->user()->isProfesor())
                <x-responsive-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.*')">
                    {{ __('Mis Reservas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reservas.create')" :active="request()->routeIs('reservas.create')">
                    {{ __('Nueva Reserva') }}
                </x-responsive-nav-link>
            @endif
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Panel Admin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.profesores.index')" :active="request()->routeIs('admin.profesores.*')">
                    {{ __('Profesores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.asignaciones.index')" :active="request()->routeIs('admin.asignaciones.*')">
                    {{ __('Asignar Horarios') }}
                </x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
// Menú hamburguesa responsive
const mobileMenuBtn = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const hamburgerOpen = document.getElementById('hamburger-open');
const hamburgerClose = document.getElementById('hamburger-close');
if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        hamburgerOpen.classList.toggle('hidden');
        hamburgerClose.classList.toggle('hidden');
    });
}
</script>

<!-- Notificaciones Flotantes -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
    <!-- Las notificaciones se insertarán aquí dinámicamente -->
</div>

<script>
// Función para menú móvil
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

// Sistema de notificaciones flotantes
function mostrarNotificacionFlotante(mensaje, tipo = 'info', duracion = 5000) {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
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
function verificarNotificaciones() {
    fetch('/api/notificaciones/verificar-nuevas')
        .then(response => response.json())
        .then(data => {
            if (data.nuevas > 0) {
                const mensaje = data.nuevas === 1 ? 
                    'Tienes una nueva notificación' : 
                    `Tienes ${data.nuevas} notificaciones nuevas`;
                
                mostrarNotificacionFlotante(mensaje, 'info');
            }
        })
        .catch(error => {
            console.log('Error verificando notificaciones:', error);
        });
}

// Verificar cada 30 segundos
setInterval(verificarNotificaciones, 30000);

// Verificar al cargar la página
document.addEventListener('DOMContentLoaded', verificarNotificaciones);

// Agregar efectos hover a los iconos
document.addEventListener('DOMContentLoaded', function() {
    // Efectos hover para iconos
    const icons = document.querySelectorAll('a[title], button[title]');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
