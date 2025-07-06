<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Sistema de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-12 rounded-full shadow">
                <span class="text-2xl font-bold text-gray-800">Reserva de Aulas</span>
            </div>
            <nav class="space-x-6">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-semibold">Inicio</a>
                <a href="/nosotros" class="text-blue-600 font-semibold">Nosotros</a>
                <a href="/login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">Ingresar</a>
            </nav>
        </div>
    </header>
    <main class="flex-1 flex flex-col items-center justify-center py-12">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Sobre Nosotros</h1>
            <p class="text-lg text-gray-600 mb-6 text-center">Somos un equipo apasionado por la tecnología y la educación, dedicados a crear soluciones digitales que mejoran la gestión académica.</p>
            
            <!-- Nueva sección: Imagen y texto en flex -->
            <div class="flex flex-col md:flex-row items-center gap-8 mb-10">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Nuestra Misión</h2>
                    <p class="text-gray-600 text-lg">
                        Brindar herramientas tecnológicas innovadoras que faciliten la administración y reserva de aulas, promoviendo la eficiencia y el acceso equitativo a los recursos educativos.
                    </p>
                </div>
                <img src="{{ asset('images/nosotros-imagen.png') }}" alt="Imagen representativa" class="w-64 h-54 object-cover ">
            </div>
            <!-- Fin de la nueva sección -->

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-center items-center">
                <div class="flex flex-col items-center">
                    <img src="/img/user1.png" alt="Aguilar Palomino Akemi Surey" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Aguilar Palomino Akemi Surey</span>
                    <span class="text-gray-500 text-sm">Desarrolladora Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user2.png" alt="Espinoza Uriel Fabrizio" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Espinoza Uriel Fabrizio</span>
                    <span class="text-gray-500 text-sm">Desarrollador Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user3.png" alt="Morales Castellanos Kytzia Kysabel" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Morales Castellanos Kytzia Kysabel</span>
                    <span class="text-gray-500 text-sm">Desarrolladora Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user4.png" alt="Preciado Avila Jorge Luis" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Preciado Avila Jorge Luis</span>
                    <span class="text-gray-500 text-sm">Desarrollador Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user5.png" alt="Ramírez Melendrez Sergi Farid" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Ramírez Melendrez Sergi Farid</span>
                    <span class="text-gray-500 text-sm">Desarrollador Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user6.png" alt="Valverde Flores Fernando Alonso" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Valverde Flores Fernando Alonso</span>
                    <span class="text-gray-500 text-sm">Desarrollador Web</span>
                </div>
                <div class="flex flex-col items-center">
                    <img src="/img/user7.png" alt="Venturo Bacilio Jhonatan Steben" class="w-24 h-24 rounded-full mb-2 shadow">
                    <span class="font-semibold text-center">Venturo Bacilio Jhonatan Steben</span>
                    <span class="text-gray-500 text-sm">Desarrollador Web</span>
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
