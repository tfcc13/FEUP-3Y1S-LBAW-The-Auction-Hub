<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
        <script>
      const pusherAppKey = "{{ env('PUSHER_APP_KEY') }}";
      const pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
    </script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>



    <!-- Styles and Scripts -->
    @vite(['resources/css/app.postcss', 'resources/js/app.js', 'resources/js/auction.js', 'resources/js/components/bid_card.js', 'resources/js/components/info_card.js'])
</head>

<body>
    <main>
        <header>
            @include('layouts.navbar')
        </header>
        <section id="content">
            <x-toast.toast-notification />
            @yield('content')
        </section>
    </main>
    @stack('scripts')
</body>

</html>
