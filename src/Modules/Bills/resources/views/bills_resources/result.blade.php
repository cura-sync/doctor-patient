 <!-- Expenditure Summary -->
 <div class="bg-white rounded-lg shadow p-6 mb-12">
    <div class="flex items-center mb-6">
        <h2 class="text-xl font-semibold">Expenditure Summary</h2>
        <div class="ml-4 space-x-2">
            <button class="px-4 py-1 bg-gray-100 text-gray-700 rounded-md">Chart</button>
            <button class="px-4 py-1 text-gray-600">Table</button>
        </div>
    </div>
    <div class="h-64 flex justify-center items-center">
        <!-- Pie Chart Placeholder -->
        <div class="w-64 h-64 relative">
            <!-- You'll need to integrate a charting library like Chart.js for the actual pie chart -->
            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                Pie Chart Placeholder
            </div>
        </div>
    </div>
    <div class="flex justify-center mt-4 space-x-4">
        <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>Groceries</span>
        <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>Utilities</span>
        <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>Entertainment</span>
        <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>Transportation</span>
        <span class="flex items-center"><span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>Other</span>
    </div>
</div>

<!-- Additional Features -->
<div class="mb-12">
    <h2 class="text-xl font-semibold mb-6">Additional Features</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Downloadable Report -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Downloadable Report</h3>
            <p class="text-gray-600 mb-4">Download a PDF/CSV summary of your analyzed bill, including categorized expenses and insights.</p>
            <div class="space-y-4">
                <div class="flex space-x-4">
                    <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download PDF
                    </button>
                    <button class="flex items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download CSV
                    </button>
                </div>
                <button class="w-full flex items-center justify-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Send Report via Email
                </button>
            </div>
        </div>

        <!-- Expense Trends -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Expense Trends</h3>
            <p class="text-gray-600 mb-4">View your spending trends over time and compare with past bills.</p>
            <div class="h-48">
                <!-- Line Chart Placeholder -->
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    Line Chart Placeholder
                </div>
            </div>
        </div>
    </div>
</div>