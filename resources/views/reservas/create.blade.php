<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva - Sistema de Reservas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
        }
        .glass-modern {
            background: rgba(255,255,255,0.85);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.25);
        }
        .modern-gradient-text {
            background: linear-gradient(90deg, #6366f1 0%, #a21caf 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .modern-btn {
            background: linear-gradient(90deg, #6366f1 0%, #a21caf 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 2px 8px 0 rgba(99,102,241,0.10);
        }
        .modern-btn:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 24px 0 rgba(99,102,241,0.18);
        }
        .modern-input, .modern-select, .modern-textarea {
            background: rgba(243,244,246,0.7);
            border: 1.5px solid #e0e7ff;
            border-radius: 1rem;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
            border-color: #a21caf;
            box-shadow: 0 0 0 2px #a21caf33;
        }
        .modern-label {
            font-weight: 600;
            color: #3730a3;
            letter-spacing: 0.01em;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-3xl mx-auto">
            <!-- Encabezado -->
            <div class="text-center mb-10">
                <h1 class="text-5xl font-extrabold modern-gradient-text mb-3 tracking-tight drop-shadow-lg">
                    ✨ Crear Nueva Reserva
                </h1>
                <p class="text-gray-500 text-lg font-medium">
                    Sistema de Reservas de Aulas
                </p>
            </div>

            <!-- Errores -->
            @if($errors->any())
                <div class="bg-red-100/80 border border-red-300 rounded-2xl p-5 mb-7 shadow-md flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 mt-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-1">Corrige los siguientes errores:</h3>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Tarjeta del formulario -->
            <div class="glass-modern p-10 shadow-2xl">
                <form method="POST" action="{{ route('reservas.store') }}" class="space-y-7">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                        <!-- Aula -->
                        <div>
                            <label for="aula_id" class="modern-label block mb-2">
                                🏫 Aula
                            </label>
                            <select id="aula_id" name="aula_id" required class="modern-select w-full px-4 py-3 focus:outline-none">
                                <option value="">Seleccione un aula</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ (old('aula_id', $aulaSeleccionada ?? '') == $aula->id) ? 'selected' : '' }}>
                                        {{ $aula->nombre }} ({{ $aula->codigo }}) - Capacidad: {{ $aula->capacidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div>
                            <label for="fecha" class="modern-label block mb-2">
                                📅 Fecha
                            </label>
                            <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $fechaSeleccionada ?? '') }}" min="{{ date('Y-m-d') }}" required class="modern-input w-full px-4 py-3 focus:outline-none">
                        </div>

                        <!-- Hora de inicio -->
                        <div>
                            <label for="hora_inicio" class="modern-label block mb-2">
                                🕐 Hora de Inicio
                            </label>
                            <select id="hora_inicio" name="hora_inicio" required class="modern-select w-full px-4 py-3 focus:outline-none">
                                <option value="">Seleccionar hora</option>
                                @for($hora = 8; $hora <= 18; $hora++)
                                    @php
                                        $horaFormateada = sprintf('%02d:00', $hora);
                                    @endphp
                                    <option value="{{ $horaFormateada }}" {{ old('hora_inicio', $horaInicioSeleccionada ?? '') == $horaFormateada ? 'selected' : '' }}>
                                        {{ $horaFormateada }} - {{ sprintf('%02d:00', $hora + 1) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Hora de fin -->
                        <div>
                            <label for="hora_fin" class="modern-label block mb-2">
                                🕐 Hora de Fin
                            </label>
                            <select id="hora_fin" name="hora_fin" required class="modern-select w-full px-4 py-3 focus:outline-none">
                                <option value="">Seleccionar hora</option>
                                @for($hora = 9; $hora <= 19; $hora++)
                                    @php
                                        $horaFormateada = sprintf('%02d:00', $hora);
                                    @endphp
                                    <option value="{{ $horaFormateada }}" {{ old('hora_fin', $horaFinSeleccionada ?? '') == $horaFormateada ? 'selected' : '' }}>
                                        {{ $horaFormateada }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Motivo -->
                        <div class="md:col-span-2">
                            <label for="motivo" class="modern-label block mb-2">
                                📝 Motivo de la Reserva
                            </label>
                            <input type="text" id="motivo" name="motivo" value="{{ old('motivo') }}" required placeholder="Ej: Clase de Matemáticas, Reunión de departamento, etc." class="modern-input w-full px-4 py-3 focus:outline-none">
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <label for="observaciones" class="modern-label block mb-2">
                                💭 Observaciones (Opcional)
                            </label>
                            <textarea id="observaciones" name="observaciones" rows="3" placeholder="Información adicional sobre la reserva..." class="modern-textarea w-full px-4 py-3 focus:outline-none resize-none">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-7 border-t border-gray-200/60">
                        <a href="{{ route('calendario.index') }}" class="flex-1 px-6 py-3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Volver al Calendario
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 modern-btn rounded-xl shadow-lg">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Actualizar hora de fin automáticamente
        document.getElementById('hora_inicio').addEventListener('change', function() {
            const horaInicio = this.value;
            const horaFin = document.getElementById('hora_fin');
            
            if (horaInicio && (!horaFin.value || isAutoGenerated(horaInicio, horaFin.value))) {
                const hora = parseInt(horaInicio.split(':')[0]);
                const horaFinFormateada = String(hora + 1).padStart(2, '0') + ':00';
                
                for (let option of horaFin.options) {
                    if (option.value === horaFinFormateada) {
                        option.selected = true;
                        break;
                    }
                }
            }
        });

        function isAutoGenerated(horaInicio, horaFin) {
            const horaInicioNum = parseInt(horaInicio.split(':')[0]);
            const horaFinNum = parseInt(horaFin.split(':')[0]);
            return horaFinNum === horaInicioNum + 1;
        }

        // Información adicional sobre la selección múltiple
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const horaInicio = urlParams.get('hora_inicio');
            const horaFin = urlParams.get('hora_fin');
            
            if (horaInicio && horaFin) {
                const horaInicioNum = parseInt(horaInicio.split(':')[0]);
                const horaFinNum = parseInt(horaFin.split(':')[0]);
                const duracion = horaFinNum - horaInicioNum;
                
                if (duracion > 1) {
                    const form = document.querySelector('form');
                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'bg-gradient-to-r from-indigo-100 to-fuchsia-100 border border-indigo-200 rounded-2xl p-6 mb-7 shadow-lg';
                    infoDiv.innerHTML = `
                        <div class="flex items-center">
                            <div class="bg-gradient-to-r from-indigo-500 to-fuchsia-500 rounded-full p-2 mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Reserva de múltiples horas</h3>
                                <p class="text-gray-600 mt-1">
                                    Has seleccionado <strong>${duracion} horas consecutivas</strong> (${horaInicio} - ${horaFin})
                                </p>
                            </div>
                        </div>
                    `;
                    form.parentNode.insertBefore(infoDiv, form);
                }
            }
        });
    </script>
</body>
</html>
