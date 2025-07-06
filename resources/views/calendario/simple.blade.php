<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Aulas - Prueba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Calendario de Aulas - Versión Básica</h1>
        
        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('calendario.index') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-64">
                    <label for="aula_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Seleccionar Aula
                    </label>
                    <select name="aula_id" id="aula_id" class="w-full border border-gray-300 rounded-md px-3 py-2" onchange="this.form.submit()">
                        @foreach($aulas as $aula)
                            <option value="{{ $aula->id }}" {{ $aulaSeleccionada && $aulaSeleccionada->id == $aula->id ? 'selected' : '' }}>
                                {{ $aula->nombre }} ({{ $aula->codigo }}) - Capacidad: {{ $aula->capacidad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 min-w-48">
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                        Semana
                    </label>
                    <input type="date" name="fecha" id="fecha" value="{{ $fechaCarbon->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" onchange="this.form.submit()">
                </div>

                <div class="flex gap-2">
                    <button type="button" onclick="cambiarSemana(-1)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        ← Anterior
                    </button>
                    <button type="button" onclick="cambiarSemana(1)" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Siguiente →
                    </button>
                </div>
            </form>
        </div>

        @if($aulaSeleccionada)
            <!-- Información del Aula -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $aulaSeleccionada->nombre }}</h3>
                        <p class="text-sm text-gray-600">{{ $aulaSeleccionada->descripcion }}</p>
                        <div class="mt-2 flex flex-wrap gap-2 text-sm">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                <i class="fas fa-users"></i> {{ $aulaSeleccionada->capacidad }} personas
                            </span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">
                                <i class="fas fa-map-marker-alt"></i> {{ $aulaSeleccionada->ubicacion }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Código</div>
                        <div class="text-lg font-semibold text-gray-900">{{ $aulaSeleccionada->codigo }}</div>
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Calendario Semanal - {{ $fechaCarbon->format('d M Y') }}
                    </h3>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-green-100 border border-green-200 rounded"></div>
                            <span>Disponible</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-indigo-200 border border-indigo-400 rounded"></div>
                            <span>Seleccionado</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-yellow-100 border border-yellow-300 rounded"></div>
                            <span>Pendiente</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-blue-100 border border-blue-300 rounded"></div>
                            <span>Aprobada</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 bg-red-100 border border-red-300 rounded"></div>
                            <span>Rechazada</span>
                        </div>
                    </div>
                </div>

                <!-- Controles de selección -->
                <div class="mb-4 p-4 bg-gray-50 rounded-lg hidden" id="selection-controls">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-700">Selección:</span>
                            <span id="selection-info" class="text-sm text-gray-600">0 horas seleccionadas</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="clearSelection()" class="text-sm text-gray-500 hover:text-gray-700">
                                Limpiar
                            </button>
                            <button type="button" onclick="confirmSelection()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                                Reservar Selección
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 p-2 bg-gray-50 text-left text-sm font-medium text-gray-700 w-24">
                                    Horario
                                </th>
                                @foreach($diasSemana as $dia)
                                    <th class="border border-gray-300 p-2 bg-gray-50 text-center text-sm font-medium text-gray-700">
                                        <div>{{ $dia['nombre'] }}</div>
                                        <div class="text-lg font-bold text-blue-600">{{ $dia['numero'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $dia['mes'] }}</div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($horarios as $horario)
                                <tr>
                                    <td class="border border-gray-300 p-2 bg-gray-50 text-sm font-medium text-gray-700 text-center">
                                        {{ $horario['display'] }}
                                    </td>
                                    @foreach($diasSemana as $dia)
                                        @php
                                            $reserva = $reservas->first(function($r) use ($dia, $horario) {
                                                return $r->fecha == $dia['fecha'] && 
                                                       $r->hora_inicio <= $horario['inicio'] && 
                                                       $r->hora_fin > $horario['inicio'];
                                            });
                                        @endphp
                                        <td class="border border-gray-300 p-1 h-20 cursor-pointer hover:bg-gray-50 transition slot-cell"
                                            data-fecha="{{ $dia['fecha'] }}"
                                            data-hora-inicio="{{ $horario['inicio'] }}"
                                            data-hora-fin="{{ $horario['fin'] }}"
                                            data-aula-id="{{ $aulaSeleccionada->id }}"
                                            data-horario-index="{{ $loop->parent->index }}"
                                            data-dia-index="{{ $loop->index }}"
                                            data-disponible="{{ $reserva ? 'false' : 'true' }}"
                                            onclick="handleSlotClick(this)">
                                            
                                            @if($reserva)
                                                <div class="h-full rounded p-2 text-white text-xs
                                                    {{ $reserva->estado == 'aprobada' ? 'bg-blue-500' : 
                                                       ($reserva->estado == 'pendiente' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                                    <div class="font-semibold truncate">
                                                        {{ $reserva->user->name }}
                                                    </div>
                                                    <div class="truncate">
                                                        {{ $reserva->motivo }}
                                                    </div>
                                                    <div class="text-xs opacity-75">
                                                        {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - 
                                                        {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="h-full rounded p-2 bg-green-50 border border-green-200 hover:bg-green-100 transition flex items-center justify-center slot-content">
                                                    <div class="text-green-600 text-center">
                                                        <i class="fas fa-plus text-lg"></i>
                                                        <div class="text-xs font-medium">Reservar</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Función básica para cambiar semana
        function cambiarSemana(direccion) {
            const fechaInput = document.getElementById('fecha');
            const fechaActual = new Date(fechaInput.value);
            const nuevaFecha = new Date(fechaActual);
            nuevaFecha.setDate(fechaActual.getDate() + (direccion * 7));
            
            fechaInput.value = nuevaFecha.toISOString().split('T')[0];
            document.querySelector('form').submit();
        }

        // Función básica para manejar clicks
        function handleSlotClick(element) {
            if (element.dataset.disponible === 'false') {
                alert('Este horario ya está reservado');
                return;
            }
            
            const fecha = element.dataset.fecha;
            const fechaSeleccionada = new Date(fecha);
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            
            if (fechaSeleccionada < hoy) {
                alert('No puedes reservar en fechas pasadas');
                return;
            }
            
            const url = `{{ route('reservas.create') }}?aula_id=${element.dataset.aulaId}&fecha=${fecha}&hora_inicio=${element.dataset.horaInicio}`;
            window.location.href = url;
        }

        // Funciones placeholder para selección múltiple
        function clearSelection() {
            console.log('Limpiar selección');
        }

        function confirmSelection() {
            console.log('Confirmar selección');
        }
    </script>
</body>
</html>
