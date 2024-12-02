<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            @auth
                <!-- Content for authenticated users -->
                {{ $slot }}
            @else
                <!-- Message for guests -->
                <div class="text-center">
                    <h1 class="text-xl font-bold">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    <p>Please <a href="{{ route('account.login') }}" class="text-blue-600 underline">Sign In</a> or <a href="{{ route('account.register') }}" class="text-blue-600 underline">Sign Up</a>.</p>
                </div>
            @endauth
        </div>

        @livewireScripts
    </body>
</html>
