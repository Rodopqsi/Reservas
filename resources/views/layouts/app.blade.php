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
                
                /* Estilos específicos para la navegación */
                nav { display: block !important; }
                .border-b { border-bottom: 1px solid #e5e7eb; }
                .border-gray-100 { border-color: #f3f4f6; }
                .h-16 { height: 4rem; }
                .flex { display: flex; }
                .justify-between { justify-content: space-between; }
                .items-center { align-items: center; }
                .shrink-0 { flex-shrink: 0; }
                .hidden { display: none; }
                .space-x-8 > :not(:first-child) { margin-left: 2rem; }
                .sm\:flex { display: flex; }
                .px-4 { padding-left: 1rem; padding-right: 1rem; }
                .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
                .text-sm { font-size: 0.875rem; }
                .leading-4 { line-height: 1; }
                .font-medium { font-weight: 500; }
                .rounded-md { border-radius: 0.375rem; }
                .text-gray-500 { color: #6b7280; }
                .hover\:text-gray-700:hover { color: #374151; }
                .transition { transition: all 0.15s ease-in-out; }
                .relative { position: relative; }
                .absolute { position: absolute; }
                .right-0 { right: 0; }
                .mt-2 { margin-top: 0.5rem; }
                .w-48 { width: 12rem; }
                .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
                .ring-1 { box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05); }
                .ring-black { --tw-ring-color: rgba(0, 0, 0, 1); }
                .ring-opacity-5 { --tw-ring-opacity: 0.05; }
                .z-50 { z-index: 50; }
                .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
                .block { display: block; }
                .px-4 { padding-left: 1rem; padding-right: 1rem; }
                .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
                .text-gray-700 { color: #374151; }
                .hover\:bg-gray-100:hover { background-color: #f3f4f6; }
                .w-full { width: 100%; }
                .text-left { text-align: left; }
                .border { border: 1px solid #d1d5db; }
                .border-transparent { border-color: transparent; }
                .focus\:outline-none:focus { outline: none; }
                .ms-1 { margin-left: 0.25rem; }
                .ms-3 { margin-left: 0.75rem; }
                .ms-6 { margin-left: 1.5rem; }
                .mr-4 { margin-right: 1rem; }
                .fill-current { fill: currentColor; }
                .h-4 { height: 1rem; }
                .w-4 { width: 1rem; }
                .w-5 { height: 1.25rem; }
                .h-5 { width: 1.25rem; }
                .-top-2 { top: -0.5rem; }
                .-right-2 { right: -0.5rem; }
                .bg-red-500 { background-color: #ef4444; }
                .text-white { color: #ffffff; }
                .text-xs { font-size: 0.75rem; }
                .rounded-full { border-radius: 9999px; }
                .inline-flex { display: inline-flex; }
                .justify-center { justify-content: center; }
                .p-2 { padding: 0.5rem; }
                .text-gray-400 { color: #9ca3af; }
                .hover\:text-gray-500:hover { color: #6b7280; }
                .hover\:bg-gray-100:hover { background-color: #f3f4f6; }
                .focus\:bg-gray-100:focus { background-color: #f3f4f6; }
                .focus\:text-gray-500:focus { color: #6b7280; }
                .duration-150 { transition-duration: 150ms; }
                .ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
                .h-6 { height: 1.5rem; }
                .w-6 { width: 1.5rem; }
                .stroke-current { stroke: currentColor; }
                .fill-none { fill: none; }
                
                /* Responsive utilities */
                @media (min-width: 640px) {
                    .sm\:hidden { display: none; }
                    .sm\:flex { display: flex; }
                    .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
                }
                
                @media (min-width: 1024px) {
                    .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
                }
            </style>
        @else
            <script src="https://cdn.tailwindcss.com"></script>
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
