<!-- Finalize Medication Modal Container -->
<div id="dosage-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center" ng-show="main.document_dosage">
    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6">
            <h2 class="text-2xl font-bold">Finalize Dosage</h2>
            <button class="text-gray-400 hover:text-gray-500" ng-click="main.closeModal()">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="px-6 py-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-900 scrollbar-track-gray-100">
            <div class="grid grid-cols-[1.5fr,3fr,1fr] gap-4 mb-4 text-center font-bold">
                <div class="text-gray-700">Medicine</div>
                <div class="text-gray-700">Time</div>
                <div class="text-gray-700 text-right">Actions</div>
            </div>
            <hr class="my-4 border-t border-gray-200 w-full" />
            
            <!-- Medicine Input Rows -->
            <div ng-repeat="(medicine, details) in main.document_dosage" class="grid grid-cols-[1.5fr,3fr,1fr] gap-4 items-center mb-4">
                <div>
                    <div class="w-full px-4 py-2 text-gray-700">@{{ medicine }}</div>
                </div>
                <div ng-if="details.frequency">
                    <div class="grid grid-cols-@{{ main.highest_frequency }} gap-4">
                        <input type="time" 
                                ng-repeat="i in [].constructor(details.frequency) track by $index" 
                                ng-model="details.schedule[$index]"
                                ng-disabled="$index >= details.frequency || details.saved"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-center focus:outline-none focus:ring-2 focus:ring-teal-500"
                                ng-class="{'bg-gray-50': $index >= details.frequency || details.saved}">
                    </div>
                </div>
                <div ng-if="!details.frequency" class="px-4 py-2 text-gray-600 italic">
                    @{{ details.notes || 'No specific timing noted' }}
                </div>
                <div class="flex space-x-2 justify-end">
                    <button class="text-green-500 p-1" ng-click="main.saveMedicine(medicine)">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                    <button class="text-red-500 p-1" ng-click="main.removeMedicine(medicine)">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="flex justify-end p-6">
            <button class="bg-[#449994] hover:bg-[#449994] text-white font-medium py-3 px-8 rounded-lg" ng-click="main.saveDosage()">
                Save Dosage
            </button>
        </div>
    </div>
</div>