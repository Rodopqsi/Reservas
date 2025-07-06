<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 rounded-full shadow">
                <span class="text-2xl font-bold text-gray-800">Reserva de Aulas</span>
            </div>
            <nav class="space-x-6">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-semibold">Inicio</a>
                <a href="/nosotros" class="text-gray-700 hover:text-blue-600 font-semibold">Nosotros</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">Ingresar</a>
            </nav>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 flex flex-col items-center justify-center py-12">
        
        <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">Bienvenido al Sistema de Reservas de Aulas</h1>
        <p class="text-lg text-gray-600 mb-8 text-center max-w-2xl">Gestiona y reserva aulas de manera eficiente, visualiza el calendario, recibe notificaciones y accede a todas las funcionalidades desde un solo lugar.</p>
    </main>

    <!-- Footer -->
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
