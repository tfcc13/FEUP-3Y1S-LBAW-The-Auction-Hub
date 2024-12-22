<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The Auction Hub - Login</title>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-screen">
    <main class="flex flex-col md:flex-row h-full justify-center">
        <!-- Left Column -->
        <div class="flex md:w-1/2 md:bg-[#135d3b] items-center justify-center p-6 md:p-0">
            <a href="{{ route('home') }}" class="flex flex-col items-center space-y-2">
                <img src="{{ asset('images/crown_logo.webp') }}" alt="The Auction Hub Logo" class="w-24 object-contain">
                <h1 class="text-4xl font-bold text-gray-800 md:text-white text-center">The Auction Hub</h1>
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
