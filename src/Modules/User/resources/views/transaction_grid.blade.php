<x-app-layout>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    <div class="py-12 justify-items-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Your Transactions
        </h1>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl text-center">
            View and manage your transaction history.
        </p>
    </div>
    <div class="py-12" ng-app="myApp" ng-controller="MainController as main">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900">
                            Transaction History
                        </h3>
                    </div>

                    <!-- Existing filter and search -->
                    @include('user::transactions.filter')
                    @include('user::transactions.details')

                    <!-- Search Bar -->
                    <div class="mb-6 relative flex items-center justify-between">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" ng-model="main.document_name" placeholder="Search document name..." 
                               class="pl-10 pr-4 py-2 w-full max-w-md border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               ng-keypress="$event.key === 'Enter' && main.applyFilters()">
                        <button ng-click="main.openModal()" class="ml-4 px-4 py-2 bg-white border border-gray-300 rounded-lg flex items-center hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                            <span ng-if="main.filter_applied" class="ml-2 h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>

                    <!-- Table content -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 text-gray-600">S.No</th>
                                    <th class="text-left py-3 px-4 text-gray-600">Document Name</th>
                                    <th class="text-left py-3 px-4 text-gray-600">Transaction Date</th>
                                    <th class="text-left py-3 px-4 text-gray-600">Transaction Type</th>
                                    <th class="text-left py-3 px-4 text-gray-600">Status</th>
                                    <th class="text-left py-3 px-4 text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b hover:bg-gray-50" ng-repeat="transaction in main.transactions">
                                    <td class="py-3 px-4">@{{$index + 1 + (main.current_page - 1) * 5}}</td>
                                    <td class="py-3 px-4">@{{transaction.document_name}}</td>
                                    <td class="py-3 px-4">@{{transaction.transaction_created_at | date:'dd-MMM-yyyy'}}</td>
                                    <td class="py-3 px-4">@{{transaction.resource_name}}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-full 
                                        @{{ transaction.success == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            @{{ transaction.success == 1 ? 'Success' : 'Failed' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="relative" ng-click="$event.stopPropagation()">
                                            <button class="text-gray-600 hover:text-gray-900" ng-click="transaction.showDropdown = !transaction.showDropdown">...</button>
                                            <div ng-show="transaction.showDropdown" class="absolute right-0 mt-2 w-44 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                                                <button ng-click="main.viewDetails(transaction)" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">View Details</button>
                                                <button ng-click="main.deleteRecord(transaction)" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Delete Record</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <div class="flex justify-center items-center mt-8" ng-show="main.total_pages > 1">
                            <div class="flex items-center space-x-1">
                                <a href="#" ng-disabled="main.current_page == 1" ng-click="main.changePage(main.current_page - 1)" 
                                   class="flex items-center px-3 py-2 border border-gray-300 rounded-l-lg text-gray-500 bg-white hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-1">Previous</span>
                                </a>
                                <span ng-repeat="page in [].constructor(main.total_pages) track by $index">
                                    <a href="#" ng-click="main.changePage($index + 1)" 
                                       class="flex items-center px-3 py-2 border border-gray-300 text-gray-500 bg-white hover:bg-gray-50" 
                                       ng-class="{'bg-gray-300 text-white': main.current_page == $index + 1}">
                                        @{{$index + 1}}
                                    </a>
                                </span>
                                <a href="#" ng-disabled="main.current_page == main.total_pages" ng-click="main.changePage(main.current_page + 1)" 
                                   class="flex items-center px-3 py-2 border border-gray-300 rounded-r-lg text-gray-500 bg-white hover:bg-gray-50">
                                    <span class="mr-1">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user::angular.main')
</x-app-layout>