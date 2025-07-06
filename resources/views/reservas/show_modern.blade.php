<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Reserva - Sistema de Reservas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold gradient-text mb-4">
                    📋 Detalle de Reserva
                </h1>
                <p class="text-gray-600 text-lg">
                    Información completa de tu reserva
                </p>
            </div>

            <!-- Tarjeta principal -->
            <div class="glass-effect rounded-3xl p-8 shadow-2xl mb-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Información de la Reserva -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">📝</span>
                            </div>
                            Información de la Reserva
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Aula:</span>
                                <p class="text-lg font-medium text-gray-900 mt-1">{{ $reserva->aula->nombre }} ({{ $reserva->aula->codigo }})</p>
                                <p class="text-sm text-gray-600">Capacidad: {{ $reserva->aula->capacidad }} personas</p>
                            </div>

                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Fecha:</span>
                                <p class="text-lg font-medium text-gray-900 mt-1">{{ $reserva->fecha->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->fecha->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
                            </div>

                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Horario:</span>
                                <p class="text-lg font-medium text-gray-900 mt-1">{{ date('H:i', strtotime($reserva->hora_inicio)) }} - {{ date('H:i', strtotime($reserva->hora_fin)) }}</p>
                                @php
                                    $inicio = \Carbon\Carbon::parse($reserva->hora_inicio);
                                    $fin = \Carbon\Carbon::parse($reserva->hora_fin);
                                    $duracion = $fin->diffInHours($inicio);
                                @endphp
                                <p class="text-sm text-gray-600">Duración: {{ $duracion }} {{ $duracion == 1 ? 'hora' : 'horas' }}</p>
                            </div>

                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Estado:</span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                        @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                        @elseif($reserva->estado === 'cancelada') bg-gray-100 text-gray-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        @if($reserva->estado === 'aprobada') ✅ Aprobada
                                        @elseif($reserva->estado === 'pendiente') ⏳ Pendiente
                                        @elseif($reserva->estado === 'rechazada') ❌ Rechazada
                                        @elseif($reserva->estado === 'cancelada') 🚫 Cancelada
                                        @else 📋 {{ ucfirst($reserva->estado) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if($reserva->estado === 'rechazada' && isset($reserva->razon_rechazo))
                                <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                    <span class="text-sm font-semibold text-red-600 uppercase tracking-wide">Razón del Rechazo:</span>
                                    <p class="text-red-700 mt-1">{{ $reserva->razon_rechazo }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Detalles Adicionales -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">💭</span>
                            </div>
                            Detalles Adicionales
                        </h2>

                        <div class="space-y-4">
                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Motivo:</span>
                                <p class="text-lg font-medium text-gray-900 mt-1">{{ $reserva->motivo }}</p>
                            </div>

                            @if($reserva->observaciones)
                                <div class="bg-white/50 rounded-xl p-4">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Observaciones:</span>
                                    <p class="text-gray-900 mt-1">{{ $reserva->observaciones }}</p>
                                </div>
                            @endif

                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Solicitado por:</span>
                                <p class="text-lg font-medium text-gray-900 mt-1">{{ $reserva->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->user->email }}</p>
                            </div>

                            <div class="bg-white/50 rounded-xl p-4">
                                <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Fecha de Solicitud:</span>
                                <p class="text-gray-900 mt-1">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-600">{{ $reserva->created_at->diffForHumans() }}</p>
                            </div>

                            @if(isset($reserva->aula->ubicacion))
                                <div class="bg-white/50 rounded-xl p-4">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Ubicación del Aula:</span>
                                    <p class="text-gray-900 mt-1">{{ $reserva->aula->ubicacion }}</p>
                                </div>
                            @endif

                            @if(isset($reserva->aula->descripcion))
                                <div class="bg-white/50 rounded-xl p-4">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Descripción del Aula:</span>
                                    <p class="text-gray-900 mt-1">{{ $reserva->aula->descripcion }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="glass-effect rounded-3xl p-6 shadow-2xl">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('reservas.index') }}" class="flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 hover-scale">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Volver a Mis Reservas
                    </a>
                    
                    @if($reserva->estado === 'pendiente')
                        <a href="{{ route('reservas.edit', $reserva) }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl transition-all duration-200 hover-scale shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Reserva
                        </a>
                    @endif
                    
                    @if(in_array($reserva->estado, ['pendiente', 'aprobada']))
                        <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}" class="inline">
                            @csrf
                            <button type="submit" class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-medium rounded-xl transition-all duration-200 hover-scale shadow-lg" onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar Reserva
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Añadir efectos de animación a los elementos
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.glass-effect');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Efecto de hover para los elementos de información
            const infoCards = document.querySelectorAll('.bg-white\\/50');
            infoCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html>
