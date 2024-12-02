<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @vite(['resources/css/app.postcss', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-screen">
    <main class="flex h-full">
        <!-- Left Column -->
        <div class="hidden md:flex md:w-1/2 bg-[#135d3b] items-center justify-center">
            <a href="{{ route('home') }}">
                <h1 class="text-4xl font-bold text-white">The Auction Hub</h1>
            </a>
        </div>

        <!-- Right Column -->
        <div class="w-full md:w-1/2 overflow-y-auto p-6 flex items-center justify-center">
            <div class="w-full">
                @yield('content')
            </div>
        </div>
    </main>
    @stack('scripts')
</body>

</html>
