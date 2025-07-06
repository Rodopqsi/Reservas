<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Profesor') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.profesores.edit', $profesor) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('admin.profesores.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Información del Profesor -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Personal</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-xl font-medium text-gray-900">{{ $profesor->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $profesor->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Código de Profesor</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $profesor->codigo_profesor }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                                        <div class="mt-1">
                                            @if($profesor->estado == 'pendiente')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pendiente
                                                </span>
                                            @elseif($profesor->estado == 'aprobado')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Aprobado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Rechazado
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-blue-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="text-sm text-blue-600">Total Reservas</p>
                                            <p class="text-2xl font-semibold text-blue-800">{{ $reservas->total() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="text-sm text-green-600">Aprobadas</p>
                                            <p class="text-2xl font-semibold text-green-800">{{ $profesor->reservas()->where('estado', 'aprobada')->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-yellow-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="text-sm text-yellow-600">Pendientes</p>
                                            <p class="text-2xl font-semibold text-yellow-800">{{ $profesor->reservas()->where('estado', 'pendiente')->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-times text-gray-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="text-sm text-gray-600">Canceladas</p>
                                            <p class="text-2xl font-semibold text-gray-800">{{ $profesor->reservas()->where('estado', 'cancelada')->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones Rápidas -->
                    @if($profesor->estado == 'pendiente')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <h4 class="text-lg font-medium text-yellow-800 mb-2">Acciones Pendientes</h4>
                            <p class="text-sm text-yellow-600 mb-3">Este profesor está pendiente de aprobación.</p>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.profesores.aprobar', $profesor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="return confirm('¿Aprobar este profesor?')">
                                        <i class="fas fa-check mr-2"></i>
                                        Aprobar Profesor
                                    </button>
                                </form>
                                <form action="{{ route('admin.profesores.rechazar', $profesor) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('¿Rechazar este profesor?')">
                                        <i class="fas fa-times mr-2"></i>
                                        Rechazar Profesor
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Historial de Reservas -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de Reservas</h3>
                        
                        @if($reservas->count() > 0)
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
                                                Fecha Creación
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reservas as $reserva)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $reserva->aula->nombre }}</div>
                                                    <div class="text-sm text-gray-500">{{ $reserva->aula->codigo }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">{{ $reserva->motivo }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($reserva->estado == 'pendiente')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pendiente
                                                        </span>
                                                    @elseif($reserva->estado == 'aprobada')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Aprobada
                                                        </span>
                                                    @elseif($reserva->estado == 'cancelada')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            Cancelada
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $reserva->created_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            <div class="mt-6">
                                {{ $reservas->links() }}
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay reservas</h3>
                                <p class="text-gray-500">Este profesor aún no ha realizado reservas.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
