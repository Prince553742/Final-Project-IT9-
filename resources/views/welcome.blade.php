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

<div class="min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-100 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <!-- LOGO -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-lg shadow-md">
                        M
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Minazuki's Belly</span>
                </div>

                <!-- LINKS -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600 transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="flex-1 flex items-center justify-center px-6 py-16">
        <div class="max-w-5xl text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 leading-tight">
                Manage Tasks
                <span class="block bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-transparent bg-clip-text">
                    Smarter & Faster
                </span>
            </h1>

            <p class="mt-6 text-gray-600 max-w-2xl mx-auto text-lg">
                A modern task management system to organize projects, collaborate with your team, and track progress in real-time.
            </p>

            <div class="mt-10 flex justify-center gap-4 flex-wrap">
                <a href="{{ route('register') }}" class="px-7 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium shadow-md transition">
                    🚀 Get Started
                </a>
                <a href="{{ route('login') }}" class="px-7 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl font-medium transition">
                    Sign In
                </a>
            </div>

            <!-- STATS SECTION -->
            <div class="mt-14 grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="text-2xl font-bold text-indigo-600">5+</div>
                    <div class="text-sm text-gray-500 mt-1">Projects</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="text-2xl font-bold text-indigo-600">20+</div>
                    <div class="text-sm text-gray-500 mt-1">Tasks</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="text-2xl font-bold text-indigo-600">3+</div>
                    <div class="text-sm text-gray-500 mt-1">Team Members</div>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="text-2xl font-bold text-indigo-600">100%</div>
                    <div class="text-sm text-gray-500 mt-1">Productivity</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-6 text-center text-sm text-gray-400 border-t border-gray-100">
        &copy; {{ date('Y') }} Minazuki's Belly. All rights reserved.
    </footer>
</div>

</body>
</html>