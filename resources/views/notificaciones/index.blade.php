<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notificaciones') }}
            </h2>
            <button onclick="marcarTodasComoLeidas()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                Marcar todas como leídas
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($notificaciones->count() > 0)
                        <div class="space-y-4">
                            @foreach($notificaciones as $notificacion)
                                <div class="border rounded-lg p-4 {{ $notificacion->leida ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h3 class="font-semibold text-gray-900">{{ $notificacion->titulo }}</h3>
                                                @if(!$notificacion->leida)
                                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Nuevo</span>
                                                @endif
                                            </div>
                                            <p class="text-gray-700 mb-2">{{ $notificacion->mensaje }}</p>
                                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                                <span>{{ $notificacion->created_at->diffForHumans() }}</span>
                                                @if($notificacion->reserva)
                                                    <span>•</span>
                                                    <span>{{ $notificacion->reserva->aula->nombre }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            @if(!$notificacion->leida)
                                                <button onclick="marcarComoLeida({{ $notificacion->id }})" 
                                                        class="text-blue-500 hover:text-blue-700 text-sm">
                                                    Marcar como leída
                                                </button>
                                            @endif
                                            @if($notificacion->reserva)
                                                <a href="{{ route('reservas.show', $notificacion->reserva) }}" 
                                                   class="text-green-500 hover:text-green-700 text-sm">
                                                    Ver reserva
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $notificaciones->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 text-lg mb-2">
                                <i class="fas fa-bell-slash text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes notificaciones</h3>
                            <p class="text-gray-600">Cuando recibas notificaciones, aparecerán aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function marcarComoLeida(notificacionId) {
            fetch(`/notificaciones/${notificacionId}/marcar-leida`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function marcarTodasComoLeidas() {
            fetch('/notificaciones/marcar-todas-leidas', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    </script>
</x-app-layout>
