@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-sky-50 to-blue-50/80 border-b border-[#0088cc]/15 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="{{ route('campaigns.index', ['user' => auth()->id()]) }}" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900">Campaign Details</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('campaigns.edit', $campaign) }}"
                   class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-yellow-50 border border-yellow-200 rounded-lg text-xs font-medium text-yellow-700 hover:bg-yellow-100 transition-all duration-200">
                    Edit
                </a>
                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this campaign?')"
                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 border border-red-200 rounded-lg text-xs font-medium text-red-700 hover:bg-red-100 transition-all duration-200">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12 flex-1">
            @if (session('status'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="max-w-2xl mx-auto space-y-4">
                <!-- Campaign Info Card -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-[#0088cc]/20 p-4 sm:p-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Campaign Name</p>
                            <p class="text-sm font-bold text-gray-900">{{ $campaign->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Budget</p>
                            <p class="text-sm font-bold text-green-600">&#8377;{{ number_format($campaign->budget, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Target Audience</p>
                            <p class="text-sm text-gray-800">{{ $campaign->target_audience }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date</p>
                            <p class="text-sm text-gray-800">{{ $campaign->start_date->format('Y-m-d') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">End Date</p>
                            <p class="text-sm text-gray-800">{{ $campaign->end_date->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    @if($campaign->description)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Description</p>
                            <p class="text-sm text-gray-700">{{ $campaign->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-gradient-to-br from-[#0088cc]/15 to-[#0099ff]/15 rounded-xl p-3 text-center border border-[#0088cc]/30">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Active Ads</p>
                        <p class="text-xl font-bold text-[#0088cc]">{{ $campaign->ads->where('status', 'active')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-3 text-center border border-purple-200/60">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Impressions</p>
                        <p class="text-xl font-bold text-purple-700">{{ number_format($campaign->ads->sum('impressions')) }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-3 text-center border border-green-200/60">
                        <p class="text-xs font-semibold text-gray-600 mb-1">Total Clicks</p>
                        <p class="text-xl font-bold text-green-700">{{ number_format($campaign->ads->sum('clicks')) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection