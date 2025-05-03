@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20  flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    
                </a>
                <h1 class="text-lg font-bold text-black">Campaign Payment</h1>
            </div>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-6 min-h-0">
            <div class="max-w-3xl mx-auto space-y-6">
                <!-- Payment Details Card -->
                <div class="bg-gradient-to-br from-[#FFFFFF] to-[#FFFFFF] rounded-xl p-6 text-black shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="text-center space-y-2">
                        <h3 class="text-lg font-medium opacity-90">Payment Details</h3>
                        <p class="text-lg">Campaign Duration: {{ $campaign->duration }} Days</p>
                        <p class="text-3xl font-bold mt-2">Amount: ${{ number_format($campaign->price, 2) }}</p>
                    </div>
                </div>

                <!-- Wallet Balance Card -->
                <div class="bg-gradient-to-br from-[#FFFFFF] to-[#FFFFFF] rounded-xl p-6 text-black shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="text-center space-y-2">
                        <h3 class="text-lg font-medium opacity-90">Wallet Balance</h3>
                        <p class="text-3xl font-bold">${{ number_format($wallet->balance ?? 0.00, 2) }}</p>
                        @if($wallet->balance < $campaign->price)
                            <div class="mt-6 text-center">
                                <p class="text-sm text-red-500 mb-3">Insufficient balance for this campaign</p>
                                <a href="/{{ auth()->id() }}/advertiser/wallet/add-funds" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#F72585] to-[#7209B7] border border-transparent rounded-xl shadow-lg text-lg font-semibold text-white hover:from-[#B5179E] hover:to-[#560BAD] transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7209B7] animate-pulse hover:animate-none">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Funds to Wallet
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Button -->
                <div class="text-center mt-8">
                    <form action="{{ route('campaigns.payment.process', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" method="GET">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-base font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection