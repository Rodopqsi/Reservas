<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Reserva') }}
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

                    <form method="POST" action="{{ route('reservas.update', $reserva) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Aula -->
                            <div>
                                <label for="aula_id" class="block text-sm font-medium text-gray-700">
                                    Aula
                                </label>
                                <select name="aula_id" id="aula_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">Seleccione un aula</option>
                                    @foreach($aulas as $aula)
                                        <option value="{{ $aula->id }}" {{ old('aula_id', $reserva->aula_id) == $aula->id ? 'selected' : '' }}>
                                            {{ $aula->nombre }} ({{ $aula->codigo }}) - Capacidad: {{ $aula->capacidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha -->
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700">
                                    Fecha
                                </label>
                                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $reserva->fecha->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Hora inicio -->
                            <div>
                                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">
                                    Hora de Inicio
                                </label>
                                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', $reserva->hora_inicio->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Hora fin -->
                            <div>
                                <label for="hora_fin" class="block text-sm font-medium text-gray-700">
                                    Hora de Fin
                                </label>
                                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', $reserva->hora_fin->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Motivo -->
                            <div class="md:col-span-2">
                                <label for="motivo" class="block text-sm font-medium text-gray-700">
                                    Motivo de la Reserva
                                </label>
                                <input type="text" name="motivo" id="motivo" value="{{ old('motivo', $reserva->motivo) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700">
                                    Observaciones (Opcional)
                                </label>
                                <textarea name="observaciones" id="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('observaciones', $reserva->observaciones) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('reservas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-md transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                Actualizar Reserva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
