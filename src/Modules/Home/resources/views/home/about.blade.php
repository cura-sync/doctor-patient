<!-- About Us Floating Section -->
<section class="relative" style="margin-bottom: 300px;">
    <div class="absolute top-[-5rem] left-1/2 transform -translate-x-1/2 w-full max-w-6xl bg-white rounded-3xl shadow-lg p-10 flex flex-col z-20 overflow-visible">
        <!-- Flex Text and Image Section -->
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <!-- Text Content -->
            <div class="md:w-1/2 md:pr-8">
                <div class="text-xs text-gray-500 font-semibold uppercase mb-2 tracking-wide">Who We Are</div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">About Us</h2>
                <p class="text-lg text-gray-700 mb-6">
                    We are passionate about transforming healthcare through innovation. At CuraSync, we strive to bridge the gap between technology and healthcare delivery by offering personalized, accessible, and efficient solutions. Our mission is to empower patients, healthcare providers, and institutions with intelligent tools that simplify processes, enhance care quality, and drive better outcomes. We are committed to making healthcare smarter, more connected, and easier to access for everyone, everywhere.
                </p>
                <a href="#" class="px-6 py-3 rounded-full bg-black text-white font-semibold hover:bg-gray-800">Read More</a>
            </div>

            <!-- Image Content -->
            <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center">
                <img src="{{ asset('resources/about-us.png') }}" alt="About CuraSync" class="rounded-lg shadow-md w-3/4">
            </div>
        </div>

        <!-- Divider -->
        <div class="h-10"></div>

        <!-- Testimonials Marquee Section -->
        <div class="relative w-full overflow-hidden rounded-full bg-white py-4 mt-6">
            <div class="animate-marquee whitespace-nowrap flex space-x-12 text-center text-gray-600 font-semibold text-lg">
                <span class="inline-block">“CuraSync made healthcare accessible like never before!”</span>
                <span class="inline-block">“Our scheduling efficiency improved by 45%!”</span>
                <span class="inline-block">“Incredible technology and exceptional support team!”</span>
                <span class="inline-block">“Simplified complex medical processes easily.”</span>
                <span class="inline-block">“A must-have platform for modern clinics!”</span>
            </div>

            <!-- Left Gradient Fade -->
            <div class="absolute top-0 left-0 h-full w-16 bg-gradient-to-r from-white to-transparent pointer-events-none"></div>

            <!-- Right Gradient Fade -->
            <div class="absolute top-0 right-0 h-full w-16 bg-gradient-to-l from-white to-transparent pointer-events-none"></div>
        </div>
    </div>
</section>

<!-- Spacer below About Us -->
<div class="h-60"></div>