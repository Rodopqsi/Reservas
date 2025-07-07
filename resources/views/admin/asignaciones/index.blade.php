<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asignación de Horarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Asignar Horarios a Profesores</h3>
                        <a href="{{ route('admin.asignaciones.show') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            Ver Asignaciones
                        </a>
                    </div>

                    <!-- Errores -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Mensajes de éxito -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mensaje informativo -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Esta función permite asignar horarios recurrentes a profesores</li>
                                        <li>Se crearán reservas automáticamente con estado "aprobada"</li>
                                        <li>Solo se pueden asignar horarios futuros</li>
                                        <li>Se verificará la disponibilidad antes de crear cada reserva</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.asignaciones.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Profesor -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">
                                    Profesor
                                </label>
                                <select name="user_id" id="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seleccione un profesor</option>
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->id }}" {{ old('user_id') == $profesor->id ? 'selected' : '' }}>
                                            {{ $profesor->name }} ({{ $profesor->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Aula -->
                            <div>
                                <label for="aula_id" class="block text-sm font-medium text-gray-700">
                                    Aula
                                </label>
                                <select name="aula_id" id="aula_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seleccione un aula</option>
                                    @foreach($aulas as $aula)
                                        <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                            {{ $aula->nombre }} ({{ $aula->codigo }}) - Capacidad: {{ $aula->capacidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha inicio -->
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">
                                    Fecha de Inicio
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Fecha fin -->
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">
                                    Fecha de Fin
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Días de la semana -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Días de la Semana
                                </label>
                                <div class="flex flex-wrap gap-4">
                                    @php
                                        $dias = [
                                            1 => 'Lunes',
                                            2 => 'Martes', 
                                            3 => 'Miércoles',
                                            4 => 'Jueves',
                                            5 => 'Viernes',
                                            6 => 'Sábado',
                                            7 => 'Domingo'
                                        ];
                                    @endphp
                                    @foreach($dias as $numero => $nombre)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="dias_semana[]" value="{{ $numero }}" 
                                                   {{ in_array($numero, old('dias_semana', [])) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $nombre }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hora inicio -->
                            <div>
                                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">
                                    Hora de Inicio
                                </label>
                                <select name="hora_inicio" id="hora_inicio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seleccionar hora</option>
                                    @for($hora = 8; $hora <= 18; $hora++)
                                        @php
                                            $horaFormateada = sprintf('%02d:00', $hora);
                                        @endphp
                                        <option value="{{ $horaFormateada }}" {{ old('hora_inicio') == $horaFormateada ? 'selected' : '' }}>
                                            {{ $horaFormateada }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Hora fin -->
                            <div>
                                <label for="hora_fin" class="block text-sm font-medium text-gray-700">
                                    Hora de Fin
                                </label>
                                <select name="hora_fin" id="hora_fin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seleccionar hora</option>
                                    @for($hora = 9; $hora <= 19; $hora++)
                                        @php
                                            $horaFormateada = sprintf('%02d:00', $hora);
                                        @endphp
                                        <option value="{{ $horaFormateada }}" {{ old('hora_fin') == $horaFormateada ? 'selected' : '' }}>
                                            {{ $horaFormateada }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Motivo -->
                            <div class="md:col-span-2">
                                <label for="motivo" class="block text-sm font-medium text-gray-700">
                                    Motivo de la Asignación
                                </label>
                                <input type="text" name="motivo" id="motivo" value="{{ old('motivo') }}" placeholder="Ej: Clases de Matemáticas - Semestre 2025-1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700">
                                    Observaciones (Opcional)
                                </label>
                                <textarea name="observaciones" id="observaciones" rows="3" placeholder="Información adicional sobre la asignación..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('observaciones') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                Crear Asignación
                            </button>
                        </div>
                    </form>

                    <!-- Información -->
                    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Información sobre las Asignaciones:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Las asignaciones se crean para el rango de fechas especificado</li>
                            <li>• Solo se crean reservas en los días de la semana seleccionados</li>
                            <li>• Las asignaciones se aprueban automáticamente</li>
                            <li>• Si hay conflictos, se reportarán al final del proceso</li>
                            <li>• Puede asignar horarios por semanas, meses o semestres completos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Actualizar fecha mínima de fin cuando cambie la fecha de inicio
        document.getElementById('fecha_inicio').addEventListener('change', function() {
            const fechaInicio = this.value;
            const fechaFin = document.getElementById('fecha_fin');
            fechaFin.min = fechaInicio;
            
            if (fechaFin.value && fechaFin.value < fechaInicio) {
                fechaFin.value = fechaInicio;
            }
            
            // Calcular y mostrar duración estimada
            calcularDuracionEstimada();
        });

        // Actualizar hora mínima de fin cuando cambie la hora de inicio
        document.getElementById('hora_inicio').addEventListener('change', function() {
            const horaInicio = this.value;
            const horaFin = document.getElementById('hora_fin');
            
            if (horaInicio) {
                // Agregar al menos 1 hora a la hora de inicio
                const [horas, minutos] = horaInicio.split(':');
                const nuevaHora = parseInt(horas) + 1;
                const horaMinima = `${nuevaHora.toString().padStart(2, '0')}:${minutos}`;
                horaFin.min = horaMinima;
                
                if (!horaFin.value || horaFin.value <= horaInicio) {
                    horaFin.value = horaMinima;
                }
            }
            
            calcularDuracionEstimada();
        });

        // Escuchar cambios en fecha fin y días seleccionados
        document.getElementById('fecha_fin').addEventListener('change', calcularDuracionEstimada);
        document.getElementById('hora_fin').addEventListener('change', calcularDuracionEstimada);
        
        // Escuchar cambios en checkboxes de días
        document.querySelectorAll('input[name="dias_semana[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', calcularDuracionEstimada);
        });

        function calcularDuracionEstimada() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = document.getElementById('fecha_fin').value;
            const horaInicio = document.getElementById('hora_inicio').value;
            const horaFin = document.getElementById('hora_fin').value;
            const diasSeleccionados = document.querySelectorAll('input[name="dias_semana[]"]:checked').length;
            
            if (fechaInicio && fechaFin && horaInicio && horaFin && diasSeleccionados > 0) {
                const inicio = new Date(fechaInicio);
                const fin = new Date(fechaFin);
                const diffTime = Math.abs(fin - inicio);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                const semanas = Math.ceil(diffDays / 7);
                const totalReservas = semanas * diasSeleccionados;
                
                // Calcular duración de cada reserva
                const [h1, m1] = horaInicio.split(':').map(Number);
                const [h2, m2] = horaFin.split(':').map(Number);
                const duracionMinutos = (h2 * 60 + m2) - (h1 * 60 + m1);
                const duracionHoras = duracionMinutos / 60;
                
                const resumen = `
                    <div class="mt-4 p-3 bg-gray-50 rounded-md">
                        <h5 class="font-medium text-gray-900 mb-2">Resumen de la asignación:</h5>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Período: ${diffDays} días (${semanas} semanas aprox.)</li>
                            <li>• Días por semana: ${diasSeleccionados}</li>
                            <li>• Duración por clase: ${duracionHoras} hora${duracionHoras !== 1 ? 's' : ''}</li>
                            <li>• <strong>Total de reservas a crear: ${totalReservas}</strong></li>
                        </ul>
                    </div>
                `;
                
                // Mostrar u ocultar resumen
                let resumenDiv = document.getElementById('resumen-asignacion');
                if (!resumenDiv) {
                    resumenDiv = document.createElement('div');
                    resumenDiv.id = 'resumen-asignacion';
                    document.querySelector('form').appendChild(resumenDiv);
                }
                resumenDiv.innerHTML = resumen;
            } else {
                const resumenDiv = document.getElementById('resumen-asignacion');
                if (resumenDiv) {
                    resumenDiv.remove();
                }
            }
        }

        // Prevenir envío del formulario si no se han seleccionado días
        document.querySelector('form').addEventListener('submit', function(e) {
            const diasSeleccionados = document.querySelectorAll('input[name="dias_semana[]"]:checked').length;
            if (diasSeleccionados === 0) {
                e.preventDefault();
                alert('Por favor, seleccione al menos un día de la semana.');
                return false;
            }
            
            // Confirmar si se van a crear muchas reservas
            const resumenDiv = document.getElementById('resumen-asignacion');
            if (resumenDiv) {
                const texto = resumenDiv.textContent;
                const match = texto.match(/Total de reservas a crear: (\d+)/);
                if (match && parseInt(match[1]) > 50) {
                    if (!confirm(`Se van a crear ${match[1]} reservas. ¿Está seguro de continuar?`)) {
                        e.preventDefault();
                        return false;
                    }
                }
            }
            if (horaInicio) {
                const hora = parseInt(horaInicio.split(':')[0]);
                const horaFinMinima = String(hora + 1).padStart(2, '0') + ':00';
                
                // Limpiar opciones previas
                for (let option of horaFin.options) {
                    option.disabled = false;
                }
                
                // Deshabilitar horas anteriores
                for (let option of horaFin.options) {
                    if (option.value && option.value <= horaInicio) {
                        option.disabled = true;
                    }
                }
                
                // Si la hora fin actual es inválida, seleccionar la siguiente disponible
                if (horaFin.value && horaFin.value <= horaInicio) {
                    horaFin.value = horaFinMinima;
                }
            }
        });
    </script>
</x-app-layout>
