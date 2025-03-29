<!-- Calendar Section -->
<div class="bg-white rounded-lg shadow-sm p-7" ng-show="showCalendar">
    <!-- Sync Button -->
    <div class="flex justify-end mb-4">
        <button class="flex items-center px-4 py-2 bg-[#449994] text-white rounded-md hover:bg-teal-600" ng-click="main.addDosageToGoogleCalendar()">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m-4 6H4m0 0l4 4m-4-4l4-4"/>
            </svg>
            Sync with Google Calendar
        </button>
    </div>

    <!-- Calendar Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-xl font-semibold">@{{ main.currentMonth | date:'MMMM yyyy' }}</h2>
        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-100" ng-click="main.previousMonth()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" ng-click="main.goToToday()">
                Today
            </button>
            <button class="p-2 rounded-full hover:bg-gray-100" ng-click="main.nextMonth()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-lg overflow-hidden">
        <!-- Day Headers -->
        <div class="bg-gray-50 py-2 text-center text-sm font-medium text-gray-500" ng-repeat="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
            @{{ day }}
        </div>

        <!-- Calendar Days -->
        <div class="relative bg-white h-24"
             ng-repeat="n in [] | range:main.calendar.getDaysInMonth(main.currentMonth) + main.calendar.getFirstDayOfMonth(main.currentMonth)"
             ng-class="{'opacity-50': n < main.calendar.getFirstDayOfMonth(main.currentMonth)}">
            <div ng-if="n >= main.calendar.getFirstDayOfMonth(main.currentMonth)"
                 class="h-full p-2 cursor-pointer hover:bg-gray-50 flex flex-col"
                 ng-class="{
                    'bg-emerald-50': main.calendar.isToday(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1),
                    'ring-1 ring-emerald-600': main.calendar.isToday(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1)
                 }"
                 ng-click="main.selectDate(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1)">
                
                <!-- Day Number -->
                <span class="text-sm" 
                      ng-class="{
                        'font-bold text-emerald-600': main.calendar.isToday(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1),
                        'text-gray-700': !main.calendar.isToday(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1)
                      }">
                    @{{ n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1 }}
                </span>
                
                <!-- Medication Indicator -->
                <div ng-if="main.daily_summary[main.calendar.formatDateKey(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1)]"
                     class="mt-auto">
                    <div class="flex items-center justify-center space-x-1">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="text-xs text-gray-500">
                            @{{ main.daily_summary[main.calendar.formatDateKey(main.currentMonth.getFullYear(), main.currentMonth.getMonth(), n - main.calendar.getFirstDayOfMonth(main.currentMonth) + 1)].total_medicines }} doses
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>