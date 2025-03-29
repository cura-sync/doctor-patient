<!-- Header Section -->
<x-page-header :pageHeader="$pageHeader" />

<!-- Steps Section -->
<div class="py-16">
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-16">
        How to use bill analysis?
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="text-center">
            <div class="text-teal-500 mb-4">
                <svg class="w-8 h-8 text-[#449994] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Upload Bill</h2>
            <p class="text-gray-600 text-sm">Start by uploading your medical bill in PDF, JPG, or PNG format.</p>
        </div>

        <!-- Step 2 -->
        <div class="text-center">
            <div class="text-teal-500 mb-4">
                <svg class="w-8 h-8 text-[#449994] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Start Analysis</h2>
            <p class="text-gray-600 text-sm">Review the analysis results, including expense breakdowns and savings recommendations.</p>
        </div>

        <!-- Step 3 -->
        <div class="text-center">
            <div class="text-teal-500 mb-4">
                <svg class="w-8 h-8 text-[#449994] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">View Insights</h2>
            <p class="text-gray-600 text-sm">Our AI will analyze your bill, categorizing expenses and identifying potential savings.</p>
        </div>
    </div>
</div>