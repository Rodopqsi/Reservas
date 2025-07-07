<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario de Aulas') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <div class="container mx-auto px-4 py-6 max-w-7xl">
            <!-- Header ultra moderno con glassmorphism -->
            <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Título y descripción mejorados -->
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center shadow-xl transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-calendar-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                                    Calendario de Aulas
                                </h1>
                                <p class="text-slate-500 text-sm font-medium">Gestiona tus reservas de manera inteligente</p>
                            </div>
                        </div>
                        
                        <!-- Controles de navegación ultra modernos -->
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="irSemanaAnterior()" 
                                    class="group w-12 h-12 bg-white/80 backdrop-blur-sm border border-white/40 rounded-2xl hover:bg-white hover:border-blue-200 transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105">
                                <i class="fas fa-chevron-left text-slate-600 group-hover:text-blue-600 transition-colors"></i>
                            </button>
                            <button type="button" onclick="irHoy()" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-black rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 font-semibold text-sm shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-home mr-2"></i>Hoy
                            </button>
                            <button type="button" onclick="irSemanaSiguiente()" 
                                    class="group w-12 h-12 bg-white/80 backdrop-blur-sm border border-white/40 rounded-2xl hover:bg-white hover:border-blue-200 transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105">
                                <i class="fas fa-chevron-right text-slate-600 group-hover:text-blue-600 transition-colors"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros ultra modernos -->
            <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500/10 to-teal-500/10 p-6">
                    <form method="GET" action="{{ route('calendario.index') }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="aula_id" class="block text-sm font-bold text-slate-700 mb-3">
                                <i class="fas fa-door-open mr-2 text-emerald-600"></i>
                                <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    Aula
                                </span>
                            </label>
                            <select name="aula_id" id="aula_id" 
                                    class="w-full px-4 py-4 bg-white/80 backdrop-blur-sm border border-white/40 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-700 shadow-lg hover:shadow-xl" 
                                    onchange="this.form.submit()">
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ $aulaSeleccionada && $aulaSeleccionada->id == $aula->id ? 'selected' : '' }}>
                                        {{ $aula->nombre }} ({{ $aula->codigo }}) - {{ $aula->capacidad }}p
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="sm:w-72">
                            <label for="fecha" class="block text-sm font-bold text-slate-700 mb-3">
                                <i class="fas fa-calendar mr-2 text-emerald-600"></i>
                                <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                                    Semana
                                </span>
                            </label>
                            <input type="date" name="fecha" id="fecha" value="{{ $fechaCarbon->format('Y-m-d') }}" 
                                   class="w-full px-4 py-4 bg-white/80 backdrop-blur-sm border border-white/40 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-slate-700 shadow-lg hover:shadow-xl" 
                                   onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
            </div>

            @if($aulaSeleccionada)
                <!-- Información del Aula ultra moderna -->
                <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl mb-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500/10 to-purple-500/10 p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <i class="fas fa-door-open text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        {{ $aulaSeleccionada->nombre }}
                                    </h2>
                                    <p class="text-slate-500 font-medium">
                                        Semana del {{ $fechaCarbon->startOfWeek()->format('d') }} al {{ $fechaCarbon->endOfWeek()->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-3">
                                <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/50 rounded-2xl backdrop-blur-sm transform hover:scale-105 transition-all duration-300">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-users text-blue-600"></i>
                                        <span class="text-blue-800 font-bold">{{ $aulaSeleccionada->capacidad }} personas</span>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200/50 rounded-2xl backdrop-blur-sm transform hover:scale-105 transition-all duration-300">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-map-marker-alt text-emerald-600"></i>
                                        <span class="text-emerald-800 font-bold">{{ $aulaSeleccionada->ubicacion }}</span>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/50 rounded-2xl backdrop-blur-sm transform hover:scale-105 transition-all duration-300">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-tag text-amber-600"></i>
                                        <span class="text-amber-800 font-bold">{{ $aulaSeleccionada->codigo }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendario ultra moderno -->
                <div class="bg-white/70 backdrop-blur-xl border border-white/30 rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Header del calendario con gradiente futurista -->
                    <div class="bg-gradient-to-r from-slate-100 via-slate-50 to-white text-slate-800 p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-slate-200/60 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-slate-300/40">
                                    <i class="fas fa-calendar-week text-lg text-blue-700" style="margin-right:1rem;"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">{{ $aulaSeleccionada->nombre }}</h3>
                                    <p class="text-slate-500 text-sm">{{ $fechaCarbon->startOfWeek()->format('d M') }} - {{ $fechaCarbon->endOfWeek()->format('d M Y') }}</p>
                                </div>
                            </div>
                            <button type="button" onclick="actualizarCalendario()" 
                                    class="group px-5 py-3 bg-slate-100 hover:bg-blue-50 border border-slate-200 rounded-2xl transition-all duration-300 flex items-center space-x-2 backdrop-blur-sm">
                                <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-500 text-blue-700"></i>
                                <span class="font-semibold text-blue-700">Actualizar</span>
                            </button>
                        </div>
                    </div>

                    <!-- Leyenda ultra moderna -->
                    <div class="bg-gradient-to-r from-slate-50 via-white to-blue-50 px-6 py-4 border-b border-slate-100">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex flex-wrap items-center gap-6 text-sm">
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full shadow-lg"></div>
                                    <span class="text-slate-700 font-semibold">Disponible</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full shadow-lg"></div>
                                    <span class="text-slate-700 font-semibold">Reservado</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-gradient-to-br from-violet-500 to-violet-600 rounded-full shadow-lg"></div>
                                    <span class="text-slate-700 font-semibold">Seleccionado</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full shadow-lg"></div>
                                    <span class="text-slate-700 font-semibold">Pendiente</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 text-sm text-slate-600 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-lg border border-slate-200">
                                <i class="fas fa-clock text-blue-500"></i>
                                <span id="fecha-actual" class="font-semibold">{{ now()->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Controles de selección ultra modernos -->
                    <div class="hidden bg-gradient-to-r from-violet-50 via-purple-50 to-indigo-50 border border-violet-200/50 p-5 m-6 rounded-3xl backdrop-blur-sm shadow-xl" id="selection-controls">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-hand-pointer text-white"></i>
                                </div>
                                <div>
                                    <span id="selection-info" class="text-violet-800 font-bold text-lg">0 horas seleccionadas</span>
                                    <p class="text-violet-600 text-sm">Haz click en "Reservar" para continuar</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="clearSelection()" 
                                        class="px-4 py-2 text-violet-600 hover:text-violet-700 hover:bg-violet-100 rounded-xl transition-all duration-200 font-medium">
                                    <i class="fas fa-trash-alt mr-2"></i>Limpiar
                                </button>
                                <button type="button" onclick="confirmSelection()" 
                                        class="px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white rounded-2xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2 transform hover:scale-105">
                                    <i class="fas fa-check"></i>
                                    <span>Reservar Selección</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Grid del calendario ultra moderno - REDISEÑO COMPLETO -->
                    <div class="overflow-hidden">
                        <!-- Vista desktop ultra moderna -->
                        <div class="hidden lg:block">
                            <!-- Estructura de tabla CSS Grid completamente rediseñada -->
                            <div class="modern-calendar-grid">
                                <!-- Header Row - Días de la semana -->
                                <div class="calendar-header-row">
                                    <div class="time-header-cell">
                                        <div class="header-content">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-2 shadow-xl">
                                                <i class="fas fa-clock text-white text-lg"></i>
                                            </div>
                                            <div class="text-sm font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                                                Horario
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($diasSemana as $dia)
                                        <div class="day-header-cell">
                                            <div class="header-content">
                                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ $dia['nombre'] }}</div>
                                                <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-1">
                                                    {{ $dia['numero'] }}
                                                </div>
                                                <div class="text-xs text-slate-500 font-medium">{{ $dia['mes'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Filas de horarios -->
                                @foreach($horarios as $horarioIndex => $horario)
                                    <div class="calendar-time-row">
                                        <!-- Celda de horario -->
                                        <div class="time-slot-cell">
                                            <div class="time-content">
                                                <div class="text-lg font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                                                    {{ substr($horario['display'], 0, 5) }}
                                                </div>
                                                <div class="text-xs text-slate-500 font-medium">
                                                    {{ substr($horario['display'], 8, 5) }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Celdas de días -->
                                        @foreach($diasSemana as $diaIndex => $dia)
                                            @php
                                                $reserva = $reservas->first(function($r) use ($dia, $horario) {
                                                    $fechaReserva = $r->fecha instanceof \Carbon\Carbon ? $r->fecha->format('Y-m-d') : $r->fecha;
                                                    $horaInicioReserva = $r->hora_inicio instanceof \Carbon\Carbon ? $r->hora_inicio->format('H:i:s') : $r->hora_inicio;
                                                    $horaFinReserva = $r->hora_fin instanceof \Carbon\Carbon ? $r->hora_fin->format('H:i:s') : $r->hora_fin;
                                                    
                                                    return $fechaReserva == $dia['fecha'] && 
                                                           $horaInicioReserva <= $horario['inicio'] && 
                                                           $horaFinReserva > $horario['inicio'];
                                                });
                                            @endphp
                                            <div class="slot-cell modern-slot" 
                                                    data-fecha="{{ $dia['fecha'] }}"
                                                    data-hora-inicio="{{ $horario['inicio'] }}"
                                                    data-hora-fin="{{ $horario['fin'] }}"
                                                    data-aula-id="{{ $aulaSeleccionada->id }}"
                                                    data-horario-index="{{ $horarioIndex }}"
                                                    data-dia-index="{{ $diaIndex }}"
                                                    data-disponible="{{ $reserva ? 'false' : 'true' }}">
                                                @if($reserva)
                                                    @php
                                                        $esAsignacion = str_contains($reserva->observaciones ?? '', 'Asignación administrativa');
                                                        $colorClass = match($reserva->estado) {
                                                            'aprobada' => 'from-emerald-400 to-emerald-600',
                                                            'pendiente' => 'from-amber-400 to-amber-600',
                                                            'cancelada' => 'from-slate-400 to-slate-600',
                                                            'rechazada' => 'from-rose-400 to-rose-600',
                                                            default => 'from-slate-400 to-slate-600'
                                                        };
                                                    @endphp
                                                    <div class="slot-content slot-occupied modern-occupied"
                                                         title="{{ $esAsignacion ? 'Asignación: ' : 'Reserva: ' }}{{ $reserva->user->name }} - {{ ucfirst($reserva->estado) }}{{ $esAsignacion ? ' (Administrativa)' : '' }}"
                                                         onclick="event.stopPropagation(); showReservaDetails({{ $reserva->id }})">
                                                        <div class="occupied-container bg-gradient-to-br {{ $colorClass }} text-white">
                                                            <div class="occupied-header">
                                                                <div class="text-xs font-bold truncate">{{ substr($reserva->user->name, 0, 12) }}</div>
                                                                @if($esAsignacion)
                                                                    <i class="fas fa-calendar-check text-xs opacity-80" title="Asignación administrativa"></i>
                                                                @endif
                                                            </div>
                                                            <div class="occupied-body">
                                                                <div class="text-xs opacity-90 truncate">{{ substr($reserva->motivo, 0, 18) }}</div>
                                                            </div>
                                                            <div class="occupied-footer">
                                                                @if($reserva->estado == 'cancelada')
                                                                    <i class="fas fa-ban text-xs" title="Cancelada"></i>
                                                                @elseif($reserva->estado == 'pendiente')
                                                                    <i class="fas fa-clock text-xs" title="Pendiente"></i>
                                                                @elseif($reserva->estado == 'rechazada')
                                                                    <i class="fas fa-times text-xs" title="Rechazada"></i>
                                                                @else
                                                                    <i class="fas fa-check text-xs" title="Aprobada"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="slot-content slot-available modern-available"
                                                         title="Disponible - Click para reservar">
                                                        <div class="available-container">
                                                            <div class="available-icon">
                                                                <i class="fas fa-plus text-xl"></i>
                                                            </div>
                                                            <div class="available-text">
                                                                <span class="text-xs font-semibold">Disponible</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        
                    </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para detalles de reserva ultra moderno -->
    <div id="reserva-modal" class="fixed inset-0 bg-blue-500/80 modal-backdrop hidden z-50 items-center justify-center p-4">
        <div class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 rounded-3xl shadow-2xl border border-blue-300/60 p-6 m-4 max-w-md w-full transform transition-all duration-300">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold bg-gradient-to-r from-blue-800 to-blue-600 bg-clip-text text-transparent">
                    Detalles de Reserva
                </h3>
                <button onclick="closeReservaModal()" class="w-8 h-8 text-blue-500 hover:text-blue-700 hover:bg-blue-100 rounded-full flex items-center justify-center transition-all duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="reserva-details" class="space-y-3">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Variables globales para la selección
        let isSelecting = false;
        let selectedSlots = new Set();
        let startSlot = null;
        let currentDate = null;
        let currentAula = null;

        // Prevenir comportamiento por defecto del navegador
        document.addEventListener('selectstart', function(e) {
            if (e.target.closest('.slot-cell')) {
                e.preventDefault();
            }
        });

        // Función para manejar click en slot individual
        function handleSlotClick(element) {
            console.log('Click en slot:', element.dataset); // Debug
            
            // Si ya hay una reserva, mostrar detalles
            if (element.dataset.disponible === 'false') {
                console.log('Slot ocupado, no se puede seleccionar');
                return;
            }
            
            // Verificar si la fecha no es en el pasado
            const fecha = element.dataset.fecha;
            const fechaSeleccionada = new Date(fecha);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            if (fechaSeleccionada < hoy) {
                mostrarMensajeTemporario('No puedes reservar en fechas pasadas');
                return;
            }
            
            // Si ya está seleccionado, deseleccionar
            const slotKey = getSlotKey(element);
            if (selectedSlots.has(slotKey)) {
                console.log('Deseleccionando slot');
                deselectSlot(element);
                selectedSlots.delete(slotKey);
            } else {
                // Seleccionar el slot
                console.log('Seleccionando slot');
                selectSlot(element);
                selectedSlots.add(slotKey);
            }
            
            updateSelectionInfo();
        }

        // Función para iniciar selección por arrastre
        function startSelection(element) {
            if (element.dataset.disponible === 'false') {
                return;
            }
            
            // Verificar fecha
            const fecha = element.dataset.fecha;
            const fechaSeleccionada = new Date(fecha);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            if (fechaSeleccionada < hoy) {
                return;
            }
            
            isSelecting = true;
            startSlot = element;
            currentDate = fecha;
            currentAula = element.dataset.aulaId;
            
            // Limpiar selección anterior si es diferente fecha/aula
            if (selectedSlots.size > 0) {
                const firstSelected = document.querySelector('.slot-selected');
                if (firstSelected && 
                    (firstSelected.dataset.fecha !== fecha || 
                     firstSelected.dataset.aulaId !== currentAula)) {
                    clearSelection();
                }
            }
            
            // Seleccionar el slot inicial
            const slotKey = getSlotKey(element);
            if (!selectedSlots.has(slotKey)) {
                selectSlot(element);
                selectedSlots.add(slotKey);
            }
            
            updateSelectionInfo();
        }

        // Función para extender selección
        function extendSelection(element) {
            if (!isSelecting || !startSlot) return;
            if (element.dataset.disponible === 'false') return;
            if (element.dataset.fecha !== currentDate) return;
            if (element.dataset.aulaId !== currentAula) return;
            
            // Obtener rango de selección
            const startIndex = parseInt(startSlot.dataset.horarioIndex);
            const currentIndex = parseInt(element.dataset.horarioIndex);
            const diaIndex = parseInt(element.dataset.diaIndex);
            
            // Verificar que estamos en la misma columna (mismo día)
            if (parseInt(startSlot.dataset.diaIndex) !== diaIndex) return;
            
            // Limpiar selección temporal
            document.querySelectorAll('.slot-temp-selected').forEach(slot => {
                slot.classList.remove('slot-temp-selected');
                const content = slot.querySelector('.slot-content');
                if (content && content.classList.contains('modern-available')) {
                    content.classList.remove('bg-indigo-100', 'border-indigo-300');
                }
            });
            
            // Seleccionar rango
            const minIndex = Math.min(startIndex, currentIndex);
            const maxIndex = Math.max(startIndex, currentIndex);
            
            for (let i = minIndex; i <= maxIndex; i++) {
                const slot = document.querySelector(`[data-horario-index="${i}"][data-dia-index="${diaIndex}"]`);
                if (slot && slot.dataset.disponible === 'true') {
                    slot.classList.add('slot-temp-selected');
                    const content = slot.querySelector('.slot-content');
                    if (content && content.classList.contains('modern-available')) {
                        content.classList.add('bg-indigo-100', 'border-indigo-300');
                    }
                }
            }
        }

        // Función para finalizar selección
        function endSelection() {
            if (!isSelecting) return;
            
            // Confirmar selección temporal
            document.querySelectorAll('.slot-temp-selected').forEach(slot => {
                const slotKey = getSlotKey(slot);
                if (!selectedSlots.has(slotKey)) {
                    selectSlot(slot);
                    selectedSlots.add(slotKey);
                }
                slot.classList.remove('slot-temp-selected');
            });
            
            isSelecting = false;
            startSlot = null;
            updateSelectionInfo();
        }

        // Función para obtener clave única del slot
        function getSlotKey(element) {
            return `${element.dataset.fecha}-${element.dataset.horaInicio}-${element.dataset.aulaId}`;
        }

        // Función para seleccionar un slot
        function selectSlot(element) {
            console.log('Ejecutando selectSlot para:', element.dataset);
            element.classList.add('slot-selected');
            const content = element.querySelector('.slot-content');
            if (content) {
                content.className = 'slot-content modern-available';
                content.innerHTML = `
                    <div class="available-container bg-gradient-to-br from-violet-400 to-violet-600 border-2 border-violet-500 text-white">
                        <div class="available-icon">
                            <i class="fas fa-check text-xl"></i>
                        </div>
                        <div class="available-text">
                            <span class="text-xs font-semibold">Seleccionado</span>
                        </div>
                    </div>
                `;
                console.log('Slot marcado como seleccionado');
            } else {
                console.log('No se encontró .slot-content en el elemento');
            }
        }

        // Función para deseleccionar un slot
        function deselectSlot(element) {
            console.log('Ejecutando deselectSlot para:', element.dataset);
            element.classList.remove('slot-selected');
            const content = element.querySelector('.slot-content');
            if (content) {
                content.className = 'slot-content modern-available';
                content.innerHTML = `
                    <div class="available-container">
                        <div class="available-icon">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                        <div class="available-text">
                            <span class="text-xs font-semibold">Disponible</span>
                        </div>
                    </div>
                `;
                console.log('Slot marcado como disponible');
            } else {
                console.log('No se encontró .slot-content en el elemento');
            }
        }

        // Función para actualizar información de selección
        function updateSelectionInfo() {
            const selectionControls = document.getElementById('selection-controls');
            const selectionInfo = document.getElementById('selection-info');
            
            if (selectedSlots.size > 0) {
                selectionControls.classList.remove('hidden');
                selectionInfo.textContent = `${selectedSlots.size} hora${selectedSlots.size > 1 ? 's' : ''} seleccionada${selectedSlots.size > 1 ? 's' : ''}`;
            } else {
                selectionControls.classList.add('hidden');
            }
        }

        // Función para limpiar selección
        function clearSelection() {
            document.querySelectorAll('.slot-selected').forEach(slot => {
                deselectSlot(slot);
            });
            selectedSlots.clear();
            updateSelectionInfo();
        }

        // Función para confirmar selección
        function confirmSelection() {
            if (selectedSlots.size === 0) {
                alert('No hay horarios seleccionados');
                return;
            }
            
            // Obtener datos de los slots seleccionados
            const selectedElements = Array.from(document.querySelectorAll('.slot-selected'));
            const sortedElements = selectedElements.sort((a, b) => {
                const timeA = a.dataset.horaInicio;
                const timeB = b.dataset.horaInicio;
                return timeA.localeCompare(timeB);
            });
            
            // Verificar que todos los slots son del mismo día
            const fechas = [...new Set(sortedElements.map(el => el.dataset.fecha))];
            if (fechas.length > 1) {
                alert('Solo puedes reservar horarios del mismo día');
                return;
            }
            
            // Verificar que los horarios son consecutivos
            let isConsecutive = true;
            for (let i = 1; i < sortedElements.length; i++) {
                const prevHoraFin = sortedElements[i-1].dataset.horaFin;
                const currentHoraInicio = sortedElements[i].dataset.horaInicio;
                if (prevHoraFin !== currentHoraInicio) {
                    isConsecutive = false;
                    break;
                }
            }
            
            if (!isConsecutive) {
                alert('Los horarios seleccionados deben ser consecutivos');
                return;
            }
            
            // Obtener datos para la reserva
            const fecha = sortedElements[0].dataset.fecha;
            const horaInicio = sortedElements[0].dataset.horaInicio;
            const horaFin = sortedElements[sortedElements.length - 1].dataset.horaFin;
            const aulaId = sortedElements[0].dataset.aulaId;
            
            // Redirigir al formulario de reserva
            const url = `{{ route('reservas.create') }}?aula_id=${aulaId}&fecha=${fecha}&hora_inicio=${horaInicio}&hora_fin=${horaFin}`;
            window.location.href = url;
        }

        // Función para mostrar detalles de reserva
        function showReservaDetails(reservaId) {
            // Aquí podrías hacer una llamada AJAX para obtener los detalles
            // Por ahora, mostraré un placeholder
            const modal = document.getElementById('reserva-modal');
            const details = document.getElementById('reserva-details');
            
            details.innerHTML = `
                <div class="text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-600">Cargando detalles...</p>
                </div>
            `;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Simulación de carga (en producción, hacer llamada AJAX)
            setTimeout(() => {
                details.innerHTML = `
                    <div class="space-y-3">
                        <div>
                            <span class="font-semibold text-gray-700">Estado:</span>
                            <span class="ml-2 px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Aprobada</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700">Profesor:</span>
                            <span class="ml-2 text-gray-600">Información de reserva</span>
                        </div>
                        <div class="pt-4 border-t">
                            <p class="text-sm text-gray-500">Para ver más detalles, ve a la sección de reservas.</p>
                        </div>
                    </div>
                `;
            }, 1000);
        }

        // Función para cerrar modal
        function closeReservaModal() {
            const modal = document.getElementById('reserva-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Función para ir a la semana anterior
        function irSemanaAnterior() {
            const fechaInput = document.getElementById('fecha');
            const aulaInput = document.getElementById('aula_id');
            const fechaActual = new Date(fechaInput.value);
            const nuevaFecha = new Date(fechaActual);
            nuevaFecha.setDate(fechaActual.getDate() - 7);
            
            // Mostrar indicador de carga
            mostrarCargandoNavegacion('anterior');
            
            // Navegar manualmente
            const url = new URL(window.location.href);
            url.searchParams.set('fecha', nuevaFecha.toISOString().split('T')[0]);
            url.searchParams.set('aula_id', aulaInput.value);
            window.location.href = url.toString();
        }

        // Función para ir a la semana siguiente
        function irSemanaSiguiente() {
            const fechaInput = document.getElementById('fecha');
            const aulaInput = document.getElementById('aula_id');
            const fechaActual = new Date(fechaInput.value);
            const nuevaFecha = new Date(fechaActual);
            nuevaFecha.setDate(fechaActual.getDate() + 7);
            
            // Mostrar indicador de carga
            mostrarCargandoNavegacion('siguiente');
            
            // Navegar manualmente
            const url = new URL(window.location.href);
            url.searchParams.set('fecha', nuevaFecha.toISOString().split('T')[0]);
            url.searchParams.set('aula_id', aulaInput.value);
            window.location.href = url.toString();
        }

        // Función para ir al día de hoy
        function irHoy() {
            const fechaInput = document.getElementById('fecha');
            const aulaInput = document.getElementById('aula_id');
            const hoy = new Date();
            
            // Solo cambiar si no estamos ya en la semana actual
            const fechaActual = new Date(fechaInput.value);
            const inicioSemanaActual = new Date(hoy);
            inicioSemanaActual.setDate(hoy.getDate() - hoy.getDay() + 1); // Lunes de esta semana
            
            const inicioSemanaSeleccionada = new Date(fechaActual);
            inicioSemanaSeleccionada.setDate(fechaActual.getDate() - fechaActual.getDay() + 1);
            
            if (Math.abs(inicioSemanaActual.getTime() - inicioSemanaSeleccionada.getTime()) > 86400000) { // Diferencia mayor a 1 día
                // Mostrar indicador de carga
                mostrarCargandoNavegacion('hoy');
                
                // Navegar manualmente
                const url = new URL(window.location.href);
                url.searchParams.set('fecha', hoy.toISOString().split('T')[0]);
                url.searchParams.set('aula_id', aulaInput.value);
                window.location.href = url.toString();
            } else {
                // Ya estamos en la semana actual, mostrar mensaje
                mostrarMensajeTemporario('Ya estás viendo la semana actual');
            }
        }

        // Función para mostrar indicador de carga en navegación
        function mostrarCargandoNavegacion(tipo) {
            const botones = {
                'anterior': document.querySelector('button[onclick="irSemanaAnterior()"]'),
                'siguiente': document.querySelector('button[onclick="irSemanaSiguiente()"]'),
                'hoy': document.querySelector('button[onclick="irHoy()"]')
            };
            
            Object.values(botones).forEach(btn => {
                if (btn) {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
            
            const botonActivo = botones[tipo];
            if (botonActivo) {
                const icon = botonActivo.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
                const span = botonActivo.querySelector('span');
                if (span) {
                    span.textContent = 'Cargando...';
                }
            }
        }

        // Función para mostrar mensaje temporal
        function mostrarMensajeTemporario(mensaje) {
            const div = document.createElement('div');
            div.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            div.textContent = mensaje;
            
            document.body.appendChild(div);
            
            setTimeout(() => {
                div.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => {
                    document.body.removeChild(div);
                }, 300);
            }, 2000);
        }

        // Función para actualizar el reloj
        function actualizarReloj() {
            const elemento = document.getElementById('fecha-actual');
            if (elemento) {
                const ahora = new Date();
                elemento.textContent = ahora.toLocaleString('es-PE', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        }

        // Actualizar reloj cada minuto
        setInterval(actualizarReloj, 60000);

        // Eventos del documento - solo para finalizar selección por arrastre
        document.addEventListener('mouseup', function(e) {
            if (!e.target.closest('.slot-cell')) {
                endSelection();
            }
        });
        
        document.addEventListener('mouseleave', endSelection);

        // Event listeners para los slots del calendario
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, configurando event listeners...');
            
            // Agregar event listeners a todos los slots
            const slots = document.querySelectorAll('.slot-cell');
            console.log('Encontrados', slots.length, 'slots');
            
            slots.forEach((slot, index) => {
                console.log('Configurando slot', index, slot.dataset);
                
                // Click simple - método más directo
                slot.addEventListener('click', function(e) {
                    console.log('EVENT: Click detectado en slot', this.dataset.fecha, this.dataset.horaInicio);
                    handleSlotClick(this);
                });
                
                // Prevenir menú contextual
                slot.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                });
                
                // Prevenir selección de texto
                slot.addEventListener('selectstart', function(e) {
                    e.preventDefault();
                });
            });
            
            console.log('Event listeners configurados para', slots.length, 'slots');
        });

        // Cerrar modal con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeReservaModal();
            }
        });

        // Actualizar calendario automáticamente
        let ultimaActualizacion = Date.now();
        let actualizando = false;
        
        setInterval(function() {
            if (document.visibilityState === 'visible' && 
                selectedSlots.size === 0 && 
                !actualizando &&
                Date.now() - ultimaActualizacion > 60000) {
                ultimaActualizacion = Date.now();
                actualizarCalendario();
            }
        }, 30000);

        // Función para actualizar el calendario sin recargar toda la página
        function actualizarCalendario() {
            if (actualizando) return;
            
            const aulaId = document.getElementById('aula_id').value;
            const fecha = document.getElementById('fecha').value;
            
            if (!aulaId || !fecha) return;
            
            actualizando = true;
            
            // Mostrar indicador de carga
            const botonActualizar = document.querySelector('button[onclick="actualizarCalendario()"]');
            const iconoOriginal = botonActualizar.querySelector('i').className;
            botonActualizar.disabled = true;
            botonActualizar.querySelector('i').className = 'fas fa-spinner fa-spin';
            
            fetch(`/api/calendario/datos?aula_id=${aulaId}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        actualizarCeldasCalendario(data.reservas);
                        // Mostrar mensaje de éxito temporal
                        const span = botonActualizar.querySelector('span');
                        if (span) {
                            const textoOriginal = span.textContent;
                            span.textContent = 'Actualizado';
                            setTimeout(() => {
                                span.textContent = textoOriginal;
                            }, 2000);
                        }
                    } else {
                        console.error('Error en la respuesta:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error actualizando calendario:', error);
                    alert('Error al actualizar el calendario');
                })
                .finally(() => {
                    actualizando = false;
                    botonActualizar.disabled = false;
                    botonActualizar.querySelector('i').className = iconoOriginal;
                });
        }
        
        // Función para actualizar las celdas del calendario
        function actualizarCeldasCalendario(reservas) {
            // Limpiar todas las celdas ocupadas
            document.querySelectorAll('.modern-slot[data-disponible="false"]').forEach(cell => {
                cell.setAttribute('data-disponible', 'true');
                const content = cell.querySelector('.slot-content');
                if (content) {
                    content.className = 'slot-content modern-available';
                    content.innerHTML = `
                        <div class="available-container">
                            <div class="available-icon">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <div class="available-text">
                                <span class="text-xs font-semibold">Disponible</span>
                            </div>
                        </div>
                    `;
                    content.title = 'Disponible - Click para reservar';
                }
            });
            
            // Aplicar nuevas reservas
            reservas.forEach(reserva => {
                const celda = document.querySelector(`[data-fecha="${reserva.fecha}"][data-hora-inicio="${reserva.hora_inicio}"]`);
                if (celda) {
                    celda.setAttribute('data-disponible', 'false');
                    
                    let colorClass = 'from-emerald-400 to-emerald-600';
                    let iconClass = 'fas fa-check';
                    
                    switch(reserva.estado) {
                        case 'pendiente':
                            colorClass = 'from-amber-400 to-amber-600';
                            iconClass = 'fas fa-clock';
                            break;
                        case 'cancelada':
                            colorClass = 'from-slate-400 to-slate-600';
                            iconClass = 'fas fa-ban';
                            break;
                        case 'rechazada':
                            colorClass = 'from-rose-400 to-rose-600';
                            iconClass = 'fas fa-times';
                            break;
                    }
                    
                    const content = celda.querySelector('.slot-content');
                    if (content) {
                        content.className = 'slot-content modern-occupied';
                        content.innerHTML = `
                            <div class="occupied-container bg-gradient-to-br ${colorClass} text-white">
                                <div class="occupied-header">
                                    <div class="text-xs font-bold truncate">${reserva.profesor.substring(0, 10)}</div>
                                    ${reserva.es_asignacion ? '<i class="fas fa-calendar-check text-xs opacity-80" title="Asignación administrativa"></i>' : ''}
                                </div>
                                <div class="occupied-body">
                                    <div class="text-xs opacity-90 truncate">${reserva.motivo ? reserva.motivo.substring(0, 15) : ''}</div>
                                </div>
                                <div class="occupied-footer">
                                    <i class="${iconClass} text-xs" title="${reserva.estado}"></i>
                                </div>
                            </div>
                        `;
                        content.title = `${reserva.es_asignacion ? 'Asignación: ' : 'Reserva: '}${reserva.profesor} - ${reserva.estado}`;
                        content.onclick = function(e) {
                            e.stopPropagation();
                            showReservaDetails(reserva.id);
                        };
                    }
                }
            });
            
            // Agregar efecto de actualización
            const grid = document.querySelector('.modern-calendar-grid');
            if (grid) {
                grid.classList.add('pulse');
                setTimeout(() => {
                    grid.classList.remove('pulse');
                }, 2000);
            }
        }
    </script>

    <!-- Estilos ultra modernos -->
    <style>
        /* Variables CSS personalizadas */
        :root {
            --primary-blue: #3b82f6;
            --primary-indigo: #6366f1;
            --primary-purple: #8b5cf6;
            --primary-emerald: #10b981;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.3);
            --shadow-light: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-heavy: 0 20px 25px rgba(0, 0, 0, 0.1);
            --blur-light: blur(8px);
            --blur-medium: blur(12px);
            --blur-heavy: blur(16px);
        }

        /* CALENDARIO GRID - DISEÑO ULTRA MODERNO */
        .modern-calendar-grid {
            display: grid;
            grid-template-columns: 120px repeat(7, 1fr);
            gap: 8px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            backdrop-filter: blur(10px);
            padding: 24px;
            border-radius: 32px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
        }

        .calendar-header-row {
            display: contents;
        }

        .calendar-time-row {
            display: contents;
        }

        .time-header-cell {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(148, 163, 184, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 80px;
            position: relative;
            overflow: hidden;
        }

        .time-header-cell:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .time-slot-cell {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(148, 163, 184, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 80px;
            position: relative;
            overflow: hidden;
        }

        .time-slot-cell:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .day-header-cell {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(148, 163, 184, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 80px;
            position: relative;
            overflow: hidden;
        }

        .day-header-cell:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        }

        .header-content {
            text-align: center;
            padding: 16px;
        }

        .time-content {
            text-align: center;
            padding: 16px;
        }

        /* Efectos glassmorphism */
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: var(--blur-medium);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-medium);
        }

        /* Slot del calendario - DISEÑO COMPLETAMENTE NUEVO */
        .modern-slot {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            min-height: 80px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .modern-slot:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px) scale(1.02);
        }
        
        .modern-slot.slot-selected {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 2px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 8px 24px rgba(147, 51, 234, 0.25);
        }
        
        .modern-slot.slot-temp-selected {
            background: linear-gradient(135deg, rgba(147, 51, 234, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
            border: 2px solid rgba(147, 51, 234, 0.25) !important;
            box-shadow: 0 4px 16px rgba(147, 51, 234, 0.15);
        }
        
        /* Contenido del slot moderno */
        .slot-content {
            width: 100%;
            height: 100%;
            min-height: 56px;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modern-available {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: 2px solid rgba(59, 130, 246, 0.3);
            color: white;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .modern-available:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px) scale(1.02);
        }

        .available-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 8px;
        }

        .available-icon {
            margin-bottom: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .available-text {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-available:hover .available-icon {
            transform: scale(1.1);
        }

        .modern-available:hover .available-text {
            transform: scale(1.05);
        }

        .modern-occupied {
            cursor: pointer;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-occupied:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .occupied-container {
            width: 100%;
            height: 100%;
            padding: 12px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 56px;
            position: relative;
            overflow: hidden;
        }

        .occupied-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }

        .occupied-body {
            flex: 1;
            display: flex;
            align-items: center;
            margin: 2px 0;
        }

        .occupied-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 2px;
        }
        
        .slot-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        
        .slot-content:hover::before {
            transform: translateX(100%);
        }
        
        .slot-selected .slot-content {
            transform: scale(0.98);
            box-shadow: 0 8px 20px rgba(147, 51, 234, 0.3);
        }
        
        /* Botones con efectos modernos */
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }
        
        .btn-modern:hover::before {
            transform: translateX(100%);
        }
        
        /* Animaciones suaves */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { 
                opacity: 1;
                transform: scale(1);
            }
            50% { 
                opacity: 0.8;
                transform: scale(1.05);
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }
            100% {
                background-position: calc(200px + 100%) 0;
            }
        }
        
        /* Efectos de entrada */
        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .slide-in {
            animation: slideInRight 0.8s ease-out forwards;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 0%, #e0e0e0 50%, #f0f0f0 100%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
        
        /* Mejoras en gradientes */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Efectos de hover avanzados */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive mejorado para el nuevo grid ultra moderno */
        @media (max-width: 1280px) {
            .modern-calendar-grid {
                grid-template-columns: 100px repeat(7, 1fr);
                gap: 6px;
                padding: 20px;
            }
            
            .modern-slot {
                min-height: 72px;
                padding: 10px;
            }
            
            .slot-content {
                min-height: 52px;
            }
            
            .time-header-cell,
            .time-slot-cell,
            .day-header-cell {
                min-height: 72px;
            }
            
            .header-content,
            .time-content {
                padding: 12px;
            }
        }
        
        @media (max-width: 1024px) {
            .modern-calendar-grid {
                grid-template-columns: 90px repeat(7, 1fr);
                gap: 4px;
                padding: 16px;
            }
            
            .modern-slot {
                min-height: 64px;
                padding: 8px;
            }
            
            .slot-content {
                font-size: 0.875rem;
                min-height: 48px;
            }
            
            .time-header-cell,
            .time-slot-cell,
            .day-header-cell {
                min-height: 64px;
                font-size: 0.875rem;
            }
            
            .header-content,
            .time-content {
                padding: 10px;
            }
            
            .occupied-container {
                padding: 8px;
            }
        }
        
        @media (max-width: 768px) {
            .modern-calendar-grid {
                grid-template-columns: 80px repeat(7, 1fr);
                gap: 3px;
                padding: 12px;
            }
            
            .modern-slot {
                min-height: 56px;
                padding: 6px;
            }
            
            .slot-content {
                font-size: 0.8rem;
                min-height: 44px;
            }
            
            .time-header-cell,
            .time-slot-cell,
            .day-header-cell {
                min-height: 56px;
                font-size: 0.8rem;
            }
            
            .header-content,
            .time-content {
                padding: 8px;
            }
            
            .occupied-container {
                padding: 6px;
            }
        }
        
        @media (max-width: 640px) {
            .modern-calendar-grid {
                grid-template-columns: 70px repeat(7, 1fr);
                gap: 2px;
                padding: 8px;
            }
            
            .modern-slot {
                min-height: 48px;
                padding: 4px;
            }
            
            .slot-content {
                font-size: 0.75rem;
                min-height: 40px;
            }
            
            .time-header-cell,
            .time-slot-cell,
            .day-header-cell {
                min-height: 48px;
                font-size: 0.75rem;
            }
            
            .header-content,
            .time-content {
                padding: 6px;
            }
            
            .occupied-container {
                padding: 4px;
            }
        }

        /* Estados de carga */
        .loading {
            opacity: 0.7;
            pointer-events: none;
            position: relative;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid var(--primary-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Efectos de estado */
        .status-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .status-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }
        
        .status-error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .status-info {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-indigo) 100%);
            color: white;
        }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-indigo), var(--primary-purple));
        }

        /* Mejoras en accesibilidad */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Focus visible mejorado */
        .focus-visible:focus {
            outline: 2px solid var(--primary-blue);
            outline-offset: 2px;
        }
        
        /* Mejoras en el modal */
        .modal-backdrop {
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.4);
        }
        
        /* Efectos de selección */
        .selection-highlight {
            background: linear-gradient(135deg, 
                rgba(147, 51, 234, 0.1) 0%, 
                rgba(139, 92, 246, 0.1) 100%);
            border: 2px solid rgba(147, 51, 234, 0.3);
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2);
        }
        
        /* Mejoras en los iconos */
        .icon-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                transform: translate3d(0, -8px, 0);
            }
            70% {
                animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                transform: translate3d(0, -4px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }
    </style>
</x-app-layout>
