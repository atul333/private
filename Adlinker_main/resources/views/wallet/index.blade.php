@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Wallet Balance</h2>
            @if(auth()->user()->role === 'publisher')
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out" data-bs-toggle="modal" data-bs-target="#withdrawFundsModal">Withdraw Funds</button>
            @else
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out" data-bs-toggle="modal" data-bs-target="#addFundsModal">Add Funds</button>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl shadow-lg p-6">
                <div class="text-white">
                    <h5 class="text-xl font-semibold mb-4">Available Balance</h5>
                    <h2 class="text-4xl font-bold">${{ number_format($availableBalance ?? 0.00, 2) }}</h2>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl shadow-lg p-6">
                <div class="text-white">
                    <h5 class="text-xl font-semibold mb-4">Pending Payments</h5>
                    <h2 class="text-4xl font-bold">${{ number_format($pendingPayments ?? 0.00, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h5 class="text-xl font-semibold text-gray-800">Transaction History</h5>
            </div>
            <div class="p-6">
                @if(isset($transactions) && count($transactions) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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