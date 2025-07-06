<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Aula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Aula</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Nombre:</span>
                                    <p class="text-sm text-gray-900">{{ $aula->nombre }}</p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Código:</span>
                                    <p class="text-sm text-gray-900">{{ $aula->codigo }}</p>
                                </div>

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Capacidad:</span>
                                    <p class="text-sm text-gray-900">{{ $aula->capacidad }} personas</p>
                                </div>

                                @if($aula->ubicacion)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Ubicación:</span>
                                        <p class="text-sm text-gray-900">{{ $aula->ubicacion }}</p>
                                    </div>
                                @endif

                                @if($aula->descripcion)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Descripción:</span>
                                        <p class="text-sm text-gray-900">{{ $aula->descripcion }}</p>
                                    </div>
                                @endif

                                <div>
                                    <span class="text-sm font-medium text-gray-500">Estado:</span>
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium
                                        @if($aula->activo) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $aula->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipamiento</h3>
                            
                            @if($aula->equipamiento && count($aula->equipamiento) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($aula->equipamiento as $equipo)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">{{ $equipo }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No hay equipamiento registrado.</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-3">
                        <a href="{{ route('admin.aulas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                            Volver
                        </a>
                        <a href="{{ route('admin.aulas.edit', $aula) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                            Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
