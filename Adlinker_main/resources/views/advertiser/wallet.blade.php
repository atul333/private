@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-4 text-sm flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-lg font-bold text-white">{{ __('Wallet Balance') }}</h1>
                    </div>
                    <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]" data-bs-toggle="modal" data-bs-target="#addFundsModal">Add Funds</button>
                </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-[#7209B7] to-[#560BAD] rounded-xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium opacity-90">Available Balance</h3>
                        <p class="text-3xl font-bold mt-2">${{ number_format($availableBalance ?? 0.00, 2) }}</p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#F72585] to-[#B5179E] rounded-xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium opacity-90">Pending Payments</h3>
                        <p class="text-3xl font-bold mt-2">${{ number_format($pendingPayments ?? 0.00, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/30 transform transition-all duration-300 hover:shadow-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20">
                    <h2 class="text-lg font-semibold text-white">{{ __('Transaction History') }}</h2>
                </div>
                <div class="p-6 overflow-y-auto max-h-[50vh]">
                    @if(isset($transactions) && count($transactions) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#4895EF]/10">
                                <thead class="bg-gradient-to-r from-[#4895EF]/5 to-[#4CC9F0]/5">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#3A0CA3] uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#3A0CA3] uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#3A0CA3] uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#3A0CA3] uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/50 backdrop-blur-sm divide-y divide-[#4895EF]/10">
                                    @foreach($transactions as $transaction)
                                    <tr class="hover:bg-[#4CC9F0]/5 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#3A0CA3]/80">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#3A0CA3]">Payment for campaign on {{ $transaction->channel_name }} for {{ $transaction->duration }} days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#3A0CA3]/80">${{ number_format($transaction->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status === 'completed' ? 'bg-gradient-to-r from-green-100 to-green-50 text-green-800' : 'bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800' }} shadow-sm">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                            <p class="mt-1 text-sm text-gray-500">No transactions found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1" aria-labelledby="addFundsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg shadow-xl border border-[#4895EF]/20 bg-white/95 backdrop-blur-sm transform transition-all duration-300 hover:shadow-2xl">
            <div class="px-6 py-4 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 rounded-t-lg flex justify-between items-center">
                <h3 class="text-lg font-medium text-white" id="addFundsModalLabel">Add Funds to Wallet</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" data-bs-dismiss="modal" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('advertiser.wallet.deposit') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount ($)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" min="0.01" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">Add Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection