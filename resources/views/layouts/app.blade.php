<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    dark: localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" x-init="$watch('dark', val => {
    localStorage.setItem('theme', val ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', val);
})"
    :class="{ 'dark': dark }">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('config.admin.name', 'DevSCZ') }}</title>
    <link rel="icon" href="{{ asset(config('admin.app.favicon')) }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
        integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>


<body class="font-sans antialiased bg-slate-100 dark:bg-gray-700" x-data="{ sidebarOpen: window.innerWidth >= 768 }"
    @toggle-sidebar.window="sidebarOpen = !sidebarOpen">

    @include('layouts.partials.navbar')


    <!-- Sidebar toggle -->
    <div :class="sidebarOpen ? 'sm:ml-1' : 'ml-0'" class="transition-all duration-300 ease-in-out">

        @include('layouts.partials.sidebar')

        <!-- Contenido principal -->
        <div :class="sidebarOpen ? 'sm:ml-64' : 'ml-0'" class="p-4 transition-all duration-300 mt-14">
            <div class="p-4">
                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                window.dispatchEvent(new CustomEvent('toggle-sidebar', {
                    detail: false
                }));
            }
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                'Excelente!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Error',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire(
                'Atención!',
                '{{ session('warning') }}',
                'warning'
            )
        </script>
    @endif

    <script>
        function lanzarToast(type, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

        Livewire.on('toast-success', msg => lanzarToast('success', msg));
        Livewire.on('toast-warning', msg => lanzarToast('warning', msg));
        Livewire.on('toast-error', msg => lanzarToast('error', msg));
    </script>

    <script>
        Livewire.on('success', message => {
            Swal.fire('Excelente!', message, 'success');

        });
        Livewire.on('error', message => {
            Swal.fire('Error!', message, 'error');

        });
        Livewire.on('warning', message => {
            Swal.fire('Atención!', message, 'warning');
        });
    </script>
    <script>
        function confirmarEliminacion(id, eventoLivewire = 'eliminarRegistro') {
            Swal.fire({
                title: 'Eliminar Registro',
                text: '¿Estás seguro de que deseas eliminar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch(eventoLivewire, { id: id });
                }
            });
        }
    </script>
</body>

</html>
