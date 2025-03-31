<div id="prescriptionModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50">
    <div class="relative mx-auto my-16 max-w-4xl bg-white rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-5 border-b">
            <h2 class="text-xl font-bold">Transaction Details</h2>
            <button ng-click="main.closeDetailsModal()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Tabs -->
        <div class="bg-gray-100 p-4">
            <div class="flex">
                <button ng-repeat="(index, header) in main.transaction_details.headers track by index" 
                        ng-click="main.switchTab(index)" 
                        ng-id="'tab-' + index"
                        class="tab-button px-8 py-3 text-center border-b-2" 
                        ng-class="{'border-transparent': !main.activeTab === index, 'border-blue-500': main.activeTab === index}">
                    @{{ header }}
                </button>
            </div>
        </div>
        
        <!-- Tab Content -->
        <div class="p-6">
            <div ng-if="main.transaction_details.content.length > 0">
                <div ng-repeat="(index, content) in main.transaction_details.content track by index" 
                     ng-show="main.activeTab === index" 
                     class="tab-content">
                    <h3 class="text-lg font-bold mb-3">@{{ main.transaction_details.headers[index] }}</h3>
                    <p class="text-gray-600" ng-bind-html="content"></p>
                </div>
            </div>
            <div ng-if="main.transaction_details.content.length === 0" class="text-center text-gray-500">
                No content available
            </div>
        </div>
    </div>
</div>

<script>
    // Remove the old switchTab function as we're now handling this in the controller
</script>