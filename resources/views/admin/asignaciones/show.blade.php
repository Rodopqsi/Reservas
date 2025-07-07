<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asignaciones Activas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Horarios Asignados</h3>
                        <a href="{{ route('admin.asignaciones.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            Nueva Asignación
                        </a>
                    </div>

                    <!-- Mensajes -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Herramientas de gestión masiva -->
                        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <h4 class="text-sm font-medium text-yellow-900 mb-4">Gestión Masiva de Asignaciones</h4>
                            
                            <form method="POST" action="{{ route('admin.asignaciones.destroy') }}" class="space-y-4" onsubmit="return confirm('¿Está seguro de eliminar estas asignaciones? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label for="delete_user_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                                        <select name="user_id" id="delete_user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                                            <option value="">Seleccionar profesor</option>
                                            @foreach($asignaciones->unique('user_id') as $asignacion)
                                                <option value="{{ $asignacion->user_id }}">{{ $asignacion->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="delete_aula_id" class="block text-sm font-medium text-gray-700">Aula</label>
                                        <select name="aula_id" id="delete_aula_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                                            <option value="">Seleccionar aula</option>
                                            @foreach($asignaciones->unique('aula_id') as $asignacion)
                                                <option value="{{ $asignacion->aula_id }}">{{ $asignacion->aula->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="delete_fecha_inicio" class="block text-sm font-medium text-gray-700">Desde</label>
                                        <input type="date" name="fecha_inicio" id="delete_fecha_inicio" value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                                    </div>
                                    
                                    <div>
                                        <label for="delete_fecha_fin" class="block text-sm font-medium text-gray-700">Hasta</label>
                                        <input type="date" name="fecha_fin" id="delete_fecha_fin" value="{{ date('Y-m-d', strtotime('+1 month')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                                        Eliminar Asignaciones
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="mt-6">
                            {{ $asignaciones->links() }}
                        </div>
                    @if($asignaciones->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Profesor
                                        </th>
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($asignaciones as $asignacion)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-gray-700">
                                                                {{ substr($asignacion->user->name, 0, 2) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $asignacion->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $asignacion->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $asignacion->aula->nombre }}</div>
                                                <div class="text-sm text-gray-500">{{ $asignacion->aula->codigo }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($asignacion->fecha)->format('l') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($asignacion->hora_inicio)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($asignacion->hora_fin)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $asignacion->motivo }}</div>
                                                @if($asignacion->observaciones)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($asignacion->observaciones, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ ucfirst($asignacion->estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        


                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg mb-4">No hay asignaciones activas</div>
                            <a href="{{ route('admin.asignaciones.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                                Crear Primera Asignación
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
