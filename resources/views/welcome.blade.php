<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>    

    <link rel="icon" href="{{ asset(config('admin.app.favicon')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-4 relative">

        <!-- Imagen de fondo decorativa -->
        <div class="absolute inset-0 z-0 opacity-30 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1920&q=80');">
        </div>

        <!-- Superposición oscura -->
        <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>

        <!-- Contenido principal -->
        <div class="relative z-20 text-center max-w-2xl">

            <h1
                class="text-4xl sm:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">
                Bienvenido a {{ config('app.name') }}
            </h1>

            <p class="text-gray-300 mb-8 text-lg">
                Tu plataforma ejecutiva para la gestión Profesional, Rápida y Segura de tu Información.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg hover:scale-105 transition">
                        Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 transition">
                        Iniciar Sesión
                    </a>

                    <a href="{{ route('register') }}"
                        class="px-6 py-3 bg-gray-700 rounded-lg shadow-lg hover:bg-gray-800 transition">
                        Registrarse
                    </a>
                @endauth
            </div>

        </div>

        <!-- Footer -->
        <footer class="relative z-20 mt-16 text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </footer>

    </div>

</body>

</html>
