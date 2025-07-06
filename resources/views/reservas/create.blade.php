<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva - Sistema de Reservas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos ultra modernos inspirados en el calendario */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .ultra-modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 2rem;
        }
        
        .modern-gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .modern-input, .modern-select, .modern-textarea {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 0.95);
            outline: none;
        }
        
        .modern-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .modern-label-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }
        
        .modern-btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 1rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(59, 130, 246, 0.4);
        }
        
        .modern-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .modern-btn-primary:hover::before {
            left: 100%;
        }
        
        .modern-btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #64748b;
            font-weight: 600;
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 1rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .modern-btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .error-card {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fca5a5;
            border-radius: 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .info-card {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #93c5fd;
            border-radius: 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Gradientes para iconos */
        .icon-building { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .icon-calendar { background: linear-gradient(135deg, #10b981, #059669); }
        .icon-clock { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .icon-edit { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .icon-comment { background: linear-gradient(135deg, #06b6d4, #0891b2); }
    </style>
</head>
<body class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado ultra moderno -->
            <div class="text-center mb-12 slide-in">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-6 floating-animation">
                    <i class="fas fa-plus-circle text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl font-bold modern-gradient-text mb-4 tracking-tight">
                    Nueva Reserva
                </h1>
                <p class="text-gray-600 text-lg font-medium">
                    Sistema de Reservas de Aulas Académicas
                </p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mt-4"></div>
            </div>

            <!-- Mensajes de error ultra modernos -->
            @if($errors->any())
                <div class="mb-8 slide-in">
                    <div class="error-card p-6 shadow-lg">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-red-800 mb-2">Errores de Validación</h3>
                                <p class="text-red-600 text-sm mb-3">Por favor corrige los siguientes errores:</p>
                                <ul class="text-red-700 text-sm space-y-2">
                                    @foreach($errors->all() as $error)
                                        <li class="flex items-center gap-2">
                                            <i class="fas fa-dot-circle text-red-500 text-xs"></i>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario ultra moderno -->
            <div class="ultra-modern-card p-8 slide-in">
                <form method="POST" action="{{ route('reservas.store') }}" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Aula -->
                        <div class="space-y-3">
                            <label for="aula_id" class="modern-label">
                                <div class="modern-label-icon icon-building">
                                    <i class="fas fa-building"></i>
                                </div>
                                Aula
                            </label>
                            <select id="aula_id" name="aula_id" required class="modern-select w-full px-4 py-4">
                                <option value="">Seleccione un aula</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ (old('aula_id', $aulaSeleccionada ?? '') == $aula->id) ? 'selected' : '' }}>
                                        {{ $aula->nombre }} ({{ $aula->codigo }}) - Capacidad: {{ $aula->capacidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="space-y-3">
                            <label for="fecha" class="modern-label">
                                <div class="modern-label-icon icon-calendar">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                Fecha
                            </label>
                            <input type="date" id="fecha" name="fecha" value="{{ old('fecha', $fechaSeleccionada ?? '') }}" min="{{ date('Y-m-d') }}" required class="modern-input w-full px-4 py-4">
                        </div>

                        <!-- Hora de inicio -->
                        <div class="space-y-3">
                            <label for="hora_inicio" class="modern-label">
                                <div class="modern-label-icon icon-clock">
                                    <i class="fas fa-clock"></i>
                                </div>
                                Hora de Inicio
                            </label>
                            <select id="hora_inicio" name="hora_inicio" required class="modern-select w-full px-4 py-4">
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
                        <div class="space-y-3">
                            <label for="hora_fin" class="modern-label">
                                <div class="modern-label-icon icon-clock">
                                    <i class="fas fa-clock"></i>
                                </div>
                                Hora de Fin
                            </label>
                            <select id="hora_fin" name="hora_fin" required class="modern-select w-full px-4 py-4">
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
                        <div class="lg:col-span-2 space-y-3">
                            <label for="motivo" class="modern-label">
                                <div class="modern-label-icon icon-edit">
                                    <i class="fas fa-edit"></i>
                                </div>
                                Motivo de la Reserva
                            </label>
                            <input type="text" id="motivo" name="motivo" value="{{ old('motivo') }}" required placeholder="Ej: Clase de Matemáticas, Reunión de departamento, etc." class="modern-input w-full px-4 py-4">
                        </div>

                        <!-- Observaciones -->
                        <div class="lg:col-span-2 space-y-3">
                            <label for="observaciones" class="modern-label">
                                <div class="modern-label-icon icon-comment">
                                    <i class="fas fa-comment"></i>
                                </div>
                                Observaciones <span class="text-gray-500 font-normal">(Opcional)</span>
                            </label>
                            <textarea id="observaciones" name="observaciones" rows="4" placeholder="Información adicional sobre la reserva..." class="modern-textarea w-full px-4 py-4 resize-none">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>

                    <!-- Botones ultra modernos -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-gray-200/50">
                        <a href="{{ route('calendario.index') }}" class="modern-btn-secondary flex-1 text-center inline-flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i>
                            Volver al Calendario
                        </a>
                        <button type="submit" class="modern-btn-primary flex-1 inline-flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            Crear Reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Animaciones de entrada
        document.addEventListener('DOMContentLoaded', function() {
            // Aplicar animaciones de entrada con delay
            const elements = document.querySelectorAll('.slide-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
            });
        });

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
                    infoDiv.className = 'info-card p-6 mb-8 shadow-lg slide-in';
                    infoDiv.innerHTML = `
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-blue-800 mb-2">Reserva de Múltiples Horas</h3>
                                <p class="text-blue-700">
                                    Has seleccionado <strong>${duracion} horas consecutivas</strong> 
                                    <span class="text-blue-600 font-medium">(${horaInicio} - ${horaFin})</span>
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
