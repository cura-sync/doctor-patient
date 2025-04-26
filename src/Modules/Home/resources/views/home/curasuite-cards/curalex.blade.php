<!-- CuraLex Card Section -->
<section class="relative w-full max-w-7xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
        
        <!-- Left Side: Text -->
        <div class="md:w-1/2 flex flex-col items-start space-y-4">
            <!-- Badge -->
            <div class="h-6 w-6 rounded-full bg-green-500 text-white flex items-center justify-center text-xs font-bold">
                #1
            </div>

            <!-- Title -->
            <h2 class="text-4xl font-bold text-gray-900">
                Cura<span class="text-gray-500">Lex</span>
            </h2>

            <!-- Paragraph -->
            <p class="text-lg text-gray-700">
                If you're looking to make sense of complex medical info, you'll find help with our AI-powered simplifier. We study how to make healthcare clear, so understanding is easy.
            </p>

            <!-- Button -->
            <a href="{{ route('curalex') }}" class="px-6 py-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800 mt-4 w-max">
                Know More
            </a>
        </div>

        <!-- Right Side: Image -->
        <div class="md:w-1/2 relative flex justify-center">
            <div class="relative w-80 h-90">
                <!-- Background Image -->
                <img src="{{ asset('resources/bg_abstract_1.png') }}" alt="CuraLex" class="w-full h-full object-cover rounded-2xl">

                <!-- Only Cura inside -->
                <div class="absolute bottom-6 right-2 flex items-end">
                    <span class="text-white curasuite-card-text">Cura</span>
                </div>
                <!-- Lex outside floating -->
                <div class="absolute bottom-5 left-[calc(100%)] flex items-end">
                    <span class="text-gray-700 curasuite-card-text">Lex</span>
                </div>
            </div>

        </div>

    </div>
</section>