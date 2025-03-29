<!-- Header Section -->
<div class="max-w-6xl mx-auto px-4">
    <!-- Main Hero Section -->
    <x-page-header :pageHeader="$pageHeader" />

    <!-- Features Section -->
    <div class="py-16">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-16">
            How to use the translator?
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="text-teal-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20m10-10H2" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Step 1: Upload document
                </h3>
                <p class="text-gray-500">
                    Start by uploading your medical document to the platform.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="text-teal-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20m10-10H2" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Step 2: Click translate
                </h3>
                <p class="text-gray-500">
                    Once your document is uploaded, click the translate button to start the process.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="text-teal-500 mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20m10-10H2" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    Step 3: Copy or download
                </h3>
                <p class="text-gray-500">
                    After translation, you can either copy the text or download the translated file.
                </p>
            </div>
        </div>
    </div>
</div>