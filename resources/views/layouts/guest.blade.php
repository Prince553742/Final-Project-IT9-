<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Minazuki\'s Belly') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-indigo-50/30">

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
    <!-- Logo / Brand -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-500 shadow-lg shadow-indigo-200">
            <span class="text-white font-black text-2xl">M</span>
        </div>
        <h1 class="mt-4 text-3xl font-bold text-gray-800">Minazuki's Belly</h1>
        <p class="mt-1 text-sm text-gray-500">Task management for modern teams</p>
    </div>

    <!-- Auth Card -->
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-8">
            &copy; {{ date('Y') }} Minazuki's Belly. All rights reserved.
        </p>
    </div>
</div>

</body>
</html>