@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20">
                <div class="px-6 py-4 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20">
                    <h1 class="text-2xl font-semibold text-white">Campaign Payment</h1>
                </div>

            <div class="p-6">
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-[#7209B7] to-[#560BAD] rounded-xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-center space-y-2">
                            <h3 class="text-lg font-medium opacity-90">Payment Details</h3>
                            <p class="text-lg">Campaign Duration: {{ $campaign->duration }} Days</p>
                            <p class="text-3xl font-bold mt-2">Amount: ${{ number_format($campaign->price, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-[#F72585] to-[#B5179E] rounded-xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
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
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-lg text-base font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
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