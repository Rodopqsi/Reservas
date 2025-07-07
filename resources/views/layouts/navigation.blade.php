<nav class="bg-white border-b border-gray-100" style="background-color: white; border-bottom: 1px solid #e5e7eb; display: block;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="max-width: 80rem; margin: 0 auto; padding: 0 1rem;">
        <div class="flex justify-between h-16" style="display: flex; justify-content: space-between; align-items: center; height: 4rem;">
            <div class="flex" style="display: flex; align-items: center;">
                <!-- Logo -->
                <div class="shrink-0 flex items-center" style="flex-shrink: 0; display: flex; align-items: center;">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; width: 40px;" class="rounded-full shadow">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex" style="display: flex; margin-left: 2.5rem;">
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

            <!-- User Actions with Icons -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4" style="display: flex; align-items: center; gap: 1rem;">
                <!-- User Name -->
                <span class="text-gray-700 font-medium" style="color: #374151; font-weight: 500;">{{ Auth::user()->name }}</span>
                
                <!-- Notificaciones -->
                <div class="relative" style="position: relative;">
                    <a href="{{ route('notificaciones.index') }}" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition" style="color: #6b7280; padding: 0.5rem; border-radius: 9999px; text-decoration: none; display: inline-block;" title="Notificaciones">
                        <i class="fas fa-bell text-lg"></i>
                        @if(auth()->user()->notificacionesNoLeidas()->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" style="position: absolute; top: -4px; right: -4px; background-color: #ef4444; color: white; font-size: 0.75rem; border-radius: 50%; height: 20px; width: 20px; display: flex; align-items: center; justify-content: center;">
                                {{ auth()->user()->notificacionesNoLeidas()->count() }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Profile Icon -->
                <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition" style="color: #6b7280; padding: 0.5rem; border-radius: 9999px; text-decoration: none; display: inline-block;" title="Perfil">
                    <i class="fas fa-user text-lg"></i>
                </a>

                <!-- Logout Icon -->
                <form method="POST" action="{{ route('logout') }}" class="inline" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 p-2 rounded-full hover:bg-gray-100 transition" style="color: #6b7280; padding: 0.5rem; border-radius: 9999px; background: none; border: none; cursor: pointer; display: inline-flex; align-items: center;" title="Cerrar Sesión">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="hidden sm:hidden">
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

<script>
// Funciones para el menú de usuario
function toggleUserMenu() {
    const menu = document.getElementById('user-menu');
    menu.classList.toggle('hidden');
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('hamburger-open');
    const closeIcon = document.getElementById('hamburger-close');
    
    menu.classList.toggle('hidden');
    openIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
}

// Cerrar menú cuando se hace click fuera
document.addEventListener('click', function(event) {
    const userMenu = document.getElementById('user-menu');
    const userMenuButton = document.getElementById('user-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    
    // Cerrar menú de usuario si el click es fuera del menú
    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
    
    // Cerrar menú móvil si el click es fuera del menú
    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
        mobileMenu.classList.add('hidden');
        document.getElementById('hamburger-open').classList.remove('hidden');
        document.getElementById('hamburger-close').classList.add('hidden');
    }
});
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
