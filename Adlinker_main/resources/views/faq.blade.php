@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#4CC9F0] to-[#F72585] mb-4">Frequently Asked Questions</h1>
            <p class="text-gray-600 text-lg">Find answers to common questions about using our platform</p>
        </div>
        
        <!-- Advertiser Section -->
        <div class="mb-12 transform hover:scale-[1.01] transition-all duration-300">
            <h2 class="text-2xl font-semibold text-[#4CC9F0] mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                For Advertisers
            </h2>
            
            <div class="space-y-6">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4CC9F0]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How do I create an advertising campaign?</h3>
                    <p class="text-gray-600 leading-relaxed">To create a campaign, navigate to your advertiser dashboard and click on "Create Campaign". Fill in the required details including campaign name, budget, target audience, and ad content. Review your settings and click "Launch Campaign" to start advertising.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4CC9F0]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How do I add funds to my wallet?</h3>
                    <p class="text-gray-600 leading-relaxed">Click on the wallet icon in the navigation bar, then click "Add Funds". Enter the amount you wish to add and choose your preferred payment method. Follow the secure payment process to complete the transaction. Funds will be instantly credited to your wallet.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4CC9F0]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How is my campaign budget managed?</h3>
                    <p class="text-gray-600 leading-relaxed">Your campaign budget is deducted from your wallet balance as your ads are displayed. You can set daily budget limits and monitor your spending in real-time through the campaign dashboard. The system automatically pauses campaigns when the budget is exhausted.</p>
                </div>
            </div>
        </div>

        <!-- Publisher Section -->
        <div class="mb-12 transform hover:scale-[1.01] transition-all duration-300">
            <h2 class="text-2xl font-semibold text-[#F72585] mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                For Publishers
            </h2>
            
            <div class="space-y-6">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#F72585]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How do I add my Telegram channel?</h3>
                    <p class="text-gray-600 leading-relaxed">From your publisher dashboard, select "Add Channel". You'll need to verify ownership of your channel by following our verification process. Once verified, your channel will be reviewed and approved for ad placement.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#F72585]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How do I get paid for displaying ads?</h3>
                    <p class="text-gray-600 leading-relaxed">Earnings are automatically credited to your wallet based on ad performance. You can withdraw your earnings by clicking "Withdraw" in your wallet section. Minimum withdrawal amount and payment methods vary by region.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#F72585]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">What types of ads will appear on my channel?</h3>
                    <p class="text-gray-600 leading-relaxed">You have control over the types of ads that appear on your channel. From your publisher settings, you can set content preferences and categories. All ads are pre-screened to ensure they meet our content guidelines.</p>
                </div>
            </div>
        </div>

        <!-- General Questions -->
        <div class="transform hover:scale-[1.01] transition-all duration-300">
            <h2 class="text-2xl font-semibold text-[#4361EE] mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                General Questions
            </h2>
            
            <div class="space-y-6">
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4361EE]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">How do I contact support?</h3>
                    <p class="text-gray-600 leading-relaxed">You can reach our support team through the chat feature available in the navigation bar. We typically respond within 24 hours. For urgent matters, use the "Contact" button to start a live chat session.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4361EE]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Is my payment information secure?</h3>
                    <p class="text-gray-600 leading-relaxed">Yes, all payment processing is handled through secure, encrypted connections. We use industry-standard security protocols and never store sensitive payment information on our servers.</p>
                </div>

                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-[#4361EE]/10">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">What are the platform's content guidelines?</h3>
                    <p class="text-gray-600 leading-relaxed">We maintain strict content guidelines to ensure a safe and professional advertising environment. This includes restrictions on adult content, harmful products, and misleading information. Full guidelines are available in our Terms of Service.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection