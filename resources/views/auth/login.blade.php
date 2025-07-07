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
<x-guest-layout>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Error Messages -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span class="text-red-700 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-input block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @if($errors->has('email'))
                <div class="error-message mt-2">
                    @foreach($errors->get('email') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-input block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            @if($errors->has('password'))
                <div class="error-message mt-2">
                    @foreach($errors->get('password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember" style="margin-right: 0.5rem;">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="/register" class="boton_acceder" style="font-weight: 600; border-radius: 5px; padding:10px; background-color:blue; text-decoration: none; color:white;">
            {{ __('Registrar') }}
            </a>
            <div class="flex items-center space-x-3">
            @if (Route::has('password.request'))
                <a class="link-gray underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
                </a>
            @endif
            <button type="submit" class="btn-primary ms-3">
                {{ __('Log in') }}
            </button>
            </div>
        </div>
    </form>
</x-guest-layout>
