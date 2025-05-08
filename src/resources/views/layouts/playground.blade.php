<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CuraSync Playground') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    <body class="font-poppins antialiased bg-[white] min-h-screen">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-row relative">
            <!-- Hamburger Icon -->
            <div class="absolute z-50 top-6 left-2 cursor-pointer" @mouseenter="sidebarOpen = true">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <!-- Playground Sidebar/Menu -->
            <div @mouseenter="sidebarOpen = true" @mouseleave="sidebarOpen = false" class="transition-all duration-300 z-40"
                :class="sidebarOpen ? 'w-64' : 'w-0'">
                <div class="overflow-hidden h-full">
                    @include('playground.sidebar')
                </div>
            </div>
            <div class="flex-1 flex flex-col min-h-screen">
                @include('playground.header')
                <main class="flex-grow">
                    @yield('content')
                </main>
            </div>
        </div>
        @include('footer')

        @stack('modals')
        @livewireScripts
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>
</html>
