<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Velora Co') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tempat untuk CSS tambahan dari child views --}}
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900 min-h-screen flex flex-col">

    {{-- navigation --}}
    @include('layouts.navigation')

    {{-- Optional header section (child views dapat men-set @section('header') ) --}}
    @hasSection('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    {{-- Main content area: child views harus @section('content') --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer: include sekali di layout, setelah main --}}
    @include('layouts.footer')

    {{-- Tempat untuk JS tambahan dari child views --}}
    @stack('scripts')
</body>
</html>
