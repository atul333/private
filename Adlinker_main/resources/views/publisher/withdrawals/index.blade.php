@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-sky-50/30 to-indigo-50/30 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header -->
        <div class="px-4 py-2.5 bg-white border-b border-gray-200 flex justify-between items-center min-h-[52px]">
            <h1 class="text-base sm:text-lg font-bold text-gray-900">Withdrawal History</h1>
            <a href="{{ route('publisher.withdrawals.create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg text-xs sm:text-sm font-medium shadow-sm hover:from-indigo-600 hover:to-indigo-700 transition-all duration-200 whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Request
            </a>
        </div>

        <!-- Content -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12 flex-1">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($withdrawals as $withdrawal)
                <div class="bg-white/95 rounded-xl shadow-sm border border-gray-200 p-4 mb-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-base font-bold text-gray-900">&#8377;{{ number_format($withdrawal->amount, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $withdrawal->payment_method }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $withdrawal->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full
                                {{ $withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   ($withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                            @if($withdrawal->processed_at)
                                <p class="text-xs text-gray-400 mt-1">Processed: {{ $withdrawal->processed_at->format('Y-m-d') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white/95 rounded-xl shadow-sm border border-gray-200 p-8 text-center mt-4">
                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm text-gray-500">No withdrawal history found</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection