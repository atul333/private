@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-800">{{ __('Withdrawal') }}</h1>
                <a href="{{ route('publisher.withdrawals.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    
                </a>
            </div>

            <div class="p-6 text-center">
                <div class="max-w-md mx-auto">
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl p-8 shadow-lg mb-6">
                        <h2 class="text-3xl font-bold mb-2">Withdraw Now</h2>
                        <p class="text-indigo-100 opacity-90">Securely withdraw your earnings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection