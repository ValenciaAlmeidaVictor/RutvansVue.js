<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<<<<<<< HEAD

<head class="">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
=======
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="http://localhost/rutvans/backend/public/vendor/adminlte/dist/img/LogoRutvans.ico" type="image/x-icon">

>>>>>>> 3e588dd204e12255f3b31d5a1b1b6ec3434c42ea

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <script src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
=======
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos personalizados solo para paginación -->
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Styles -->
    @livewireStyles
>>>>>>> 3e588dd204e12255f3b31d5a1b1b6ec3434c42ea
</head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
