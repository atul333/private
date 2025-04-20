@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#7209B7]/20 flex justify-between items-center shrink-0">
            @if(auth()->user()->role === 'publisher')
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="ml-4 text-xl font-bold text-white">Wallet Balance</h1>
            </div>    
            <a href="{{ route('publisher.wallet.withdraw', ['id' => Auth::user()->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300">Withdraw Funds</a>
            @else
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back</span>
                </a>
                <h1 class="ml-4 text-xl font-bold text-white">Wallet Balance</h1>
            </div>
            <a href="{{ route('advertiser.wallet.add-funds-form', ['id' => Auth::user()->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300">Add Funds</a>
            @endif
        </div>

        <!-- Fixed Metrics Section -->
        <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-medium opacity-90">Available Balance</h3>
                        <p class="text-lg font-bold mt-2">${{ number_format($availableBalance ?? 0.00, 2) }}</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#F72585]/20 to-[#B5179E]/20 rounded-xl p-4 text-[#B5179E] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#F72585]/30 hover:border-[#F72585]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-medium opacity-90">Pending Payments</h3>
                        <p class="text-lg font-bold mt-2">${{ number_format($pendingPayments ?? 0.00, 2) }}</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-medium opacity-90">Payment Done</h3>
                        <p class="text-lg font-bold mt-2">${{ number_format($completedPayments ?? 0.00, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scrollable Content Section -->
        <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <div class="px-4 py-3 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20">
                    <h2 class="text-lg font-semibold text-gray-900">Transaction History</h2>
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
    </div>
@endsection
