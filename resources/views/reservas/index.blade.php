<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Reservas') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Lista de Reservas</h3>
                        <a href="{{ route('reservas.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            Nueva Reserva
                        </a>
                    </div>

                    @if($reservas->isEmpty())
                        <p class="text-gray-500 text-center py-8">No tienes reservas aún.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aula
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fecha
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Horario
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Motivo
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservas as $reserva)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $reserva->aula->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $reserva->aula->codigo }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $reserva->fecha->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $reserva->hora_inicio->format('H:i') }} - {{ $reserva->hora_fin->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $reserva->motivo }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                                    @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                                    @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                                    @elseif($reserva->estado === 'cancelada') bg-gray-100 text-gray-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($reserva->estado) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('reservas.show', $reserva) }}" class="text-blue-600 hover:text-blue-900">
                                                    Ver
                                                </a>
                                                @if($reserva->estado === 'pendiente')
                                                    <a href="{{ route('reservas.edit', $reserva) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        Editar
                                                    </a>
                                                @endif
                                                @if(in_array($reserva->estado, ['pendiente', 'aprobada']))
                                                    <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900 hover:bg-red-50 px-2 py-1 rounded transition-colors duration-200" onclick="return confirmarCancelacion(event, '{{ $reserva->aula->nombre }}', '{{ $reserva->fecha }}', '{{ $reserva->hora_inicio }}', '{{ $reserva->hora_fin }}')">
                                                            <i class="fas fa-times mr-1"></i>
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $reservas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarCancelacion(event, aula, fecha, horaInicio, horaFin) {
            event.preventDefault();
            
            const mensaje = `¿Estás seguro de cancelar la reserva?\n\nDetalles:\n` +
                          `• Aula: ${aula}\n` +
                          `• Fecha: ${fecha}\n` +
                          `• Horario: ${horaInicio} - ${horaFin}\n\n` +
                          `Esta acción no se puede deshacer.`;
            
            if (confirm(mensaje)) {
                // Mostrar indicador de carga
                event.target.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Cancelando...';
                event.target.disabled = true;
                
                // Enviar formulario
                event.target.closest('form').submit();
            }
            
            return false;
        }
    </script>
</x-app-layout>
