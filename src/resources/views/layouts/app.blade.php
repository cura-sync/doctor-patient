<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CuraSync') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular-sanitize.js"></script>
        <script type="text/javascript" src="/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/2.1.3/marked.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.8/purify.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/mainStyle.css') }}">
        <!-- Loader Script -->
        <script type="text/javascript" src="/js/loader/loader.directive.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-[white] min-h-screen">
        <x-banner />

        <div class="min-h-screen flex flex-col">
            @livewire('navigation-menu')
            <!-- Page Content -->
            <main class="flex-grow">
                @yield('content')
            </main>
            @include('footer')
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
