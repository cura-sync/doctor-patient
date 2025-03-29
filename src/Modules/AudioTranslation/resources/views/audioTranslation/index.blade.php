<x-app-layout>
    <div ng-app="myApp" ng-controller="MainController as main" class="min-h-screen">
        <loading></loading>
        <x-page-header :pageHeader="$pageHeader" />
        
        @include('audiotranslation::audioTranslation.audio_upload')
        @include('audiotranslation::audioTranslation.translation_result')
    </div>
    @include('audiotranslation::audioTranslation.angular.main')
</x-app-layout>