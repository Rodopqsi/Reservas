<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario de Aulas - Test') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3>Información de Debug:</h3>
                    <p><strong>Aulas disponibles:</strong> {{ $aulas->count() }}</p>
                    <p><strong>Aula seleccionada:</strong> {{ $aulaSeleccionada ? $aulaSeleccionada->nombre : 'Ninguna' }}</p>
                    <p><strong>Fecha:</strong> {{ $fechaCarbon->format('Y-m-d') }}</p>
                    <p><strong>Horarios:</strong> {{ count($horarios) }}</p>
                    <p><strong>Días de semana:</strong> {{ count($diasSemana) }}</p>
                    <p><strong>Reservas:</strong> {{ $reservas->count() }}</p>
                    
                    <div class="mt-4">
                        <h4>Aulas:</h4>
                        <ul>
                            @foreach($aulas as $aula)
                                <li>{{ $aula->nombre }} ({{ $aula->codigo }})</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <h4>Horarios:</h4>
                        <ul>
                            @foreach($horarios as $horario)
                                <li>{{ $horario['display'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
