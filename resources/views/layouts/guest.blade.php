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
    <body class="font-sans antialiased bg-blue-950">
        <div class="min-h-screen flex flex-col justify-center items-center p-6">
            
            <!-- Card utama -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-2xl border-t-4 border-blue-900">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-white">
                © {{ date('Y') }} <span class="font-semibold"></span> - All rights reserved
            </div>
        </div>
    </body>
</html>
