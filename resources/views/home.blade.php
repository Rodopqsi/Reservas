<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Estadísticas rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $aulas->count() }}</div>
                        <div class="text-gray-600">Aulas Disponibles</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $reservas->where('estado', 'aprobada')->count() }}</div>
                        <div class="text-gray-600">Reservas Aprobadas</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $reservas->where('estado', 'pendiente')->count() }}</div>
                        <div class="text-gray-600">Reservas Pendientes</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Acciones rápidas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Acciones Rápidas</h3>
                        <div class="space-y-3">
                            <a href="{{ route('reservas.create') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                Nueva Reserva
                            </a>
                            <a href="{{ route('reservas.index') }}" class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                Ver Mis Reservas
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-md text-center transition duration-200">
                                    Panel de Administración
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reservas recientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Mis Reservas Recientes</h3>
                        @if($reservas->isEmpty())
                            <p class="text-gray-500">No tienes reservas aún.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($reservas as $reserva)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium">{{ $reserva->aula->nombre }}</h4>
                                                <p class="text-sm text-gray-600">
                                                    {{ $reserva->fecha->format('d/m/Y') }} - 
                                                    {{ date('H:i', strtotime($reserva->hora_inicio)) }} a {{ date('H:i', strtotime($reserva->hora_fin)) }}
                                                </p>
                                                <p class="text-sm text-gray-600">{{ $reserva->motivo }}</p>
                                            </div>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                @if($reserva->estado === 'aprobada') bg-green-100 text-green-800
                                                @elseif($reserva->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($reserva->estado === 'rechazada') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($reserva->estado) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
