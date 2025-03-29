<!-- Audio Upload Section -->
<div class="container mx-auto px-4 max-w-7xl" ng-show="!main.translationResponse">
    <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
        <div class="flex flex-col items-center justify-center" ng-show="!main.audioFile">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold mb-2">Upload your audio file</h2>
            <p class="text-gray-500 mb-6">Drag and drop your file here, or click to browse</p>
            <p class="text-sm text-gray-400 mb-4">Supported formats: MP3, WAV, M4A</p>
            <button class="px-6 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <label for="fileInput" class="cursor-pointer">
                        <input type="file" id="fileInput" accept=".mp3,.wav,.m4a" class="hidden" onchange="angular.element(this).scope().main.onFileChange(event)" />
                        Choose File
                    </label>
            </button>
        </div>

        <div class="flex flex-col items-center justify-center" ng-show="main.audioFile">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold mb-2">Uploaded file</h2>
            <p class="text-gray-500 mb-6">@{{ main.audioFile.name }}</p>
            <button ng-click="main.clearAudioFile()" class="px-6 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Remove File
            </button>
        </div>
    </div>

    <!-- Translate Button -->
    <div class="mt-8">
        <button ng-click="main.transcribeAudio()" class="w-full bg-[#449994] hover:bg-teal-600 text-white rounded-md py-3 px-4 text-sm font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
            Translate Audio
        </button>
    </div>
</div>