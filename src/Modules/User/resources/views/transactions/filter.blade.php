<div id="filterModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-black opacity-50 fixed inset-0"></div>
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 z-10">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold mb-4">Filter Transactions</h2>
            <button class="text-gray-500 mb-4" ng-click="main.closeModal()">✖</button>
        </div>
        <div>
            <label class="block mb-2">Document Name</label>
            <input type="text" ng-model="main.document_name" placeholder="Enter document name" class="border border-gray-300 rounded-lg w-full p-2 mb-4">
        </div>
        <div>
            <label class="block mb-2">Transaction Dates</label>
            <div class="flex space-x-4">
                <input type="date" ng-model="main.transaction_date_from" placeholder="From" class="border border-gray-300 rounded-lg w-full p-2 mb-4">
                <input type="date" ng-model="main.transaction_date_to" placeholder="To" class="border border-gray-300 rounded-lg w-full p-2 mb-4">
            </div>
        </div>
        <div>
            <label class="block mb-2">Transaction Type</label>
            <select ng-model="main.transaction_type" class="border border-gray-300 rounded-lg w-full p-2 mb-4">
                <option value="">Select type</option>
                <option ng-repeat="type in main.transactionTypes" value="@{{type}}">@{{type}}</option>
            </select>
        </div>
        <div>
            <label class="block mb-2">Status</label>
            <select ng-model="main.status" class="border border-gray-300 rounded-lg w-full p-2 mb-4">
                <option value="">Select status</option>
                <option ng-repeat="status in main.transactionStatuses" value="@{{status}}">@{{status}}</option>
            </select>
        </div>
        <div class="flex justify-between">
            <button ng-click="main.resetFilters()" class="text-gray-500">Reset</button>
            <button ng-click="main.applyFilters()" class="bg-teal-600 text-white rounded-lg px-4 py-2">Apply Filters</button>
        </div>
    </div>
</div>