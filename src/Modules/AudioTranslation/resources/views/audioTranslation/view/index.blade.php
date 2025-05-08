@extends('layouts.playground')

@section('content')
<div class="flex flex-col min-h-screen" style="background-image: url('{{ asset('resources/bg_abstract_3.png') }}'); background-size: cover; background-position: center;">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    <div class="flex flex-1">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header is included via layout -->
            <main class="flex-1">
                <div class="max-w-6xl mx-auto mt-10 mb-8">
                    <div class="bg-white rounded-2xl shadow-xl p-10 min-h-[500px] relative" ng-app="myApp" ng-controller="MainController as main">
                        <!-- Go Back Button -->
                        <a href="{{ route('prescriptions.index') }}" class="flex items-center text-blue-700 hover:underline mb-6 font-medium focus:outline-none">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                            Go Back
                        </a>
                        <!-- Transaction Details Card -->
                        <div class="mb-8">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-sm">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Document Name</div>
                                    <div class="font-semibold text-gray-800">@{{ main.data.document_name || '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Created Date</div>
                                    <div class="font-semibold text-gray-800">@{{ main.data.created_at*1000 | date:'medium' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Status</div>
                                    <span ng-class="{
                                        'bg-green-500 text-white': main.data.status == 1,
                                        'bg-red-500 text-white': main.data.status == 0
                                    }" class="font-semibold rounded-full px-3 py-1 text-xs inline-block">
                                        @{{ main.data.status == 1 ? 'Success' : 'Failed' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- End Transaction Details Card -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                            <h1 class="text-3xl font-semibold">
                                <span ng-if="main.activeSection === 'translated'">Translated Text</span>
                                <span ng-if="main.activeSection === 'original'">Original text</span>
                            </h1>
                            <div class="flex gap-2">
                                <a href="#" ng-click="main.showSection('translated')" class="text-sm font-medium text-gray-700 hover:text-blue-700 flex items-center gap-1 group"
                                   ng-class="{'font-bold underline text-blue-700': main.activeSection === 'translated'}">
                                    Translated Text
                                </a>
                                <span class="text-gray-400">|</span>
                                <a href="#" ng-click="main.showSection('original')" class="text-sm font-medium text-gray-700 hover:text-blue-700 flex items-center gap-1 group"
                                   ng-class="{'font-bold underline text-blue-700': main.activeSection === 'original'}">
                                    Original Text
                                </a>
                                <span class="text-gray-400">|</span>
                                <a href="#" ng-click="main.downloadPrescription()" class="text-sm font-medium text-gray-700 hover:text-blue-700 flex items-center gap-1 group">
                                    Download
                                </a>
                            </div>
                        </div>
                        <hr class="mb-6">
                        <div class="min-h-[250px]">
                            <div class="text-base text-gray-700 mb-2" ng-if="main.activeSection === 'original'" ng-bind-html="main.data.original_text">
                                <!-- HTML content for original text -->
                            </div>
                            <div class="text-base text-gray-700 mb-2" ng-if="main.activeSection === 'translated'" ng-bind-html="main.data.simplified_text">
                                <!-- HTML content for translated text -->
                            </div>
                        </div>
                        <div class="absolute bottom-8 right-8" ng-if="main.activeSection === 'original'">
                            <button class="bg-[#7C3AED] hover:bg-[#5B21B6] text-white px-6 py-2 rounded flex items-center gap-2" ng-click="main.copyText(main.data.original_text)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                                Copy
                            </button>
                        </div>
                        <div class="absolute bottom-8 right-8" ng-if="main.activeSection === 'translated'">
                            <button class="bg-[#7C3AED] hover:bg-[#5B21B6] text-white px-6 py-2 rounded flex items-center gap-2" ng-click="main.copyText(main.data.simplified_text)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15V5a2 2 0 012-2h10"/></svg>
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@include('audiotranslation::audioTranslation.view.angular.main')
@endsection
