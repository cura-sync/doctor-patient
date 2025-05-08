@extends('layouts.playground')

@section('content')
<div class="flex flex-col min-h-screen" style="background-image: url('{{ asset('resources/bg_abstract_1.png') }}'); background-size: cover; background-position: center;" ng-app="myApp" ng-controller="AlarmController as main">
    <loading></loading>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    <div class="flex flex-1" ng-init="main.setupConfigureData('{{ request()->route('id') }}')">
        <div class="flex-1 flex flex-col">
            <main class="flex-1">
                <div class="max-w-6xl mx-auto mt-10 mb-8">
                    <div class="bg-white rounded-2xl shadow-xl p-10 min-h-[500px] relative">
                        <div class="flex justify-between items-center mb-8">
                            <h1 class="text-3xl font-semibold text-gray-800">Configure Dosage</h1>
                        </div>

                        <div class="overflow-x-auto max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-900 scrollbar-track-gray-100">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700 text-left text-sm uppercase tracking-wider">
                                        <th class="py-3 px-4 w-1/3">Medicine</th>
                                        <th class="py-3 px-4 w-1/2">Time</th>
                                        <th class="py-3 px-4 text-right w-1/6">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(medicine, details) in main.document_dosage" class="border-t text-sm">
                                        <td class="py-3 px-4 font-medium text-gray-800">@{{ medicine }}
                                            <p>
                                            <span class="text-xs text-gray-500">
                                                @{{ details.notes }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div ng-if="details.frequency">
                                                <div class="grid grid-cols-@{{ main.highest_frequency }} gap-3">
                                                    <input type="time" 
                                                        ng-repeat="i in [].constructor(details.frequency) track by $index" 
                                                        ng-model="details.schedule[$index]"
                                                        ng-disabled="$index >= details.frequency || details.saved"
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                                        ng-class="{'bg-gray-100': $index >= details.frequency || details.saved}">
                                                </div>
                                            </div>
                                            <div ng-if="!details.frequency" class="italic text-gray-500">
                                                @{{ details.notes || 'No specific timing noted' }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="inline-flex gap-2">
                                                <button ng-click="main.saveMedicine(medicine)" class="text-green-600 hover:text-green-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                                <button ng-click="main.removeMedicine(medicine)" class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 text-right">
                            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow" ng-click="main.saveDosage()">
                                Save Dosage
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('prescriptions::angular.alarm')
</div>
@endsection
