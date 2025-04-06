@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800">Campaign Payment</h1>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="text-center space-y-2">
                            <h3 class="text-lg font-medium opacity-90">Payment Details</h3>
                            <p class="text-xl">Campaign Duration: {{ $campaign->duration }} Days</p>
                            <p class="text-3xl font-bold mt-2">Amount: ${{ number_format($campaign->price, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="text-center space-y-2">
                            <h3 class="text-lg font-medium opacity-90">Wallet Balance</h3>
                            <p class="text-3xl font-bold">${{ number_format($wallet->balance ?? 0.00, 2) }}</p>
                            @if($wallet->balance < $campaign->price)
                                <div class="mt-4 bg-yellow-500 bg-opacity-20 rounded-lg p-3">
                                    <p class="text-sm">Insufficient balance. Please <a href="/{{ auth()->id() }}/advertiser/wallet" class="underline hover:text-yellow-200">add funds</a> to your wallet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <form action="{{ route('campaigns.payment.process', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" method="GET">
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                Pay Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection