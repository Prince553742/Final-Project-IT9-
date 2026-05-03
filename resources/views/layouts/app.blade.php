<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Minazuki\'s Belly') }}</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .main-transition {
            transition: margin-left 0.2s ease-in-out;
        }
        /* Removed: broken .w-20 .flex a hack — alignment is now handled
           properly via Alpine x-bind:class in nav-link.blade.php */
    </style>
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' }" x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))">
    <!-- Fixed Sidebar -->
    @include('layouts.navigation')

    <!-- Main Content with dynamic left margin -->
    <div class="main-transition" :class="sidebarOpen ? 'ml-64' : 'ml-20'" style="min-height: 100vh;">
        <div class="bg-gray-100">
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>