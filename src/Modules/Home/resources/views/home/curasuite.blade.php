<section id="curasuite" class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col items-center mb-16">
            <button class="px-10 py-4 mb-6 rounded-2xl border border-gray-300 text-black font-semibold text-2xl tracking-wide shadow-none bg-white hover:bg-gray-50 transition" style="pointer-events: none;">
                EXPLORE
            </button>
            <h2 class="text-5xl font-bold text-black">
                The <span class="text-[#661FFF]">CURASUITE</span>
            </h2>
        </div>

        @include('home::home.curasuite-cards.curalex')
        @include('home::home.curasuite-cards.curavox')
        @include('home::home.curasuite-cards.curatempus')
    </div>
</section>