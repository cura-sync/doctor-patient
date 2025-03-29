<x-app-layout>
    <div ng-app="myApp" ng-controller="MainController as main" class="min-h-screen">
        <loading></loading>
        @include('prescriptions::prescription.translator_resources.header')
        <div class="container mx-auto px-4 max-w-7xl">
            @include('prescriptions::prescription.translator_resources.upload')
            @include('prescriptions::prescription.translator_resources.result')
        </div>
    </div>
    @include('prescriptions::angular.main')
</x-app-layout>