<aside class="w-58 bg-[#1C2332] min-h-screen flex flex-col shadow-md">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('resources/logo-navbar.jpeg') }}" alt="CuraSync Playground" class="h-10 w-10 rounded-full" />
            <span class="text-xl font-semibold text-white">CuraSync</span>
        </div>
    </div>
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('playground.index') }}" class="flex items-center px-3 py-2 rounded-md text-white hover:bg-blue-100 hover:text-blue-700 transition">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('playground.index') }}" class="flex items-center px-3 py-2 rounded-md text-white hover:bg-blue-100 hover:text-blue-700 transition">
                    Original Text
                </a>
            </li>
            <li>
                <a href="{{ route('playground.index') }}" class="flex items-center px-3 py-2 rounded-md text-white hover:bg-blue-100 hover:text-blue-700 transition">
                    Translated Text
                </a>
            </li>
            <li>
                <a href="{{ route('playground.index') }}" class="flex items-center px-3 py-2 rounded-md text-white hover:bg-blue-100 hover:text-blue-700 transition">
                    Downloads
                </a>
            </li>
            <!-- Add more menu items here as needed -->
        </ul>
    </nav>
</aside> 