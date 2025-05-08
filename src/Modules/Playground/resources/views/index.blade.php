@extends('layouts.playground')

@section('content')
<div x-data="{}" :class="$root.sidebarOpen ? 'pl-64' : 'pl-20'" class="transition-all duration-300 bg-[#EFF2FB] min-h-screen px-10 py-8" ng-app="myApp" ng-controller="MainController as main">
    <p class="text-center text-sm mb-10">{{ now()->format('F j, Y') }}</p>
    <div class="flex flex-row gap-8 mb-10">
        <!-- Left Greeting Card -->
        <div class="flex-1 bg-white rounded-3xl flex items-center p-8 shadow-sm min-h-[260px] relative overflow-visible">
            <div class="flex-1 flex flex-col justify-center z-10">
                <div class="text-3xl mb-2">Hi, {{ Auth::user()->name }}!</div>
                <div class="text-gray-400 text-lg">What are we doing today?</div>
            </div>
            <img src="/resources/playground-panda.png" alt="Panda" class="absolute -top-24 right-8 h-72 w-auto z-20 drop-shadow-xl" />
        </div>
        <!-- Right Vertical Cards -->
        <div class="flex flex-col gap-6 w-[320px]">
            <a href="{{ route('prescriptions.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_1.png') center/cover;">
                <span class="drop-shadow">CuraLex</span>
            </a>
            <a href="{{ route('audioTranslation.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_2.png') center/cover;">
                <span class="drop-shadow">CuraVox</span>
            </a>
            <a href="{{ route('alarm.index') }}" class="rounded-2xl h-20 flex items-center justify-center text-white text-2xl font-bold shadow-md transition-transform duration-200 hover:scale-105" style="background: url('/resources/bg_abstract_3.png') center/cover;">
                <span class="drop-shadow">CuraTempus</span>
            </a>
        </div>
    </div>
    <!-- Calendar Summary Cards -->
    <div class="flex flex-row gap-6">

        <!-- Google Calendar Sync Status (Angular Integrated) -->
        <div class="bg-white rounded-2xl p-6 flex flex-col gap-3 shadow-sm w-72">
            <div class="flex items-center justify-between">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 2v4M8 2v4M3 10h18" />
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                </svg>
            </div>
            <div class="font-semibold text-lg">Google Calendar</div>

            <p class="text-sm text-gray-500" ng-if="!main.googleCalendarConnected">
                You haven’t connected your Google Calendar yet.
            </p>
            <a href="/auth/google" ng-if="!main.googleCalendarConnected" class="text-sm bg-blue-600 text-white rounded px-4 py-2 mt-2 text-center">
                Connect
            </a>

            <div ng-if="main.googleCalendarConnected">
                <p class="text-sm text-gray-500">Calendar is connected.</p>
                <!-- Angular Toggle Switch -->
                <div class="flex items-center mt-2">
                    <label class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer"
                            ng-model="main.googleCalendarConnectionStatus"
                            ng-click="main.toggleGoogleCalendarSync()">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all" ng-class="{'bg-blue-600': main.googleCalendarConnectionStatus, 'bg-gray-200': !main.googleCalendarConnectionStatus}"></div>
                        <span class="ml-3 text-sm text-gray-600">
                            Sync is <strong>@{{ main.googleCalendarConnectionStatus ? 'On' : 'Off' }}</strong>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-white rounded-2xl p-6 flex flex-col gap-3 shadow-sm w-72">
            <div class="flex items-center justify-between">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 4h16v16H4z" />
                </svg>
            </div>
            <div class="font-semibold text-lg">Total Transactions</div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</p>
        </div>

        <!-- Most Recent Transaction -->
        <div class="bg-white rounded-2xl p-6 flex flex-col gap-3 shadow-sm w-72">
            <div class="flex items-center justify-between">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3" />
                    <circle cx="12" cy="12" r="10" />
                </svg>
            </div>
            <div class="font-semibold text-lg">Latest Activity</div>
            @if ($mostRecentTransaction)
                <p class="text-sm text-gray-500" style="word-break: break-all;">{{ $mostRecentTransaction->document_name }}</p>
                <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($mostRecentTransaction->created_at)->format('M d, Y h:i A') }}</p>
            @else
                <p class="text-sm text-gray-400">No transactions yet.</p>
            @endif
        </div>

        <!-- Daily Quote -->
        <div class="bg-white rounded-2xl p-6 flex flex-col gap-3 shadow-sm w-72">
            <div class="flex items-center justify-between">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 17h.01M15 17h.01M7 9h10v6H7z" />
                    <path d="M7 9h10V5H7z" />
                </svg>
            </div>
            <div class="font-semibold text-lg">Quote of the Day</div>
            @if (isset($quote['quote']))
                <p class="text-sm italic text-gray-600">“{{ $quote['quote'] }}”</p>
                <p class="text-xs text-right text-gray-500 mt-2">– {{ $quote['author'] }}</p>
            @else
                <p class="text-sm text-gray-400">Unable to fetch quote.</p>
            @endif
        </div>

    </div>
</div>
@include('playground::angular.main')
@endsection
