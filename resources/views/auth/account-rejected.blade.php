<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS CDN como fallback -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Estilos inline adicionales -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2rem;
            max-width: 28rem;
            width: 100%;
            margin: 1rem;
        }
        .icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }
        .btn-secondary {
            background: transparent;
            color: #6b7280;
            border: 2px solid #e5e7eb;
            margin-top: 0.5rem;
        }
        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">
            <i class="fas fa-times-circle text-white text-xl"></i>
        </div>
        
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Cuenta Rechazada</h1>
            
            <div class="mb-6">
                <p class="text-gray-600 mb-4">
                    Tu solicitud de cuenta de profesor ha sido rechazada por el administrador.
                </p>
                <p class="text-sm text-gray-500">
                    Si crees que esto es un error, contacta al administrador del sistema.
                </p>
            </div>
            
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="btn">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Volver al Login
                </a>
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline; width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </div>
            
            <div class="mt-6 p-4 bg-red-50 rounded-lg">
                <p class="text-sm text-red-700">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Para obtener acceso al sistema, contacta al administrador.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
