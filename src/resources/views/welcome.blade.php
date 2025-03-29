<x-app-layout>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-6 pt-32 pb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                <!-- Left Column -->
                <div class="space-y-4">
                    <h1 class="text-4xl font-semibold text-gray-900 leading-tight">
                        Effortlessly understand your medical documents
                    </h1>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        AI-powered translations for prescriptions, diagnostics, and bills – simplified just for you.
                    </p>
                    <div class="flex gap-4 pt-4">
                        @guest
                            <a href="/login" class="px-5 py-2.5 bg-[#449994] text-white rounded-md hover:bg-emerald-600 transition-colors">
                                Get Started
                            </a>
                        @else
                            <a href="/prescriptions" class="px-5 py-2.5 bg-[#449994] text-white rounded-md hover:bg-emerald-600 transition-colors">
                                Get Started
                            </a>
                        @endguest
                        <a href="#features" class="px-5 py-2.5 text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="bg-gray-100 rounded-2xl aspect-square flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
    
            <!-- Features Section -->
            <div class="mt-32" id="features">
                <h2 class="text-3xl font-semibold text-center text-gray-900 mb-16">Why Use This Tool?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature Cards -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm">
                        <div class="text-[#449994] mb-6">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Understand prescriptions</h3>
                        <p class="text-gray-500">Simplify complex medical instructions</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm">
                        <div class="text-[#449994] mb-6">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Decode medical reports</h3>
                        <p class="text-gray-500">Get clear insights from your diagnostics</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm">
                        <div class="text-[#449994] mb-6">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Break down bills</h3>
                        <p class="text-gray-500">Understand your medical expenses easily</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm">
                        <div class="text-[#449994] mb-6">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Secure & private</h3>
                        <p class="text-gray-500">Your data stays protected at all times</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>