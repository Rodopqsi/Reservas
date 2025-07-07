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
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="form-label">{{ __('Nombre Completo') }}</label>
            <input id="name" class="form-input block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @if($errors->has('name'))
                <div class="error-message mt-2">
                    @foreach($errors->get('name') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-input block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @if($errors->has('email'))
                <div class="error-message mt-2">
                    @foreach($errors->get('email') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Código de Profesor -->
        <div class="mt-4">
            <label for="codigo_profesor" class="form-label">{{ __('Código de Profesor') }}</label>
            <input id="codigo_profesor" class="form-input block mt-1 w-full" type="text" name="codigo_profesor" value="{{ old('codigo_profesor') }}" required autocomplete="codigo_profesor" />
            @if($errors->has('codigo_profesor'))
                <div class="error-message mt-2">
                    @foreach($errors->get('codigo_profesor') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
            <p class="mt-1 text-sm text-gray-600">Ingresa el código de profesor proporcionado por la institución</p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input id="password" class="form-input block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            @if($errors->has('password'))
                <div class="error-message mt-2">
                    @foreach($errors->get('password') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="password_confirmation" class="form-input block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            @if($errors->has('password_confirmation'))
                <div class="error-message mt-2">
                    @foreach($errors->get('password_confirmation') as $message)
                        <p>{{ $message }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Información importante -->
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md" style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.375rem; padding: 1rem;">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20" style="width: 1.25rem; height: 1.25rem; color: #2563eb; margin-right: 0.5rem;">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm text-blue-800 font-medium" style="font-size: 0.875rem; color: #1e40af; font-weight: 500;">Registro de Profesores</p>
                    <p class="text-sm text-blue-600" style="font-size: 0.875rem; color: #2563eb;">Tu cuenta será revisada por el administrador antes de ser activada. Recibirás una notificación por email cuando sea aprobada.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="link-gray underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya tienes cuenta?') }}
            </a>

            <button type="submit" class="btn-primary ms-4">
                {{ __('Registrarse') }}
            </button>
        </div>
    </form>
</x-guest-layout>
