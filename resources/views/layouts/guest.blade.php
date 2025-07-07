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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Tailwind CSS CDN como fallback para producción -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <!-- Estilos inline para asegurar que se apliquen -->
        <style>
            /* Estilos base para el login */
            .min-h-screen {
                min-height: 100vh;
            }
            
            .bg-gray-100 {
                background-color: #f3f4f6;
            }
            
            .bg-white {
                background-color: white;
            }
            
            .shadow-md {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .rounded-lg {
                border-radius: 0.5rem;
            }
            
            .flex {
                display: flex;
            }
            
            .flex-col {
                flex-direction: column;
            }
            
            .items-center {
                align-items: center;
            }
            
            .justify-center {
                justify-content: center;
            }
            
            .w-full {
                width: 100%;
            }
            
            .max-w-md {
                max-width: 28rem;
            }
            
            .px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .py-4 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
            
            .mt-6 {
                margin-top: 1.5rem;
            }
            
            .pt-6 {
                padding-top: 1.5rem;
            }
            
            /* Estilos para inputs */
            .form-input {
                appearance: none;
                background-color: white;
                border: 1px solid #d1d5db;
                border-radius: 0.375rem;
                padding: 0.5rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                width: 100%;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }
            
            .form-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            }
            
            /* Estilos para botones */
            .btn-primary {
                background-color: #6366f1;
                border: 1px solid #6366f1;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.15s ease-in-out;
            }
            
            .btn-primary:hover {
                background-color: #4f46e5;
            }
            
            /* Estilos para labels */
            .form-label {
                font-weight: 500;
                color: #374151;
                margin-bottom: 0.5rem;
                display: block;
            }
            
            /* Estilos para errores */
            .error-message {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
            
            /* Estilos para links */
            .link-gray {
                color: #6b7280;
                text-decoration: underline;
                font-size: 0.875rem;
            }
            
            .link-gray:hover {
                color: #374151;
            }
            
            /* Espaciado */
            .mt-1 { margin-top: 0.25rem; }
            .mt-2 { margin-top: 0.5rem; }
            .mt-4 { margin-top: 1rem; }
            .mb-4 { margin-bottom: 1rem; }
            .ms-2 { margin-left: 0.5rem; }
            .ms-3 { margin-left: 0.75rem; }
            
            /* Flex utilities */
            .justify-end { justify-content: flex-end; }
            .inline-flex { display: inline-flex; }
            .items-center { align-items: center; }
            .block { display: block; }
            
            /* Text utilities */
            .text-sm { font-size: 0.875rem; }
            .text-gray-600 { color: #6b7280; }
            .text-gray-900 { color: #111827; }
            .text-indigo-600 { color: #6366f1; }
            .font-sans { font-family: system-ui, -apple-system, sans-serif; }
            .antialiased { -webkit-font-smoothing: antialiased; }
            
            /* Responsive */
            @media (min-width: 640px) {
                .sm\:justify-center { justify-content: center; }
                .sm\:pt-0 { padding-top: 0; }
                .sm\:max-w-md { max-width: 28rem; }
                .sm\:rounded-lg { border-radius: 0.5rem; }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}"  style="width: 120px; height:120px;" alt="Logo">
                </a>
            </div>
            
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
                
            </div>
        </div>
    </body>
</html>
