<x-app-layout>
    <div ng-app="myApp" ng-controller="AlarmController as main" class="min-h-screen">
        <loading></loading>
        <div class="container mx-auto px-4 max-w-7xl">
            <!-- Main Content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <x-page-header :pageHeader="$pageHeader" />
                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-8">
                    <nav class="flex space-x-8">
                        <a href="#" ng-class="{'border-b-2 border-emerald-500 text-emerald-600': !showCalendar, 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': showCalendar}" class="py-4 px-1 text-sm font-medium" ng-click="showCalendar = false">Upload</a>
                        <a href="#" ng-class="{'border-b-2 border-emerald-500 text-emerald-600': showCalendar, 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': !showCalendar}" class="py-4 px-1 text-sm font-medium" ng-click="showCalendar = true">Calendar</a>
                    </nav>
                </div>

                @include('prescriptions::alarm.alarm_resources.upload')
                @include('prescriptions::alarm.alarm_resources.calendar.calendar_body')
                @include('prescriptions::alarm.alarm_resources.calendar.day_medication')
                @include('prescriptions::alarm.alarm_resources.stats')
                @include('prescriptions::alarm.alarm_resources.finalize_medication')
            </div> 
        </div>
    </div>
    @include('prescriptions::angular.alarm')
</x-app-layout>