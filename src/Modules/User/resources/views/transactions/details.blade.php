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
                <button onclick="switchTab('originalText')" id="originalTextTab" class="tab-button px-8 py-3 text-center border-b-2 border-transparent">Original Text</button>
                <button onclick="switchTab('prescription')" id="prescriptionTab" class="tab-button px-8 py-3 text-center border-b-2 border-transparent">Prescription Translation</button>
                <button onclick="switchTab('medicine')" id="medicineTab" class="tab-button px-8 py-3 text-center border-b-2 border-transparent">Salt Analysis</button>
            </div>
        </div>
        
        <!-- Tab Content -->
        <div class="p-6">
            <!-- Original Text Tab -->
            <div id="originalTextContent" class="tab-content">
                <h3 class="text-lg font-bold mb-3">Original Text</h3>
                <p class="text-gray-600" ng-bind-html="main.transaction_details.original_text"></p>
            </div>
            
            <!-- Prescription Tab -->
            <div id="prescriptionContent" class="tab-content hidden">
                <h3 class="text-lg font-bold mb-3">Prescription Translation</h3>
                <p class="text-gray-600" ng-bind-html="main.transaction_details.prescription_translation"></p>
            </div>
            
            <!-- Medicine Tab -->
            <div id="medicineContent" class="tab-content hidden">
                <h3 class="text-lg font-bold mb-3">Medicine Translation</h3>
                <p class="text-gray-600" ng-bind-html="main.transaction_details.medicine_translation"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(function(tab) {
            tab.classList.add('hidden');
        });
        // Show the selected tab content
        document.getElementById(tabName + 'Content').classList.remove('hidden');
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(function(button) {
            button.classList.remove('border-b-2', 'border-transparent');
        });
        // Add active class to the selected tab
        document.getElementById(tabName + 'Tab').classList.add('border-b-2', 'border-blue-500');
    }
</script>