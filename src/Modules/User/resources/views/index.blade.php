<x-app-layout>
    <div class="container mx-auto px-4 py-6" ng-app="myApp" ng-controller="MainController as main">
        <loading></loading>
        <x-page-header :pageHeader="$pageHeader" />

        <div class="flex grid grid-cols-1 md:grid-cols-2 gap-6 justify-center">
            <!-- Transactions Card -->
            <div class="bg-white rounded-lg border p-6">
                <div class="flex items-start mb-4">
                    <div class="text-emerald-500 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Your Transactions</h2>
                        <p class="text-gray-600">View and manage your transaction history</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-gray-600">Total Transactions</div>
                            <div class="text-4xl font-bold text-emerald-500">@{{ main.total_data }}</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('user.transactions') }}" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-4 rounded">
                    View All Transactions
                </a>
            </div>

            <!-- Google Calendar Card -->
            <div class="bg-white rounded-lg border p-6">
                <div class="flex items-start mb-4">
                    <div class="text-blue-500 mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Google Calendar</h2>
                        <p class="text-gray-600">Connect your Google Calendar to manage appointments</p>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-center py-8" ng-if="!main.userGoogleConnection">
                    <p class="text-gray-600 text-center mb-6">Sync your medical appointments with Google Calendar</p>
                    <a href="{{ url('/auth/google') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded text-center">
                        Connect Google Calendar
                    </a>
                </div>

                <div class="flex flex-row justify-between py-8" ng-if="main.userGoogleConnection">
                    <p class="text-gray-600 text-center mb-6">Toggle google calendar sync</p>
                    <label class="dptm-switch">
                        <input type="checkbox" ng-model="main.userGoogleConnectionStatus" ng-change="main.toggleGoogleConnection()">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    @include('user::angular.main')
</x-app-layout>