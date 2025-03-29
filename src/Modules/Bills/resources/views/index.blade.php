<x-app-layout>
    <div class="min-h-screen" ng-app="myApp" ng-controller="MainController as main">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <loading></loading>
            @include('bills::bills_resources.header')
            @include('bills::bills_resources.upload')
            @include('bills::bills_resources.result')           
        </div>
    </div>
    @include('bills::angular.main')
</x-app-layout>