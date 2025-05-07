<header class="w-full flex items-center justify-between px-8 py-6 border-b border-gray-200"  style="background-image: url('{{ asset('resources/bg_abstract_4.png') }}'); background-size: cover; background-position: center;">
    <div class="text-xl font-semibold text-white ml-10">Welcome, {{ Auth::user()->name }}!</div>
    <div class="flex items-center space-x-6">
        <!-- User Avatar and Name with Dropdown -->
        <div x-data="{ open: false }" class="relative flex items-center">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                <div class="w-9 h-9 bg-white rounded-full"></div>
                <div class="flex flex-col leading-tight text-left">
                    <span class="font-semibold text-white text-sm">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500">Patient</span>
                </div>
                <svg class="w-4 h-4 ml-1 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Go Home</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Alpine.js for dropdown -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> 