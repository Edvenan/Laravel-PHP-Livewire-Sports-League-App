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
    </head>
    <body class="min-h-screen flex flex-col  font-sans antialiased ">
            <x-banner />
    
            <div class="flex-grow  bg-gray-100">
    
                <!-- Navigation menu -->
                @livewire('navigation-menu')

                <div class="flex-grow font-sans text-gray-900 antialiased">
                    {{ $slot }}
                </div>
            </div>

            <!-- Page footer -->
            <footer class="bg-white shadow-lg   mb-0 ">
                <div class="max-w-7xl mx-auto text-xs  text-center py-3">
                    The IT Academy League! &copy; 2023 by Eduard Vendrell
                </div>
            </footer>

    </body>
</html>
