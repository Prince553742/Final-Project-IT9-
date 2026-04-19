<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- your styles and scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="h-screen bg-gray-100 overflow-hidden">
            {{-- Sidebar is fixed, so it stays on the left --}}
            @include('layouts.navigation')

            {{-- Main content: offset by sidebar width (w-64 = 16rem) --}}
            <div class="ml-64 h-full overflow-y-auto">
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>