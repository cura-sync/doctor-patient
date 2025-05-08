@php
$navigation = [
    'Home' => route('home'),
    'About' => route('about'),
    'Explore CuraSuite' => '#curasuite',
];
$currentRoute = request()->route()->getName();
@endphp

<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent py-6">
    <div class="relative max-w-7xl mx-auto flex justify-between items-center bg-black rounded-full px-6 py-3 shadow-lg">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('resources/logo-navbar.jpeg') }}" alt="CuraSync Logo" class="h-8 w-auto mr-2">
                <span class="text-2xl font-bold text-white">CuraSync</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-8">
            @foreach($navigation as $name => $route)
                <a href="{{ $route }}"
                   class="text-white hover:text-blue-400 font-medium border-b-2 {{ (url()->current() == $route || url()->full() == url()->to($route)) ? 'border-blue-500' : 'border-transparent' }} transition">
                    {{ $name }}
                </a>
            @endforeach
        </div>

        <!-- Login and Register Buttons (Not logged in)-->
        @if(Auth::guest())
        <div class="flex items-center">
            <a href="{{ route('login') }}"
            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-semibold">
                Login
            </a>
            <a href="{{ route('register') }}"
            class="px-5 py-2 hover:bg-white hover:text-black text-white rounded-full font-semibold"
            style="margin-left: 5px;"> 
                Register
         </a>
        </div>
        @else
        <div class="flex items-center">
            <a href="{{ route('playground.index') }}"
            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-semibold">
                Playground
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                class="px-5 py-2 hover:bg-white hover:text-black text-white rounded-full font-semibold"
                style="margin-left: 5px;"> 
                    Log Out
             </a>
            </form>
        </div>
        @endif
    </div>
</nav>