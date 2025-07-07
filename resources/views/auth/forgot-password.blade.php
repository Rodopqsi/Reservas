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
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
