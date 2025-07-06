<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Reserva - Sistema Ultra Moderno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">
                    📋 Detalle de Reserva
                </h1>
                <p class="text-xl text-white opacity-90">
                    Información completa de tu reserva
                </p>
            </div>

            <!-- Contenido principal -->
            <div class="glass-effect rounded-3xl p-8 card-shadow">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información básica -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">
                            🏢 Información de la Reserva
                        </h2>
                        
                        <div class="bg-white bg-opacity-70 rounded-2xl p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">AULA</label>
                                <p class="text-lg font-medium text-gray-900">{{ $reserva->aula->nombre ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Código: {{ $reserva->aula->codigo ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">FECHA</label>
                                <p class="text-lg font-medium text-gray-900">{{ $reserva->fecha->format('d/m/Y') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">HORARIO</label>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ date('H:i', strtotime($reserva->hora_inicio)) }} - {{ date('H:i', strtotime($reserva->hora_fin)) }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">ESTADO</label>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                    @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                    @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                    @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                    @elseif($reserva->estado === 'cancelada') bg-gray-100 text-gray-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">
                            📝 Información Adicional
                        </h2>
                        
                        <div class="bg-white bg-opacity-70 rounded-2xl p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">MOTIVO</label>
                                <p class="text-gray-900">{{ $reserva->motivo }}</p>
                            </div>
                            
                            @if($reserva->observaciones)
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">OBSERVACIONES</label>
                                    <p class="text-gray-900">{{ $reserva->observaciones }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">SOLICITADO POR</label>
                                <p class="text-gray-900">{{ $reserva->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">FECHA DE SOLICITUD</label>
                                <p class="text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('reservas.index') }}" 
                   class="flex items-center justify-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-xl transition-all duration-200 hover-scale">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Mis Reservas
                </a>
                
                @if($reserva->estado === 'pendiente')
                    <a href="{{ route('reservas.edit', $reserva) }}" 
                       class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 hover-scale">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Reserva
                    </a>
                @endif
                
                @if(in_array($reserva->estado, ['pendiente', 'aprobada']))
                    <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition-all duration-200 hover-scale"
                                onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancelar Reserva
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
