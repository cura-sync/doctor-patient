<!-- Translation Result Section -->
<div class="mt-8" id="translation-result" ng-if="main.document_translation">
    <h2 class="text-xl font-semibold mb-4 flex items-center"> Translation Result</h2>
    <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-4" ng-if="!main.showMedicineProfile">
        <h3 class="text-lg font-semibold mb-2 flex items-center">Document Translation
            <button ng-click="main.toggleMedicineProfile()" ng-show="main.document_medicine" class="ml-2 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </h3>
        <!-- Render markdown as HTML -->
        <div ng-bind-html="main.renderMarkdown(main.document_translation)"></div>
    </div>

    <!-- Medicine Profile Section -->
    <div ng-if="main.showMedicineProfile" class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-4 transition-all duration-300">
        <h3 class="text-lg font-semibold mb-2 flex items-center">
            Medicine Profile
            <button ng-click="main.toggleMedicineProfile()" class="ml-2 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 18l-6-6 6-6"></path>
                </svg>
            </button>
        </h3>
        <div ng-bind-html="main.renderMarkdown(main.document_medicine)"></div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50" ng-click="main.copyToClipboard()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
            </svg>
            Copy to Clipboard
        </button>
        <button class="flex items-center px-4 py-2 bg-[#449994] text-white rounded-md hover:bg-teal-600" ng-click="main.downloadTranslation()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            Download
        </button>
        <button class="flex items-center px-4 py-2 bg-[#449994] text-white rounded-md hover:bg-teal-600" ng-click="main.resetTranslation()">
            Reset
        </button>
    </div>
</div>