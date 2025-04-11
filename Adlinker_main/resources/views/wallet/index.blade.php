@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">


            
            @if(auth()->user()->role === 'publisher')
            <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-lg font-bold text-gray-800">Wallet Balance</h2>
                    </div>    
            <a href="{{ route('publisher.wallet.withdraw', ['id' => Auth::user()->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out inline-block">Withdraw Funds</a>
            @else
            <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-3xl font-bold text-gray-800">Wallet Balance</h2>
                    </div>
                <a href="{{ route('advertiser.wallet.add-funds-form', ['id' => Auth::user()->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out inline-block">Add Funds</a>
            @endif
        </div>
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl shadow-lg p-6">
                <div class="text-white">
                    <h5 class="text-base font-semibold mb-2">Available Balance</h5>
                    <h2 class="text-base font-bold">${{ number_format($availableBalance ?? 0.00 , 2) }} USD</h2>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl shadow-lg p-6">
                <div class="text-white">
                    <h5 class="text-base font-semibold mb-2">Pending Payments</h5>
                    <h2 class="text-base font-bold">${{ number_format($pendingPayments ?? 0.00, 2) }}</h2>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl shadow-lg p-6">
                <div class="text-white">
                    <h5 class="text-base font-semibold mb-2">Payment Done</h5>
                    <h2 class="text-base font-bold">${{ number_format($completedPayments ?? 0.00, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h5 class="text-lg font-semibold text-gray-800">Transaction History</h5>
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
        </div>
    </div>
</div>



@endsection