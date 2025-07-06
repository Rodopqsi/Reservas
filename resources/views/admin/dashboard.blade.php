<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
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

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $totalReservas }}</div>
                        <div class="text-gray-600">Total Reservas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $reservasPendientes }}</div>
                        <div class="text-gray-600">Pendientes</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $totalAulas }}</div>
                        <div class="text-gray-600">Total Aulas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $totalProfesores }}</div>
                        <div class="text-gray-600">Profesores</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Acciones rápidas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Gestión</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.reservas.index') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                Gestionar Reservas
                            </a>
                            <a href="{{ route('admin.aulas.index') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                Gestionar Aulas
                            </a>
                            <a href="{{ route('admin.aulas.create') }}" class="block w-full bg-purple-500 hover:bg-purple-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                Crear Nueva Aula
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reservas recientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Reservas Pendientes de Aprobación</h3>
                        @if($reservasRecientes->where('estado', 'pendiente')->isEmpty())
                            <p class="text-gray-500">No hay reservas pendientes de aprobación.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($reservasRecientes->where('estado', 'pendiente') as $reserva)
                                    <div class="border rounded-lg p-4 bg-yellow-50">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-medium">{{ $reserva->aula->nombre }} ({{ $reserva->aula->codigo }})</h4>
                                                <p class="text-sm text-gray-600">
                                                    <strong>Profesor:</strong> {{ $reserva->user->name }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <strong>Fecha:</strong> {{ $reserva->fecha->format('d/m/Y') }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <strong>Horario:</strong> {{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <strong>Motivo:</strong> {{ $reserva->motivo }}
                                                </p>
                                                @if($reserva->observaciones)
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Observaciones:</strong> {{ $reserva->observaciones }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="text-right ml-4">
                                                <div class="flex gap-2">
                                                    <form method="POST" action="{{ route('reservas.aprobar', $reserva) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                                            Aprobar
                                                        </button>
                                                    </form>
                                                    <button onclick="mostrarModalRechazo({{ $reserva->id }})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                        Rechazar
                                                    </button>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-2">
                                                    Solicitado {{ $reserva->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para rechazar reserva -->
    <div id="modalRechazo" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Rechazar Reserva</h3>
                <button onclick="cerrarModalRechazo()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="formRechazo" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="razon_rechazo" class="block text-sm font-medium text-gray-700 mb-2">
                        Razón del rechazo
                    </label>
                    <textarea name="razon_rechazo" id="razon_rechazo" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" required placeholder="Explique la razón del rechazo..."></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="cerrarModalRechazo()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function mostrarModalRechazo(reservaId) {
            const modal = document.getElementById('modalRechazo');
            const form = document.getElementById('formRechazo');
            
            form.action = `/reservas/${reservaId}/rechazar`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModalRechazo() {
            const modal = document.getElementById('modalRechazo');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('razon_rechazo').value = '';
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modalRechazo').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModalRechazo();
            }
        });
    </script>
</x-app-layout>
