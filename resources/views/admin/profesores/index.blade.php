<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Profesores') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.profesores.pendientes') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-clock mr-2"></i>
                    Pendientes
                </a>
                <a href="{{ route('admin.profesores.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Profesor
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Lista de Profesores</h3>
                    
                    <!-- Filtros -->
                    <div class="mb-4 flex flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-700">Filtrar por estado:</span>
                            <select id="estadoFilter" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Todos</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="rechazado">Rechazado</option>
                            </select>
                        </div>
                    </div>

                    @if($profesores->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Profesor
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Código
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Registro
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reservas
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($profesores as $profesor)
                                        <tr class="hover:bg-gray-50" data-estado="{{ $profesor->estado }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $profesor->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $profesor->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">
                                                    {{ $profesor->codigo_profesor ?? 'Sin código' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
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
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>{{ $profesor->created_at->format('d/m/Y') }}</div>
                                                <div class="text-xs text-gray-400">{{ $profesor->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $profesor->reservas()->count() }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- Ver detalles -->
                                                    <a href="{{ route('admin.profesores.show', $profesor) }}" 
                                                       class="action-btn inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-md hover:bg-indigo-200 transition-colors duration-200" 
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Ver
                                                    </a>
                                                    
                                                    <!-- Editar -->
                                                    <a href="{{ route('admin.profesores.edit', $profesor) }}" 
                                                       class="action-btn inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-md hover:bg-blue-200 transition-colors duration-200" 
                                                       title="Editar">
                                                        <i class="fas fa-edit mr-1"></i>
                                                        Editar
                                                    </a>
                                                    
                                                    @if($profesor->estado == 'pendiente')
                                                        <!-- Aprobar -->
                                                        <form action="{{ route('admin.profesores.aprobar', $profesor) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="action-btn inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-md hover:bg-green-200 transition-colors duration-200" 
                                                                    onclick="return confirm('¿Aprobar este profesor?')"
                                                                    title="Aprobar">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Aprobar
                                                            </button>
                                                        </form>
                                                        
                                                        <!-- Rechazar -->
                                                        <form action="{{ route('admin.profesores.rechazar', $profesor) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="action-btn inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-md hover:bg-red-200 transition-colors duration-200" 
                                                                    onclick="return confirm('¿Rechazar este profesor?')"
                                                                    title="Rechazar">
                                                                <i class="fas fa-times mr-1"></i>
                                                                Rechazar
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <!-- Eliminar -->
                                                    <form action="{{ route('admin.profesores.destroy', $profesor) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="action-btn inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-md hover:bg-red-200 transition-colors duration-200" 
                                                                onclick="return confirm('¿Eliminar este profesor? Esta acción no se puede deshacer.')"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-6">
                            {{ $profesores->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay profesores registrados</h3>
                            <p class="text-gray-500">Aún no se han registrado profesores en el sistema.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filtro por estado
        document.getElementById('estadoFilter').addEventListener('change', function() {
            const selectedEstado = this.value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const estado = row.getAttribute('data-estado');
                if (selectedEstado === '' || estado === selectedEstado) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Mejorar interactividad de los botones
        document.addEventListener('DOMContentLoaded', function() {
            // Añadir efectos hover a los botones
            const buttons = document.querySelectorAll('button, a');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    
    <style>
        /* Asegurar que los íconos de FontAwesome se muestren correctamente */
        .fas, .far, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands";
            font-weight: 900;
        }
        
        /* Mejorar la apariencia de los botones de acción */
        .action-btn {
            transition: all 0.2s ease-in-out;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Asegurar que la tabla sea responsive */
        @media (max-width: 768px) {
            .action-btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</x-app-layout>
