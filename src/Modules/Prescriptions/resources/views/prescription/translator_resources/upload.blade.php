<style>
    .custom-checkbox:checked {
        background-color: #449994; /* Change this to your desired color */
        border-color: #449994;
    }
    .custom-checkbox:hover {
        background-color: #449994; /* Change this to your desired color */
        border-color: #449994;
    }
</style>

<div class="bg-white rounded-lg shadow-sm p-8" ng-hide="main.document_translation">
    <h2 class="text-xl font-semibold mb-6">Upload Your Prescription</h2>
    <input type="file" id="fileInput" accept=".jpg,.jpeg,.png" class="hidden" onchange="angular.element(this).scope().main.onFileChange(event)" />
    <label for="fileInput" class="cursor-pointer">
        <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 flex flex-col items-center justify-center">
            <!-- Document Icon -->
            <svg class="w-8 h-8 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            
            <p class="text-gray-600 mb-1" ng-if="!main.document.name">Drag and drop your file here, or click to select a file</p>
            <p class="text-sm text-gray-400" ng-if="!main.document.name">Supported formats: JPG, JPEG, PNG</p>
            <p class="text-gray-600 mb-1" ng-if="main.document.name">Uploaded file: <span ng-bind="main.document.name"></span></p>
        </div>
    </label>

    <!-- Salt Analysis Checkbox and Clear Selected File -->
    <div class="mt-4 flex justify-between items-center space-x-4">
        <div class="flex items-center">
            <input type="checkbox" id="saltAnalysis" ng-model="main.saltAnalysis" class="mr-2 rounded-md accent-teal-600 custom-checkbox" />
            <label for="saltAnalysis" class="text-gray-600">Do you want salt analysis?</label>
        </div>
        <button class="text-gray-500 hover:text-gray-700" ng-click="main.clearDocument()">Remove</button>
    </div>

    <!-- Translate Button -->
    <button class="w-full bg-[#449994] hover:bg-teal-600 text-white font-medium py-3 px-4 rounded-md mt-4 flex items-center justify-center" ng-click="main.translateDocument()">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
        </svg>
        Translate Document
    </button>
</div>
@include('prescriptions::prescription.translator_resources.authentication-required')