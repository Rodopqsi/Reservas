<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Aula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Errores -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.aulas.update', $aula) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">
                                    Nombre del Aula
                                </label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $aula->nombre) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Código -->
                            <div>
                                <label for="codigo" class="block text-sm font-medium text-gray-700">
                                    Código
                                </label>
                                <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $aula->codigo) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Capacidad -->
                            <div>
                                <label for="capacidad" class="block text-sm font-medium text-gray-700">
                                    Capacidad
                                </label>
                                <input type="number" name="capacidad" id="capacidad" value="{{ old('capacidad', $aula->capacidad) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Ubicación -->
                            <div>
                                <label for="ubicacion" class="block text-sm font-medium text-gray-700">
                                    Ubicación
                                </label>
                                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $aula->ubicacion) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Descripción -->
                            <div class="md:col-span-2">
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                    Descripción
                                </label>
                                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $aula->descripcion) }}</textarea>
                            </div>

                            <!-- Equipamiento -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Equipamiento
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @php
                                        $equipamientoActual = old('equipamiento', $aula->equipamiento ?? []);
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Proyector" {{ in_array('Proyector', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Proyector</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Pizarra" {{ in_array('Pizarra', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Pizarra</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Computadora" {{ in_array('Computadora', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Computadora</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Aire Acondicionado" {{ in_array('Aire Acondicionado', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Aire Acondicionado</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Micrófono" {{ in_array('Micrófono', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Micrófono</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Pantalla" {{ in_array('Pantalla', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Pantalla</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="WiFi" {{ in_array('WiFi', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">WiFi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="equipamiento[]" value="Sillas Ergonómicas" {{ in_array('Sillas Ergonómicas', $equipamientoActual) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Sillas Ergonómicas</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="activo" value="1" {{ old('activo', $aula->activo) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Aula Activa</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.aulas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                Actualizar Aula
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
