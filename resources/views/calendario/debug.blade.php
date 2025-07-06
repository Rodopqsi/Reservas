<!DOCTYPE html>
<html>
<head>
    <title>Diagnóstico Calendario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Diagnóstico del Calendario</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Estado del Sistema</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p><strong>Aulas totales:</strong> {{ $aulas->count() }}</p>
                    <p><strong>Aula seleccionada:</strong> {{ $aulaSeleccionada ? $aulaSeleccionada->nombre : 'Ninguna' }}</p>
                    <p><strong>Fecha:</strong> {{ $fechaCarbon->format('Y-m-d') }}</p>
                </div>
                <div>
                    <p><strong>Reservas encontradas:</strong> {{ $reservas->count() }}</p>
                    <p><strong>Horarios generados:</strong> {{ count($horarios) }}</p>
                    <p><strong>Días de la semana:</strong> {{ count($diasSemana) }}</p>
                </div>
            </div>
        </div>
        
        @if($aulaSeleccionada)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Información del Aula</h2>
            <p><strong>Nombre:</strong> {{ $aulaSeleccionada->nombre }}</p>
            <p><strong>Código:</strong> {{ $aulaSeleccionada->codigo }}</p>
            <p><strong>Capacidad:</strong> {{ $aulaSeleccionada->capacidad }}</p>
            <p><strong>Ubicación:</strong> {{ $aulaSeleccionada->ubicacion }}</p>
            <p><strong>Activo:</strong> {{ $aulaSeleccionada->activo ? 'Sí' : 'No' }}</p>
        </div>
        @endif
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Horarios Disponibles</h2>
            <div class="grid grid-cols-3 gap-2">
                @foreach($horarios as $horario)
                <div class="p-2 bg-gray-50 rounded">
                    {{ $horario['display'] }}
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Días de la Semana</h2>
            <div class="grid grid-cols-7 gap-2">
                @foreach($diasSemana as $dia)
                <div class="p-2 bg-gray-50 rounded text-center">
                    <div class="font-semibold">{{ $dia['nombre'] }}</div>
                    <div class="text-lg">{{ $dia['numero'] }}</div>
                    <div class="text-sm text-gray-600">{{ $dia['mes'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Reservas Encontradas</h2>
            @if($reservas->count() > 0)
            <div class="space-y-2">
                @foreach($reservas as $reserva)
                <div class="p-3 bg-gray-50 rounded">
                    <p><strong>Usuario:</strong> {{ $reserva->user->name }}</p>
                    <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
                    <p><strong>Hora:</strong> {{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</p>
                    <p><strong>Estado:</strong> {{ $reserva->estado }}</p>
                    <p><strong>Motivo:</strong> {{ $reserva->motivo }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-600">No hay reservas para esta semana.</p>
            @endif
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('calendario.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Volver al Calendario Normal
            </a>
        </div>
    </div>
</body>
</html>
