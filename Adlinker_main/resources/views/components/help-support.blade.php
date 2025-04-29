<div x-data="{ isOpen: false }" class="relative">
    <!-- Help & Support Button -->
    <button @click="isOpen = !isOpen" class="flex items-center px-4 py-2 bg-[#2B3A67] text-white rounded-full hover:bg-[#3A497A] transition-colors duration-200 shadow-md">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Help & Support
    </button>

    <!-- FAQ Panel -->
    <div x-show="isOpen" @click.away="isOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg z-50 border border-gray-200">
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular FAQs</h3>
            
            <!-- FAQ Accordion -->
            <div x-data="{ activeTab: null }" class="space-y-2">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="activeTab = (activeTab === 1) ? null : 1" class="w-full px-4 py-3 text-left flex justify-between items-center hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <span class="text-sm font-medium text-gray-700">Why is my payment not visible on the dashboard?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{ 'transform rotate-180': activeTab === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 1" class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                        Payments typically appear on your dashboard within 24 hours. If you don't see your payment, please check your transaction ID and contact support if the issue persists.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="activeTab = (activeTab === 2) ? null : 2" class="w-full px-4 py-3 text-left flex justify-between items-center hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <span class="text-sm font-medium text-gray-700">What is a Same-Day Settlement?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{ 'transform rotate-180': activeTab === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 2" class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                        Same-Day Settlement allows you to receive your funds on the same business day. This service is available for transactions processed before 3 PM local time.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="activeTab = (activeTab === 3) ? null : 3" class="w-full px-4 py-3 text-left flex justify-between items-center hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <span class="text-sm font-medium text-gray-700">What happens to my current balance if I do not make any Instant Settlement requests?</span>
                        <svg class="w-5 h-5 text-gray-500" :class="{ 'transform rotate-180': activeTab === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 3" class="px-4 py-3 text-sm text-gray-600 border-t border-gray-200">
                        Your balance will remain in your account until you request a withdrawal. We automatically process settlements on a weekly basis for any unclaimed balance.
                    </div>
                </div>
            </div>

            <!-- Need More Help Section -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-3">Need more help?</p>
                <a href="#" class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#4361EE] text-white rounded-lg hover:bg-[#3A0CA3] transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>