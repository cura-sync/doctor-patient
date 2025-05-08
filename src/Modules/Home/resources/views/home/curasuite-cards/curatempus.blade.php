<!-- CuraTempus Card Section -->
<section class="relative w-full max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
        
        <!-- Left Side: Text -->
        <div class="md:w-1/2 flex flex-col items-start space-y-4">
            <!-- Badge -->
            <div class="h-6 w-6 rounded-full bg-red-400 text-white flex items-center justify-center text-xs font-bold">
                #3
            </div>

            <!-- Title -->
            <h2 class="text-4xl font-bold text-gray-900">
                Cura<span class="text-gray-500">Tempus</span>
            </h2>

            <!-- Paragraph -->
            <p class="text-lg text-gray-700">
                Manage time smarter with CuraTempus. We offer scheduling solutions designed for the needs of modern healthcare providers.
            </p>

            <!-- Button -->
            <a href="{{ route('curatempus') }}" class="px-6 py-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800 mt-4 w-max">
                Know More
            </a>
        </div>

        <!-- Right Side: Image -->
        <div class="md:w-1/2 relative flex justify-center">
            <div class="relative w-80 h-90">
                <!-- Background Image -->
                <img src="{{ asset('resources/bg_abstract_3.png') }}" alt="CuraTempus" class="w-full h-full object-cover rounded-2xl">

                <!-- Only Cura inside -->
                <div class="absolute bottom-6 right-2 flex items-end">
                    <span class="text-white curasuite-card-text">Cura</span>
                </div>
                <!-- Tempus outside floating -->
                <div class="absolute bottom-5 left-[calc(100%)] flex items-end">
                    <span class="text-[#d0728c] curasuite-card-text">Tempus</span>
                </div>
            </div>

        </div>

    </div>
</section>