@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50/30 to-indigo-50/30 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header -->
        <div class="px-4 py-2.5 bg-white border-b border-gray-200 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="{{ route('publisher.withdrawals.index') }}" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900">{{ __('Request Withdrawal') }}</h1>
            </div>
        </div>

        <!-- Content -->
        <div class="px-3 sm:px-4 py-6 pb-28 sm:pb-12 flex-1 flex items-center justify-center">
            <div class="max-w-md w-full">
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-md">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Withdraw Earnings</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mb-6">Transfer your earnings securely to your bank account or UPI ID.</p>
                    <a href="{{ route('publisher.wallet.withdraw', ['id' => Auth::id()]) }}" class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-xl text-sm font-semibold shadow-md transition-all duration-200">
                        Continue to Withdrawal
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection