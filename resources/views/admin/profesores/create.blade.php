<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Nuevo Profesor') }}
            </h2>
            <a href="{{ route('admin.profesores.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.profesores.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Información Personal</h3>
                                
                                <!-- Nombre -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                           required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Código de Profesor -->
                                <div class="mb-4">
                                    <label for="codigo_profesor" class="block text-sm font-medium text-gray-700">Código de Profesor</label>
                                    <input type="text" name="codigo_profesor" id="codigo_profesor" value="{{ old('codigo_profesor') }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                           required>
                                    @error('codigo_profesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Ejemplo: PROF001, PROF002, etc.</p>
                                </div>
                            </div>

                            <!-- Credenciales -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Credenciales</h3>
                                
                                <!-- Contraseña -->
                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <input type="password" name="password" id="password" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                           required>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Mínimo 8 caracteres</p>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                           required>
                                </div>

                                <!-- Información -->
                                <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-blue-700 mb-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Información Importante
                                    </h4>
                                    <ul class="text-sm text-blue-600 space-y-1">
                                        <li>• Los profesores creados por admin se aprueban automáticamente</li>
                                        <li>• El profesor podrá acceder inmediatamente al sistema</li>
                                        <li>• Se enviará un email de bienvenida (si está configurado)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.profesores.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save mr-2"></i>
                                Crear Profesor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
