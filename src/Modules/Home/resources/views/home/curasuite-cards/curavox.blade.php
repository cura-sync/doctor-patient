<!-- CuraVox Card Section -->
<section class="relative w-full max-w-7xl mx-auto px-6 py-20 bg-blue-100 rounded-3xl">
    <div class="flex flex-col md:flex-row-reverse items-center md:items-start gap-8">
        
        <!-- Right Side: Text -->
        <div class="md:w-1/2 flex flex-col items-start space-y-4">
            <!-- Badge -->
            <div class="h-6 w-6 rounded-full bg-yellow-400 text-white flex items-center justify-center text-xs font-bold">
                #2
            </div>

            <!-- Title -->
            <h2 class="text-4xl font-bold text-gray-900">
                Cura<span class="text-gray-500">Vox</span>
            </h2>

            <!-- Paragraph -->
            <p class="text-lg text-gray-700">
                Our voice recognition and NLP platform simplifies doctor-patient communications, making consultations faster, smarter, and smoother.
            </p>

            <!-- Button -->
            <a href="{{ route('curavox') }}" class="px-6 py-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800 mt-4 w-max">
                Know More
            </a>
        </div>

        <!-- Left Side: Image -->
        <div class="md:w-1/2 relative flex justify-center">
            <div class="relative w-80 h-90">
                <!-- Background Image -->
                <img src="{{ asset('resources/bg_abstract_2.png') }}" alt="CuraVox" class="w-full h-full object-cover rounded-2xl">

                <!-- Only Cura inside -->
                <div class="absolute top-6 right-2 flex items-start">
                    <span class="text-white curasuite-card-text">Cura</span>
                </div>
                <!-- Vox outside floating -->
                <div class="absolute top-6 right-[-110px] flex items-start">
                    <span class="text-[#eefe03] curasuite-card-text">Vox</span>
                </div>
            </div>

        </div>

    </div>
</section>