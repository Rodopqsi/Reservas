<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Reservas</title>
        
        <!-- Favicon (puedes cambiar la ruta de la imagen) -->
        <link rel="icon" type="image/png" style="widht:100px;" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Tailwind CSS CDN como fallback -->
        @if(app()->environment('production'))
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                /* Estilos básicos personalizados */
                .bg-gray-100 { background-color: #f3f4f6; }
                .bg-white { background-color: #ffffff; }
                .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
                .rounded-lg { border-radius: 0.5rem; }
                .p-6 { padding: 1.5rem; }
                .text-xl { font-size: 1.25rem; }
                .font-semibold { font-weight: 600; }
                .text-gray-800 { color: #1f2937; }
                .leading-tight { line-height: 1.25; }
                .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
                .max-w-7xl { max-width: 80rem; }
                .mx-auto { margin-left: auto; margin-right: auto; }
                .grid { display: grid; }
                .gap-6 { gap: 1.5rem; }
                .text-3xl { font-size: 1.875rem; }
                .font-bold { font-weight: 700; }
                .text-blue-600 { color: #2563eb; }
                .text-green-600 { color: #16a34a; }
                .text-yellow-600 { color: #d97706; }
                .text-gray-600 { color: #4b5563; }
                .btn { padding: 0.75rem 1.5rem; border-radius: 0.375rem; font-weight: 500; text-decoration: none; display: inline-block; text-align: center; transition: all 0.2s; }
                .btn-blue { background-color: #3b82f6; color: white; }
                .btn-blue:hover { background-color: #2563eb; }
                .btn-gray { background-color: #6b7280; color: white; }
                .btn-gray:hover { background-color: #4b5563; }
                .btn-green { background-color: #10b981; color: white; }
                .btn-green:hover { background-color: #059669; }
            </style>
        @endif
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
