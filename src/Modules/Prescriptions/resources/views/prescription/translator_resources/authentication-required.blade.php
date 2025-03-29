<!-- Modal for Login/Register -->
<div id="loginModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" ng-show="main.showLoginModal">
    <div class="modal-content bg-white rounded-3xl shadow-lg p-8 max-w-md w-full mx-4 relative">
        <!-- Close buttons - both X variants shown in image -->
        <div class="absolute right-4 top-4 flex gap-2">
            <button class="text-gray-400 hover:text-gray-600" ng-click="main.closeLoginModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <h2 class="text-2xl font-bold mb-4 text-center">Authentication Required</h2>
        <p class="text-gray-600 text-lg mb-8 text-center">
            Please login or register to continue using the translator
        </p>
        <div class="flex gap-4 justify-center">
            <a href="/login" class="flex-1 bg-[#449994] hover:bg-teal-600 text-white py-3 px-6 rounded-lg transition-colors text-center">
                <button>
                    Login
                </button>
            </a>
            <a href="/register" class="flex-1 bg-white text-black py-3 px-6 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors text-center">
                <button>
                    Register
                </button>
            </a>
        </div>
    </div>
</div>