@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-6 py-4 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 flex justify-between items-center">
                    @if(auth()->user()->role === 'publisher')
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-2xl font-semibold text-white">Wallet Balance</h1>
                    </div>    
                    <a href="{{ route('publisher.wallet.withdraw', ['id' => Auth::user()->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300">Withdraw Funds</a>
                    @else
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-4 flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-2xl font-semibold text-white">Wallet Balance</h1>
                    </div>
                    <a href="{{ route('advertiser.wallet.add-funds-form', ['id' => Auth::user()->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300">Add Funds</a>
                    @endif
                </div>

                {{-- Scrollable content --}}
                <div class="p-6 max-h-[550px] overflow-y-auto">
                    <div class="flex flex-row gap-4 mb-8 overflow-x-auto pb-4">
                        <div class="flex-1 min-w-[250px] bg-gradient-to-br from-[#4CC9F0] to-[#4895EF] rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="text-white">
                                <h5 class="text-base font-semibold mb-2">Available Balance</h5>
                                <h2 class="text-base font-bold">${{ number_format($availableBalance ?? 0.00 , 2) }} USD</h2>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[250px] bg-gradient-to-br from-[#F72585] to-[#B5179E] rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="text-white">
                                <h5 class="text-base font-semibold mb-2">Pending Payments</h5>
                                <h2 class="text-base font-bold">${{ number_format($pendingPayments ?? 0.00, 2) }}</h2>
                            </div>
                        </div>
                        <div class="flex-1 min-w-[250px] bg-gradient-to-br from-[#7209B7] to-[#560BAD] rounded-xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                            <div class="text-white">
                                <h5 class="text-base font-semibold mb-2">Payment Done</h5>
                                <h2 class="text-base font-bold">${{ number_format($completedPayments ?? 0.00, 2) }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/20 mt-8">
                        <div class="px-6 py-4 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20">
                            <h5 class="text-lg font-semibold text-white">Transaction History</h5>
                        </div>
                        <div class="p-6">
                            @if(isset($transactions) && count($transactions) > 0)
                                <div class="w-full">
                                    <table class="min-w-full table-fixed divide-y divide-gray-200">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th class="w-1/4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="w-1/2 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                                <th class="w-1/4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($transactions as $transaction)
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-4 py-4 text-sm text-gray-600">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                                <td class="px-4 py-4 text-sm text-gray-600 break-words">{{ $transaction->description }}</td>
                                                <td class="px-4 py-4 text-sm text-gray-600">${{ number_format($transaction->amount, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-6 px-6 py-4 bg-gray-50 rounded-b-xl border-t border-gray-200">
                                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <div class="w-full sm:w-auto">
                                                <p class="text-sm text-gray-600">
                                                    Showing
                                                    <span class="font-semibold text-gray-900">{{ $transactions->firstItem() }}</span>
                                                    to
                                                    <span class="font-semibold text-gray-900">{{ $transactions->lastItem() }}</span>
                                                    of
                                                    <span class="font-semibold text-gray-900">{{ $transactions->total() }}</span>
                                                    results
                                                </p>
                                            </div>
                                            <div class="w-full sm:w-auto flex justify-center">
                                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                                    {{ $transactions->onEachSide(1)->links() }}
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-gray-500">No transactions found.</p>
                            @endif
                        </div>
                    </div>
                </div> {{-- End of scrollable content --}}
            </div>
        </div>
    </div>
</div>
@endsection
