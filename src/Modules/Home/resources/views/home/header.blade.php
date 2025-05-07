<!-- Hero Section with Decorative Background -->
<section class="relative bg-gradient-to-b from-white to-[#abedff]">
    <!-- Decorative Background Lines -->
    <div class="absolute inset-0 overflow-hidden">
        <svg class="absolute top-0 left-1/2 transform -translate-x-1/2" width="1200" height="600" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="600" cy="0" r="600" stroke="#6bc1ff" stroke-opacity="0.8" stroke-width="1" />
            <circle cx="600" cy="0" r="500" stroke="#6bc1ff" stroke-opacity="0.6" stroke-width="1" />
            <circle cx="600" cy="0" r="400" stroke="#6bc1ff" stroke-opacity="0.4" stroke-width="1" />
        </svg>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto flex flex-col lg:flex-row items-center py-20 px-6">
        <div class="lg:w-1/2">
            <div class="inline-block mb-8 px-5 py-2 bg-blue-100 border border-blue-400 text-blue-700 rounded-full text-l font-medium">
                All in one medical dashboard
            </div>
            <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6">Healthcare Simplified</h1>
            <p class="text-lg text-gray-600 mb-8">We provide you various treatments from head to toe using the best product, advanced technology, and affordable price</p>
            <div class="flex space-x-4">
                <a href="#" class="px-6 py-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800">Read More</a>
                {{-- <a href="{{ route('playground') }}" class="px-6 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700">Get Started</a> --}}
            </div>
        </div>
        <div class="lg:w-1/2 mt-12 lg:mt-0 relative">
            <img src="{{ 'resources/header_asset_1.png' }}" alt="Healthcare Professional" class="rounded-xl w-3/4 mx-auto">
        </div>
    </div>
</section>