<!-- Audio Translation Results -->
<div class="container mx-auto px-4 max-w-7xl" ng-show="main.translationResponse">
    <div class="mb-4">
        <a href="#" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Upload
        </a>
    </div>

    <h1 class="text-3xl font-bold mb-4">Audio Translation Results</h1>
    
    <div class="text-gray-600 mb-8">
        <span>File: @{{ main.transaltion_file_name }}</span>
        <span class="mx-2">•</span>
        <span>Duration: 3:42</span>
        <span class="mx-2">•</span>
        <span>Processed: @{{ main.transaltion_processed_date }}</span>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button 
                ng-click="main.toggleOriginalTranslatedText('translated')" 
                ng-class="{'border-[#449994] text-[#449994]': main.activeTab === 'translated', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': main.activeTab !== 'translated'}"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                Translated Text
            </button>
            <button 
                ng-click="main.toggleOriginalTranslatedText('original')" 
                ng-class="{'border-[#449994] text-[#449994]': main.activeTab === 'original', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': main.activeTab !== 'original'}"
                class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                Original Transcription
            </button>
        </nav>
    </div>

    <!-- Content Panel -->
    <div id="response-content" class="bg-white rounded-lg shadow-sm p-8">
        <div class="flex justify-between items-center mb-4">
            <h2 id="response-header" class="text-xl font-semibold"></h2>
        </div>
        <p id="response-subheader" class="text-gray-600 mb-4"></p>
        
        <div class="bg-gray-50 rounded-lg p-6 mb-4">
            <p id="response-text" class="text-gray-700 whitespace-pre-line"></p>
        </div>

        <div class="flex justify-end space-x-4">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#449994]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Copy Text
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#449994]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
            </button>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="mt-8 flex justify-between">
        <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#449994]">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Process Another Audio
        </button>
        <button class="inline-flex items-center px-4 py-2 bg-[#449994] text-white rounded-md text-sm font-medium hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#449994]">
            Save to My Documents
            </button>
        </div>
    </div>
</div>