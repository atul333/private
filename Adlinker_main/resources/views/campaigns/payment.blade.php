@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50/50 via-white to-indigo-50/40 flex flex-col">
    <div class="flex-1 flex items-center justify-center p-3 sm:p-4 pb-28 sm:pb-12">
        <div class="max-w-md w-full">
            <!-- Payment Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-sky-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#0088cc] to-[#4361EE] text-white text-center py-5 sm:py-6 px-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-2 sm:mb-3 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold">Secure Payment</h2>
                    <p class="text-xs sm:text-sm text-white/80 mt-0.5">Complete your Telegram campaign order</p>
                </div>

                <div class="p-4 sm:p-6 space-y-5">
                    <!-- Amount -->
                    <div class="text-center">
                        <div class="text-3xl sm:text-4xl font-extrabold text-[#0088cc] mb-1">₹{{ number_format($campaign->price, 2) }}</div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Campaign #{{ $campaign->id }}</p>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Payment Summary
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Platform</span>
                                <span class="font-semibold">Telegram</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Publisher</span>
                                <span class="font-semibold">{{ $campaign->channel->name ?? 'Channel' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration</span>
                                <span>{{ $campaign->duration }} Days</span>
                            </div>
                            <div class="border-t border-gray-300 pt-2 mt-2"></div>
                            <div class="flex justify-between items-center text-base">
                                <span class="font-bold text-gray-900">Total Amount</span>
                                <span class="font-bold text-xl text-[#4361EE]">₹{{ number_format($campaign->price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Wallet Balance -->
                    <div class="border-2 rounded-lg p-4 {{ $wallet->balance >= $campaign->price ? 'border-green-300 bg-green-50' : 'border-red-300 bg-red-50' }}">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Wallet Balance
                            </span>
                            <span class="font-bold text-lg {{ $wallet->balance >= $campaign->price ? 'text-green-600' : 'text-red-600' }}">
                                ₹{{ number_format($wallet->balance, 2) }}
                            </span>
                        </div>
                        @if($wallet->balance < $campaign->price)
                            <div class="bg-red-100 border border-red-200 rounded p-3 mt-3">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-semibold text-red-800 text-sm">Insufficient Balance!</p>
                                        <p class="text-xs text-red-700 mt-1">You need ₹{{ number_format($campaign->price - $wallet->balance, 2) }} more</p>
                                    </div>
                                </div>
                                <a href="/{{ auth()->id() }}/advertiser/wallet/add-funds" class="block w-full mt-3 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg text-center transition-colors duration-200">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Funds to Wallet
                                </a>
                            </div>
                        @else
                            <div class="flex items-center text-green-700 text-sm mt-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Sufficient balance available
                            </div>
                        @endif
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('campaigns.payment.process', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" method="GET" class="space-y-3">
                        <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 sm:py-4 border border-transparent rounded-xl text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-[#0088cc] to-[#4361EE] hover:opacity-95 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer {{ $wallet->balance < $campaign->price ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $wallet->balance < $campaign->price ? 'disabled' : '' }}>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Pay Securely ₹{{ number_format($campaign->price, 2) }}
                        </button>
                        <a href="/{{ auth()->id() }}/advertiser/dashboard" class="block w-full text-center px-6 py-3 border border-gray-300 rounded-xl text-sm sm:text-base font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                            Cancel Payment
                        </a>
                    </form>

                    <!-- Security Notice -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Secure payment powered by Wallet System
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection