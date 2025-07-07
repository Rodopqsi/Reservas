<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Estadísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $aulas->count() }}</div>
                        <div class="text-gray-600">Aulas Disponibles</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $reservas->where('estado', 'aprobada')->count() }}</div>
                        <div class="text-gray-600">Reservas Aprobadas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $reservas->where('estado', 'pendiente')->count() }}</div>
                        <div class="text-gray-600">Reservas Pendientes</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Calendario Simple -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Calendario de Aulas</h3>
                            <div class="flex space-x-2">
                                <!-- Filtro de Fecha -->
                                <input type="date" 
                                       id="fecha-filtro" 
                                       value="{{ date('Y-m-d') }}"
                                       style="font-size: 12px; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.25rem 0.5rem;">
                                
                                <!-- Filtro de Aula -->
                                <select id="aula-filtro" style="font-size: 12px; border: 1px solid #d1d5db; border-radius: 0.375rem; padding: 0.25rem 0.5rem;">
                                    <option value="">Todas las aulas</option>
                                    @foreach($aulas as $aula)
                                        <option value="{{ $aula->id }}">{{ $aula->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <div class="min-w-full">
                                <!-- Encabezado con nombres de aulas -->
                                <div class="grid gap-1 mb-2 text-xs" style="grid-template-columns: 80px repeat({{ $aulas->take(8)->count() }}, 1fr);">
                                    <div class="font-medium text-gray-500 p-2">Hora</div>
                                    @foreach($aulas->take(8) as $aula)
                                        <div class="font-medium text-gray-700 p-2 text-center bg-gray-50 rounded aula-header" data-aula-id="{{ $aula->id }}">
                                            <div class="font-semibold">{{ $aula->codigo }}</div>
                                            <div class="text-gray-500 text-xs">{{ Str::limit($aula->nombre, 10) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Filas de horarios -->
                                @for($hora = 8; $hora <= 18; $hora++)
                                    <div class="grid gap-1 mb-1 hora-row" style="grid-template-columns: 80px repeat({{ $aulas->take(8)->count() }}, 1fr);">
                                        <div class="text-xs font-medium text-gray-800 p-3 bg-blue-50 rounded flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="font-bold">{{ str_pad($hora, 2, '0', STR_PAD_LEFT) }}:00</div>
                                                <div class="text-gray-500">{{ str_pad($hora + 1, 2, '0', STR_PAD_LEFT) }}:00</div>
                                            </div>
                                        </div>
                                        @foreach($aulas->take(8) as $aula)
                                            @php
                                                $horaFormateada = str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $horaFin = str_pad($hora + 1, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $fechaActual = request('fecha', today()->format('Y-m-d'));
                                                $reservaEnHora = $reservas->where('aula_id', $aula->id)
                                                    ->where('fecha', $fechaActual)
                                                    ->where('estado', 'aprobada')
                                                    ->filter(function($reserva) use ($horaFormateada, $horaFin) {
                                                        return $reserva->hora_inicio < $horaFin && $reserva->hora_fin > $horaFormateada;
                                                    })
                                                    ->first();
                                            @endphp
                                            <div class="h-14 rounded text-xs flex items-center justify-center cursor-pointer transition-colors duration-200 hora-slot aula-slot-{{ $aula->id }}
                                                 {{ $reservaEnHora ? 'bg-red-100 border border-red-300 text-red-800' : 'bg-green-50 border border-green-300 text-green-700 hover:bg-green-100' }}"
                                                 title="{{ $reservaEnHora ? $reservaEnHora->user->name . ' - ' . $reservaEnHora->motivo . ' (' . date('H:i', strtotime($reservaEnHora->hora_inicio)) . '-' . date('H:i', strtotime($reservaEnHora->hora_fin)) . ')' : 'Disponible para ' . $aula->nombre }}"
                                                 data-hora="{{ $hora }}"
                                                 data-aula="{{ $aula->id }}"
                                                 data-fecha="{{ $fechaActual }}">
                                                @if($reservaEnHora)
                                                    <div class="text-center px-1">
                                                        <div class="font-medium text-xs">{{ Str::limit($reservaEnHora->user->name, 12) }}</div>
                                                        <div class="text-xs opacity-75">{{ date('H:i', strtotime($reservaEnHora->hora_inicio)) }}-{{ date('H:i', strtotime($reservaEnHora->hora_fin)) }}</div>
                                                    </div>
                                                @else
                                                    <div class="text-center">
                                                        <i class="fas fa-check text-green-600 text-lg"></i>
                                                        <div class="text-xs mt-1">Libre</div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endfor
                                
                                <!-- Leyenda -->
                                <div class="flex justify-center space-x-6 mt-4 text-xs">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-green-50 border-l-2 border-green-400 rounded mr-2"></div>
                                        <span class="text-gray-600">Disponible</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-red-100 border-l-2 border-red-400 rounded mr-2"></div>
                                        <span class="text-gray-600">Ocupada</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('calendario.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver calendario completo →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Acciones Rápidas</h3>
                        <div class="space-y-3">
                            <a href="{{ route('reservas.create') }}" class="btn btn-blue block w-full" style="background-color: #3b82f6; color: white; padding: 0.75rem 1rem; border-radius: 0.375rem; font-weight: 500; text-decoration: none; display: block; text-align: center; transition: all 0.2s;">
                                Nueva Reserva
                            </a>
                            <a href="{{ route('reservas.index') }}" class="btn btn-gray block w-full" style="background-color: #6b7280; color: white; padding: 0.75rem 1rem; border-radius: 0.375rem; font-weight: 500; text-decoration: none; display: block; text-align: center; transition: all 0.2s;">
                                Ver Mis Reservas
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-green block w-full" style="background-color: #10b981; color: white; padding: 0.75rem 1rem; border-radius: 0.375rem; font-weight: 500; text-decoration: none; display: block; text-align: center; transition: all 0.2s;">
                                    Panel de Administración
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservas recientes -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Mis Reservas Recientes</h3>
                        @if($reservas->isEmpty())
                            <p class="text-gray-500">No tienes reservas aún.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($reservas->take(6) as $reserva)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-medium">{{ $reserva->aula->nombre }}</h4>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                                @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($reserva->estado) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            {{ $reserva->fecha->format('d/m/Y') }} - 
                                            {{ date('H:i', strtotime($reserva->hora_inicio)) }} a {{ date('H:i', strtotime($reserva->hora_fin)) }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ Str::limit($reserva->motivo, 30) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Funcionalidad de filtros y actualización en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const fechaFiltro = document.getElementById('fecha-filtro');
            const aulaFiltro = document.getElementById('aula-filtro');
            
            function actualizarCalendario() {
                const fechaSeleccionada = fechaFiltro.value;
                const aulaSeleccionada = aulaFiltro.value;
                
                // Realizar petición AJAX para obtener datos actualizados
                fetch(`/api/calendario-data?fecha=${fechaSeleccionada}&aula=${aulaSeleccionada}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    actualizarVistaCalendario(data);
                })
                .catch(error => {
                    console.log('Actualizando vista con filtros locales...');
                    aplicarFiltrosLocales();
                });
            }
            
            function aplicarFiltrosLocales() {
                const aulaSeleccionada = aulaFiltro.value;
                
                // Mostrar/ocultar columnas de aulas
                const aulasHeaders = document.querySelectorAll('.aula-header');
                const todasLasFilas = document.querySelectorAll('.hora-row');
                
                aulasHeaders.forEach((header, index) => {
                    const aulaId = header.dataset.aulaId;
                    const mostrar = aulaSeleccionada === '' || aulaSeleccionada === aulaId;
                    
                    // Mostrar/ocultar header
                    header.style.display = mostrar ? 'block' : 'none';
                    
                    // Mostrar/ocultar slots correspondientes en cada fila
                    todasLasFilas.forEach(fila => {
                        const slots = fila.querySelectorAll(`.aula-slot-${aulaId}`);
                        slots.forEach(slot => {
                            slot.style.display = mostrar ? 'flex' : 'none';
                        });
                    });
                });
                
                // Ajustar grid columns dinámicamente
                const aulasVisibles = document.querySelectorAll('.aula-header:not([style*="display: none"])').length;
                const gridCols = `80px repeat(${aulasVisibles}, 1fr)`;
                
                document.querySelectorAll('[style*="grid-template-columns"]').forEach(element => {
                    element.style.gridTemplateColumns = gridCols;
                });
            }
            
            function actualizarVistaCalendario(data) {
                // Actualizar slots con nuevos datos
                data.reservas.forEach(reserva => {
                    const slot = document.querySelector(`[data-aula="${reserva.aula_id}"][data-hora="${reserva.hora}"]`);
                    if (slot) {
                        slot.className = 'h-14 rounded text-xs flex items-center justify-center cursor-pointer transition-colors duration-200 hora-slot bg-red-100 border border-red-300 text-red-800';
                        slot.innerHTML = `
                            <div class="text-center px-1">
                                <div class="font-medium text-xs">${reserva.profesor_nombre}</div>
                                <div class="text-xs opacity-75">${reserva.hora_inicio}-${reserva.hora_fin}</div>
                            </div>
                        `;
                        slot.title = `${reserva.profesor_nombre} - ${reserva.motivo} (${reserva.hora_inicio}-${reserva.hora_fin})`;
                    }
                });
                
                aplicarFiltrosLocales();
            }
            
            // Event listeners
            fechaFiltro.addEventListener('change', actualizarCalendario);
            aulaFiltro.addEventListener('change', aplicarFiltrosLocales);
            
            // Actualizar cada 30 segundos para datos en tiempo real
            setInterval(actualizarCalendario, 30000);
            
            // Tooltips mejorados
            const slots = document.querySelectorAll('.hora-slot');
            slots.forEach(slot => {
                slot.addEventListener('mouseenter', function() {
                    const titulo = this.getAttribute('title');
                    if (titulo && titulo !== '') {
                        this.style.transform = 'scale(1.05)';
                        this.style.zIndex = '10';
                    }
                });
                
                slot.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.zIndex = '1';
                });
            });
            
            // Aplicar filtros iniciales
            aplicarFiltrosLocales();
        });
    </script>
    
</x-app-layout>
