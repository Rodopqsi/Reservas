<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function toggleText(id) {
            const el = document.getElementById(id);
            el.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="/img/logo.png" alt="Logo" class="h-12 w-12 rounded-full shadow">
                <span class="text-2xl font-bold text-gray-800">Reserva de Aulas</span>
            </div>
            <nav class="space-x-6">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-semibold">Inicio</a>
                <a href="/nosotros" class="text-gray-700 hover:text-blue-600 font-semibold">Nosotros</a>
                <a href="/proyecto" class="text-blue-600 font-semibold">Proyecto</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">Ingresar</a>
            </nav>
        </div>
    </header>
    <main class="flex-1 flex flex-col items-center justify-center py-12">
        <div class="w-full max-w-2xl bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Proyecto</h1>
            <div class="flex flex-col gap-4">
                <button onclick="toggleText('problema')" class="w-full bg-blue-100 hover:bg-blue-200 text-blue-800 font-semibold py-2 px-4 rounded transition flex items-center justify-between">
                    <span><i class="fas fa-exclamation-circle mr-2"></i>Problema</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="problema" class="hidden bg-blue-50 border-l-4 border-blue-300 p-4 mb-2 rounded">
                    El principal problema es la gestión ineficiente de la reserva de aulas, generando conflictos de horarios y falta de notificaciones oportunas para los usuarios.
                </div>
                <button onclick="toggleText('objetivos')" class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-semibold py-2 px-4 rounded transition flex items-center justify-between">
                    <span><i class="fas fa-bullseye mr-2"></i>Objetivos</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="objetivos" class="hidden bg-green-50 border-l-4 border-green-300 p-4 mb-2 rounded">
                    <ul class="list-disc pl-5">
                        <li>Optimizar la gestión de reservas de aulas.</li>
                        <li>Reducir conflictos de horarios.</li>
                        <li>Mejorar la comunicación mediante notificaciones automáticas.</li>
                        <li>Facilitar la visualización de disponibilidad en un calendario interactivo.</li>
                    </ul>
                </div>
                <button onclick="toggleText('hipotesis')" class="w-full bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-semibold py-2 px-4 rounded transition flex items-center justify-between">
                    <span><i class="fas fa-lightbulb mr-2"></i>Hipótesis</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div id="hipotesis" class="hidden bg-yellow-50 border-l-4 border-yellow-300 p-4 mb-2 rounded">
                    Si se implementa un sistema digital de reservas con notificaciones y validaciones automáticas, se reducirá el número de conflictos y se incrementará la satisfacción de los usuarios.
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-black text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-2 md:mb-0">
                &copy; {{ date('Y') }} Sistema de Reservas de Aulas. Todos los derechos reservados.
            </div>
            <div class="flex gap-4">
                <a href="https://github.com/" target="_blank" class="hover:text-blue-400"><i class="fab fa-github"></i></a>
                <a href="mailto:soporte@reserva.com" class="hover:text-blue-400"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>
