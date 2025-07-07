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
                        <div class="text-3xl font-bold text-green-600">{{ $reservasCalendario->count() }}</div>
                        <div class="text-gray-600">Reservas Semana</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $reservas->where('estado', 'pendiente')->count() }}</div>
                        <div class="text-gray-600">Mis Pendientes</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Calendario Simple -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Calendario de Aulas</h3>
                            <div class="text-sm text-gray-600">
                                Aula: <span id="nombre-aula-actual" class="font-semibold text-blue-600">{{ $aulas->first()->nombre ?? 'Selecciona un aula' }}</span>
                            </div>
                        </div>
                        
                        <!-- Filtros -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <div class="flex items-center space-x-2">
                                <label class="text-sm text-gray-600">Aula:</label>
                                <select id="filtro-aula" class="text-sm border rounded px-2 py-1">
                                    @foreach($aulas as $aula)
                                        <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label class="text-sm text-gray-600">Fecha:</label>
                                <input type="date" id="filtro-fecha" class="text-sm border rounded px-2 py-1" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <button id="aplicar-filtros" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                Aplicar
                            </button>
                        </div>
                        <!-- Leyenda -->
                        <div class="mb-4 flex flex-wrap gap-3 text-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-white border-2 border-gray-300 rounded"></div>
                                <span>Libre</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                                <span>Aprobada</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-orange-500 rounded"></div>
                                <span>Pendiente</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-gray-500 rounded"></div>
                                <span>Cancelada</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-red-500 rounded"></div>
                                <span>Rechazada</span>
                            </div>
                        </div>
                        
                        <!-- Calendario -->
                        <div class="overflow-x-auto">
                            <div id="calendario-container" class="min-w-full">
                                <div class="grid gap-1 text-sm" style="grid-template-columns: 80px repeat(7, 1fr);">
                                    <!-- Cabecera -->
                                    <div class="font-semibold text-center py-2">Hora</div>
                                    @php
                                        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        $fechaInicio = Carbon\Carbon::now()->startOfWeek();
                                    @endphp
                                    @foreach($diasSemana as $index => $dia)
                                        @php
                                            $fechaDia = $fechaInicio->copy()->addDays($index);
                                        @endphp
                                        <div class="font-semibold text-center py-2 bg-gray-50 dia-header" data-dia="{{ $index }}">
                                            <div class="font-bold">{{ $dia }}</div>
                                            <div class="text-xs text-gray-500">{{ $fechaDia->format('d/m') }}</div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Contenido del calendario por horas -->
                                    @for($hora = 8; $hora <= 18; $hora++)
                                        <!-- Columna de hora -->
                                        <div class="font-medium text-center py-3 bg-blue-50 rounded flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="font-bold text-sm">{{ str_pad($hora, 2, '0', STR_PAD_LEFT) }}:00</div>
                                                <div class="text-xs text-gray-500">{{ str_pad($hora + 1, 2, '0', STR_PAD_LEFT) }}:00</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Columnas de días para esta hora -->
                                        @for($dia = 0; $dia < 7; $dia++)
                                            @php
                                                $horaInicio = str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $fechaDia = $fechaInicio->copy()->addDays($dia)->format('Y-m-d');
                                                $aulaSeleccionada = $aulas->first(); // Por defecto la primera aula
                                                
                                                // Buscar reserva en esta hora y día para el aula seleccionada
                                                $reservaEnHora = $reservasCalendario->first(function($reserva) use ($aulaSeleccionada, $fechaDia, $horaInicio) {
                                                    $fechaReserva = $reserva->fecha instanceof \Carbon\Carbon ? $reserva->fecha->format('Y-m-d') : $reserva->fecha;
                                                    $horaInicioReserva = $reserva->hora_inicio instanceof \Carbon\Carbon ? $reserva->hora_inicio->format('H:i:s') : $reserva->hora_inicio;
                                                    $horaFinReserva = $reserva->hora_fin instanceof \Carbon\Carbon ? $reserva->hora_fin->format('H:i:s') : $reserva->hora_fin;
                                                    
                                                    return $reserva->aula_id == $aulaSeleccionada->id && 
                                                           $fechaReserva == $fechaDia && 
                                                           $horaInicioReserva <= $horaInicio && 
                                                           $horaFinReserva > $horaInicio;
                                                });
                                            @endphp
                                            
                                            <div class="text-center py-2 border min-h-[60px] flex items-center justify-center calendario-slot dia-slot-{{ $dia }}" 
                                                 data-dia="{{ $dia }}" 
                                                 data-fecha="{{ $fechaDia }}"
                                                 data-hora="{{ $hora }}"
                                                 style="
                                                    @if($reservaEnHora)
                                                        @if($reservaEnHora->estado == 'aprobada')
                                                            background-color: #10b981; color: white;
                                                        @elseif($reservaEnHora->estado == 'pendiente')
                                                            background-color: #f59e0b; color: white;
                                                        @elseif($reservaEnHora->estado == 'cancelada')
                                                            background-color: #6b7280; color: white;
                                                        @else
                                                            background-color: #ef4444; color: white;
                                                        @endif
                                                    @else
                                                        background-color: #f8fafc; 
                                                        border: 1px solid #e2e8f0; 
                                                        color: #64748b;
                                                    @endif
                                                 ">
                                                <div class="text-xs">
                                                    @if($reservaEnHora)
                                                        <div class="font-medium">{{ Str::limit($reservaEnHora->user->name, 10) }}</div>
                                                        <div class="text-xs opacity-75">{{ date('H:i', strtotime($reservaEnHora->hora_inicio)) }}-{{ date('H:i', strtotime($reservaEnHora->hora_fin)) }}</div>
                                                    @else
                                                        <div class="text-gray-500">Libre</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones Rápidas (más pequeñas) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-4">Acciones Rápidas</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('reservas.create') }}" class="block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center text-sm">
                                Nueva Reserva
                            </a>
                            
                            <a href="{{ route('reservas.index') }}" class="block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-center text-sm">
                                Mis Reservas
                            </a>
                            
                            <a href="{{ route('calendario.index') }}" class="block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-center text-sm">
                                Ver Calendario
                            </a>
                            
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-center text-sm">
                                    Panel Admin
                                </a>
                            @endif
                        </div>
                        
                        <!-- Estadísticas compactas -->
                        <div class="mt-4 pt-4 border-t">
                            <h4 class="font-semibold mb-2 text-sm">Estadísticas</h4>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-blue-100 p-2 rounded">
                                    <div class="font-semibold">{{ $totalReservas }}</div>
                                    <div class="text-gray-600">Total Reservas</div>
                                </div>
                                <div class="bg-green-100 p-2 rounded">
                                    <div class="font-semibold">{{ $reservasConfirmadas }}</div>
                                    <div class="text-gray-600">Aprobadas</div>
                                </div>
                                <div class="bg-orange-100 p-2 rounded">
                                    <div class="font-semibold">{{ $reservasPendientes }}</div>
                                    <div class="text-gray-600">Pendientes</div>
                                </div>
                                <div class="bg-gray-100 p-2 rounded">
                                    <div class="font-semibold">{{ $aulas->count() }}</div>
                                    <div class="text-gray-600">Aulas</div>
                                </div>
                            </div>
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
        // Funcionalidad de filtros para el calendario
        document.addEventListener('DOMContentLoaded', function() {
            const filtroAula = document.getElementById('filtro-aula');
            const filtroFecha = document.getElementById('filtro-fecha');
            const aplicarFiltros = document.getElementById('aplicar-filtros');
            const nombreAulaActual = document.getElementById('nombre-aula-actual');
            
            // Datos de aulas para el filtro
            const aulasData = {
                @foreach($aulas as $aula)
                    "{{ $aula->id }}": "{{ $aula->nombre }}",
                @endforeach
            };
            
            // Función para aplicar filtros
            function aplicarFiltrosCalendario() {
                const aulaSeleccionada = filtroAula.value;
                const fechaSeleccionada = filtroFecha.value;
                
                // Actualizar el nombre del aula en el título
                if (aulaSeleccionada && aulasData[aulaSeleccionada]) {
                    nombreAulaActual.textContent = aulasData[aulaSeleccionada];
                } else {
                    nombreAulaActual.textContent = 'Selecciona un aula';
                }
                
                // Si no hay aula seleccionada, no hacer la petición
                if (!aulaSeleccionada) {
                    return;
                }
                
                // Realizar petición AJAX para obtener datos actualizados
                const url = `/api/calendario/datos?aula_id=${aulaSeleccionada}&fecha=${fechaSeleccionada}`;
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        actualizarCalendario(data);
                    } else {
                        console.error('Error en los datos:', data);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                    // En caso de error, mostrar todos los slots como libres
                    mostrarTodosLibres();
                });
            }
            
            // Función para actualizar el calendario con nuevos datos
            function actualizarCalendario(data) {
                // Primero, resetear todos los slots a libre
                mostrarTodosLibres();
                
                // Luego, actualizar los que tienen reservas
                if (data.reservas && data.reservas.length > 0) {
                    data.reservas.forEach(reserva => {
                        const slots = document.querySelectorAll('.calendario-slot');
                        
                        slots.forEach(slot => {
                            const fecha = slot.getAttribute('data-fecha');
                            const hora = parseInt(slot.getAttribute('data-hora'));
                            
                            // Verificar si esta reserva aplica a este slot
                            const horaInicioReserva = parseInt(reserva.hora_inicio.split(':')[0]);
                            const horaFinReserva = parseInt(reserva.hora_fin.split(':')[0]);
                            
                            if (reserva.fecha === fecha && hora >= horaInicioReserva && hora < horaFinReserva) {
                                // Aplicar estilos según el estado de la reserva
                                let backgroundColor = '#f8fafc';
                                let color = '#64748b';
                                
                                switch(reserva.estado) {
                                    case 'aprobada':
                                        backgroundColor = '#10b981';
                                        color = 'white';
                                        break;
                                    case 'pendiente':
                                        backgroundColor = '#f59e0b';
                                        color = 'white';
                                        break;
                                    case 'cancelada':
                                        backgroundColor = '#6b7280';
                                        color = 'white';
                                        break;
                                    default:
                                        backgroundColor = '#ef4444';
                                        color = 'white';
                                }
                                
                                slot.style.backgroundColor = backgroundColor;
                                slot.style.color = color;
                                slot.style.border = '1px solid ' + backgroundColor;
                                
                                slot.innerHTML = `
                                    <div class="text-xs">
                                        <div class="font-medium">${reserva.profesor.substring(0, 10)}</div>
                                        <div class="text-xs opacity-75">${reserva.hora_inicio.substring(0, 5)}-${reserva.hora_fin.substring(0, 5)}</div>
                                    </div>
                                `;
                            }
                        });
                    });
                }
            }
            
            // Función para mostrar todos los slots como libres
            function mostrarTodosLibres() {
                const slots = document.querySelectorAll('.calendario-slot');
                slots.forEach(slot => {
                    slot.style.backgroundColor = '#f8fafc';
                    slot.style.color = '#64748b';
                    slot.style.border = '1px solid #e2e8f0';
                    slot.innerHTML = `
                        <div class="text-xs">
                            <div class="text-gray-500">Libre</div>
                        </div>
                    `;
                });
            }
            
            // Event listeners para filtros
            if (aplicarFiltros) {
                aplicarFiltros.addEventListener('click', aplicarFiltrosCalendario);
            }
            
            // Aplicar filtros al cambiar selección
            filtroAula.addEventListener('change', function() {
                // Actualizar nombre del aula inmediatamente
                if (this.value && aulasData[this.value]) {
                    nombreAulaActual.textContent = aulasData[this.value];
                } else {
                    nombreAulaActual.textContent = 'Selecciona un aula';
                }
                // Aplicar filtros con la nueva selección
                aplicarFiltrosCalendario();
            });
            
            filtroFecha.addEventListener('change', function() {
                // Aplicar filtros con la nueva fecha
                aplicarFiltrosCalendario();
            });
            
            // Inicializar con la primera aula seleccionada
            if (filtroAula.value && aulasData[filtroAula.value]) {
                nombreAulaActual.textContent = aulasData[filtroAula.value];
                // Cargar datos iniciales
                setTimeout(() => {
                    aplicarFiltrosCalendario();
                }, 100);
            }
            
            // Mejorar visualización de slots
            function aplicarEfectosHover() {
                const slots = document.querySelectorAll('.calendario-slot');
                slots.forEach(slot => {
                    slot.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.05)';
                        this.style.zIndex = '10';
                        this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                    });
                    
                    slot.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                        this.style.zIndex = '1';
                        this.style.boxShadow = 'none';
                    });
                });
            }
            
            // Aplicar efectos iniciales
            aplicarEfectosHover();
            
            // Actualizar datos cada 60 segundos para reflejar cambios
            setInterval(function() {
                if (filtroAula.value) {
                    aplicarFiltrosCalendario();
                }
            }, 60000);
        });
    </script>
    
</x-app-layout>
