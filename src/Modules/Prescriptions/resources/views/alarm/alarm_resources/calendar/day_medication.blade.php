<!-- Calendar Day Modal -->
<div id="medication-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold">@{{ main.selectedDate | date:'EEEE, MMMM d, yyyy' }}</h2>
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
                        <button class="px-3 py-1 rounded text-sm font-medium"
                                ng-class="{'bg-emerald-100 text-emerald-700': schedule.taken, 'bg-gray-100 text-gray-700 hover:bg-gray-200': !schedule.taken}"
                                ng-click="schedule.taken = !schedule.taken">
                            @{{ schedule.taken ? 'Taken' : 'Mark as Taken' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>