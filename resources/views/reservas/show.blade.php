<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Reserva</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Aula:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->aula->nombre }} ({{ $reserva->aula->codigo }})</p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Fecha:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->fecha->format('d/m/Y') }}</p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Horario:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->hora_inicio->format('H:i') }} - {{ $reserva->hora_fin->format('H:i') }}</p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Motivo:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->motivo }}</p>
                                </div>

                                @if($reserva->observaciones)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Observaciones:</span>
                                        <p class="text-sm text-gray-900">{{ $reserva->observaciones }}</p>
                                    </div>
                                @endif

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Estado:</span>
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                                        @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                        @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </div>

                                @if($reserva->estado === 'rechazada' && $reserva->razon_rechazo)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Razón del Rechazo:</span>
                                        <p class="text-sm text-red-700">{{ $reserva->razon_rechazo }}</p>
                                    </div>
                                @endif

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Creada:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Aula</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Capacidad:</span>
                                    <p class="text-sm text-gray-900">{{ $reserva->aula->capacidad }} personas</p>
                                </div>

                                @if($reserva->aula->ubicacion)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Ubicación:</span>
                                        <p class="text-sm text-gray-900">{{ $reserva->aula->ubicacion }}</p>
                                    </div>
                                @endif

                                @if($reserva->aula->descripcion)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Descripción:</span>
                                        <p class="text-sm text-gray-900">{{ $reserva->aula->descripcion }}</p>
                                    </div>
                                @endif

                                @if($reserva->aula->equipamiento)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Equipamiento:</span>
                                        <div class="flex flex-wrap gap-2 mt-1">
                                            @foreach($reserva->aula->equipamiento as $equipo)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">{{ $equipo }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-3">
                        <a href="{{ route('reservas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                            Volver
                        </a>
                        @if($reserva->estado === 'pendiente')
                            <a href="{{ route('reservas.edit', $reserva) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                Editar
                            </a>
                        @endif
                        @if(in_array($reserva->estado, ['pendiente', 'aprobada']))
                            <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-200" onclick="return confirm('¿Estás seguro de cancelar esta reserva?')">
                                    Cancelar Reserva
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
