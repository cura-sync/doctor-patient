@extends('layouts.playground')

@section('content')
<div class="flex flex-col min-h-screen" style="background-image: url('{{ asset('resources/bg_abstract_1.png') }}'); background-size: cover; background-position: center;">
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />
    <div class="flex flex-1" ng-app="myApp" ng-controller="AlarmController as main">
        <div class="flex-1 flex flex-col">
            <main class="flex-1">
                <div class="max-w-6xl mx-auto mt-10 mb-8">
                    <div class="bg-white rounded-2xl shadow-xl p-10 min-h-[600px] relative">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-3xl font-semibold">Calendar</h1>
                            <button class="bg-gray-700 text-white px-4 py-2 rounded flex items-center gap-2" ng-click="main.addDosageToGoogleCalendar()">
                                <span ng-if="!main.scope.loading" class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Sync Google Calendar
                                </span>
                                <span ng-if="main.scope.loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0v4a8 8 0 100 16v-4l3.5 3.5L12 24v-4a8 8 0 01-8-8z"></path>
                                    </svg>
                                    Syncing...
                                </span>
                            </button>
                        </div>

                        <!-- Month Navigation -->
                        <div class="flex items-center justify-between mb-4 border-b pb-2">
                            <div class="flex items-center gap-3">
                                <button class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" ng-click="main.calendarNav.previousMonth()">&lt;</button>
                                <span class="font-medium">@{{ main.currentMonth.toLocaleString('default', { month: 'long' }) }} @{{ main.currentMonth.getFullYear() }}</span>
                                <button class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300" ng-click="main.calendarNav.nextMonth()">&gt;</button>
                            </div>
                            <button class="ml-2 bg-gray-300 px-3 py-1 rounded" ng-click="main.calendarNav.goToToday()">Today</button>
                        </div>

                        <!-- Week Days -->
                        <div class="grid grid-cols-7 text-center text-sm text-gray-500 font-semibold mb-2">
                            <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="grid grid-cols-7 gap-2">
                            <div ng-repeat="n in main.scope.range(main.calendar.getFirstDayOfMonth(main.currentMonth)) track by $index"></div>
                            <div ng-repeat="day in main.scope.range(main.calendar.getDaysInMonth(main.currentMonth)) track by $index"
                                 class="relative border border-gray-200 rounded-lg p-2 min-h-[100px] cursor-pointer hover:bg-gray-50"
                                 ng-class="{'bg-blue-50': main.calendar.isToday(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), $index + 1)}"
                                 ng-click="main.selectDate(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), $index + 1)">
                                <div class="absolute top-2 left-2 text-xs font-medium">@{{ $index + 1 }}</div>
                                <div class="mt-6 space-y-1 max-h-24 overflow-y-auto">
                                    <span ng-repeat="med in main.medicationDays[main.calendar.formatDateKey(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), $index + 1)] track by $index"
                                        class="block bg-purple-100 text-purple-800 text-xs rounded px-1 truncate">
                                        @{{ med.name }} - @{{ med.time }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Modal -->
                    <div ng-if="main.showCalendarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] flex flex-col">
                            <!-- Modal Header -->
                            <div class="flex justify-between items-center p-6 border-b">
                                <h2 class="text-2xl font-bold">
                                    @{{ main.selectedDate | date:'EEEE, MMMM d, yyyy' }}
                                </h2>
                                <button class="text-gray-400 hover:text-gray-500" ng-click="main.closeCalendarModal()">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="p-6 overflow-y-auto">
                                <div ng-if="main.selectedDayMedications.length === 0" class="text-center text-gray-500 py-8">
                                    No medications scheduled for this day.
                                </div>

                                <div ng-repeat="medication in main.selectedDayMedications" class="mb-6 last:mb-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-medium text-lg">@{{ medication.name }}</h3>
                                        <span ng-if="medication.notes" class="text-sm text-gray-500">@{{ medication.notes }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <div ng-repeat="schedule in medication.schedule" 
                                            class="flex items-center justify-between p-3 rounded-lg"
                                            ng-class="{'bg-emerald-50': schedule.taken, 'bg-gray-50': !schedule.taken}">
                                            <span class="text-gray-700">@{{ schedule.time }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>
@include('prescriptions::angular.alarm')
@endsection