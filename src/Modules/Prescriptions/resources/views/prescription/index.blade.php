@extends('layouts.playground')

@section('content')
<x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    <div class="flex flex-col lg:flex-row gap-6 p-8" style="background-color: #EFF2FB;" ng-app="myApp" ng-controller="MainController as main">
        <!-- Left Column -->
        <div class="w-full lg:w-1/3 flex flex-col gap-4">
            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10 rounded-t-2xl"></div>
                <img src="{{ asset('resources/bg_abstract_1.png') }}" alt="CuraLex" class="w-full h-64 object-cover rounded-t-2xl z-0">
                <div class="absolute bottom-6 left-6 text-4xl font-bold z-20">
                    <span class="text-white">Cura</span><span class="text-gray-300">Lex</span>
                </div>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-xl">
                <h3 class="text-lg font-semibold mb-2">File Upload</h3>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center">
                    <input id="fileInput" type="file" accept=".csv,.xlsx,.png,.jpg,.jpeg" class="hidden" onchange="angular.element(this).scope().main.onFileChange(event)">
                    <label for="fileInput" class="cursor-pointer text-gray-500 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        <p class="text-sm">Click or drag file to this area to upload</p>
                        <p class="text-xs mt-1 text-gray-400">Formats accepted are .csv, .xlsx, .jpg, .jpeg, .png</p>
                    </label>
                </div>
                <div ng-show="main.document" class="text-sm text-gray-600 mt-3">
                    Selected file: <strong>@{{ main.document.name }}</strong>
                </div>
                <div class="flex justify-between mt-4">
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded" ng-click="main.clearDocument()">Cancel</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" ng-click="main.translateDocument()">Continue</button>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white p-6 rounded-xl shadow-xl">
                <h2 class="text-xl font-semibold mb-4">My Transactions</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead>
                            <tr class="border-b text-gray-600">
                                <th class="py-2 px-3">S.No</th>
                                <th class="py-2 px-3">Document Name</th>
                                <th class="py-2 px-3">Status</th>
                                <th class="py-2 px-3">View</th>
                                <th class="py-2 px-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="row in main.gridData" class="border-b last:border-0">
                                <td class="py-2 px-3">@{{ $index + 1 }}</td>
                                <td class="py-2 px-3">@{{ row.document_name }}</td>
                                <td class="py-2 px-3">
                                    <span ng-class="{'text-green-600': row.status == 1, 'text-red-600': row.status == 0}">
                                        @{{ row.status == 1 ? 'Success' : 'Failed' }}
                                    </span>
                                </td>
                                <td class="py-2 px-3">
                                    <a href="/prescriptions/view/@{{ row.id }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded">View</a>
                                </td>
                                <td class="py-2 px-3">@{{ row.created_at * 1000 | date:'medium' }}</td>
                            </tr>
                            <tr ng-if="!main.gridData || main.gridData.length === 0">
                                <td colspan="5" class="text-center py-4 text-gray-400">No transactions found.</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination Controls -->
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500" ng-if="main.pagination">
                        <div>
                            Showing @{{ main.pagination.from }} to @{{ main.pagination.to }} of @{{ main.pagination.total }} entries
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 border rounded" ng-disabled="main.pagination.currentPage === 1" ng-click="main.changePage(main.pagination.currentPage - 1)">Previous</button>
                            <span>Page @{{ main.pagination.currentPage }} of @{{ main.pagination.lastPage }}</span>
                            <button class="px-3 py-1 border rounded" ng-disabled="main.pagination.currentPage === main.pagination.lastPage" ng-click="main.changePage(main.pagination.currentPage + 1)">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('prescriptions::angular.main')
@endsection