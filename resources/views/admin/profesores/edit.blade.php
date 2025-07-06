<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Profesor') }}
            </h2>
            <a href="{{ route('admin.profesores.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.profesores.update', $profesor) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información Personal</h3>
                                
                                <!-- Nombre -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $profesor->name) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $profesor->email) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Código de Profesor -->
                                <div class="mb-4">
                                    <label for="codigo_profesor" class="block text-sm font-medium text-gray-700">Código de Profesor</label>
                                    <input type="text" name="codigo_profesor" id="codigo_profesor" value="{{ old('codigo_profesor', $profesor->codigo_profesor) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    @error('codigo_profesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado y Configuración -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Estado y Configuración</h3>
                                
                                <!-- Estado -->
                                <div class="mb-4">
                                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="pendiente" {{ old('estado', $profesor->estado) == 'pendiente' ? 'selected' : '' }}>
                                            Pendiente
                                        </option>
                                        <option value="aprobado" {{ old('estado', $profesor->estado) == 'aprobado' ? 'selected' : '' }}>
                                            Aprobado
                                        </option>
                                        <option value="rechazado" {{ old('estado', $profesor->estado) == 'rechazado' ? 'selected' : '' }}>
                                            Rechazado
                                        </option>
                                    </select>
                                    @error('estado')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado Actual -->
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Estado Actual</h4>
                                    <div class="flex items-center">
                                        @if($profesor->estado == 'pendiente')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pendiente de Aprobación
                                            </span>
                                        @elseif($profesor->estado == 'aprobado')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Aprobado - Puede usar el sistema
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>
                                                Rechazado - No puede acceder
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Información de Registro -->
                                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-blue-700 mb-2">Información de Registro</h4>
                                    <div class="space-y-1 text-sm text-blue-600">
                                        <p><strong>Fecha de registro:</strong> {{ $profesor->created_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Última actualización:</strong> {{ $profesor->updated_at->format('d/m/Y H:i') }}</p>
                                        <p><strong>Total de reservas:</strong> {{ $profesor->reservas()->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.profesores.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save mr-2"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
