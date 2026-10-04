@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#0088cc]/5 via-[#4361EE]/5 to-[#0099ff]/5 flex flex-col">
    <div class="flex-1 flex flex-col">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-[#0088cc]/10 to-[#0099ff]/10 border-b border-[#0088cc]/20 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center min-w-0 mr-2">
                <a href="{{ route('platform.selection') }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200 mr-2 sm:mr-3 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900 truncate">Welcome, {{ auth()->user()->name }}!</h1>
            </div>
            <div class="flex items-center shrink-0">
                @if(auth()->user()->role === 'advertiser')
                    <a href="{{ url('/' . Auth::id() . '/campaigns/create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-[#0088cc] to-[#4361EE] rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white hover:opacity-95 transition-all duration-200 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Campaign
                    </a>
                @elseif(auth()->user()->role === 'publisher')
                    <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-[#0088cc] to-[#4361EE] rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white hover:opacity-95 transition-all duration-200 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Channel
                    </a>
                @endif
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-1 px-3 sm:px-4 py-4 pb-28 sm:pb-12">
            <div class="max-w-7xl mx-auto space-y-5">
                @if (session('status'))
                    <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-xs sm:text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->role === 'advertiser')
                    <!-- Advertiser Metrics -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="bg-gradient-to-br from-[#0088cc]/10 to-[#0099ff]/15 rounded-xl p-3.5 sm:p-5 text-[#0077b5] shadow-sm border border-[#0088cc]/20">
                            <div class="text-center sm:text-left">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Active Ads</h3>
                                <p class="text-xl sm:text-3xl font-bold mt-1 text-gray-900">{{ $activeAds }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-[#4361EE]/10 to-[#3A0CA3]/15 rounded-xl p-3.5 sm:p-5 text-[#4361EE] shadow-sm border border-[#4361EE]/20">
                            <div class="text-center sm:text-left">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Total Spent</h3>
                                <p class="text-xl sm:text-3xl font-bold mt-1 text-gray-900 truncate">₹{{ number_format($totalSpent, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Campaigns Card Grid -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/80 overflow-hidden">
                        <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-sm sm:text-base font-bold text-gray-900">Recent Campaigns</h2>
                            <a href="{{ url('/' . Auth::id() . '/campaigns') }}" class="text-xs text-[#0088cc] hover:underline font-semibold">View All</a>
                        </div>
                        <div class="p-3.5 sm:p-5">
                            @if($campaigns->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                                    @foreach($campaigns as $campaign)
                                        <div class="bg-gray-50/70 hover:bg-white rounded-xl p-4 border border-gray-200/80 hover:border-[#0088cc]/30 shadow-xs hover:shadow-sm transition-all duration-200 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-start justify-between gap-2 mb-2">
                                                    <h3 class="font-bold text-sm text-gray-900 truncate">{{ $campaign->name }}</h3>
                                                    <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full shrink-0 {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($campaign->status) }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-600 mb-3">Budget: <span class="font-semibold text-gray-900">₹{{ number_format($campaign->budget, 2) }}</span></p>
                                            </div>
                                            <div class="pt-2 border-t border-gray-200/60 flex justify-end">
                                                <a href="{{ route('campaigns.show', ['user' => auth()->id(), 'campaign' => $campaign]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all">
                                                    View Details
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                    <p class="text-xs sm:text-sm text-gray-500">No campaigns yet. Create your first campaign to start advertising!</p>
                                </div>
                            @endif
                        </div>
                    </div>

                @elseif(auth()->user()->role === 'publisher')
                    <!-- Publisher Metrics -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="bg-gradient-to-br from-[#0088cc]/10 to-[#0099ff]/15 rounded-xl p-3.5 sm:p-5 text-[#0077b5] shadow-sm border border-[#0088cc]/20">
                            <div class="text-center sm:text-left">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Active Channels</h3>
                                <p class="text-xl sm:text-3xl font-bold mt-1 text-gray-900">{{ $activeChannels }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-3.5 sm:p-5 text-emerald-700 shadow-sm border border-emerald-200/80">
                            <div class="text-center sm:text-left">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-700">Total Earnings</h3>
                                <p class="text-xl sm:text-3xl font-bold mt-1 text-gray-900 truncate">₹{{ number_format($totalEarnings, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Channels Card Grid -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/80 overflow-hidden">
                        <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-sm sm:text-base font-bold text-gray-900">Your Channels</h2>
                            <a href="{{ url('/' . Auth::id() . '/publisher/dashboard') }}" class="text-xs text-[#0088cc] hover:underline font-semibold">Dashboard</a>
                        </div>
                        <div class="p-3.5 sm:p-5">
                            @if($channels->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                                    @foreach($channels as $channel)
                                        <div class="bg-gray-50/70 hover:bg-white rounded-xl p-4 border border-gray-200/80 hover:border-[#0088cc]/30 shadow-xs hover:shadow-sm transition-all duration-200 flex flex-col justify-between">
                                            <div>
                                                <div class="flex items-start justify-between gap-2 mb-2">
                                                    <h3 class="font-bold text-sm text-gray-900 truncate">{{ $channel->name }}</h3>
                                                    <span class="px-2 py-0.5 text-[11px] font-semibold rounded-full shrink-0 {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($channel->status) }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-600 mb-3">Type: <span class="font-semibold text-gray-900">{{ ucfirst($channel->type ?? 'Telegram') }}</span></p>
                                            </div>
                                            <div class="pt-2 border-t border-gray-200/60 flex justify-end">
                                                <a href="{{ route('channels.show', ['user' => auth()->id(), 'channel' => $channel]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all">
                                                    View Details
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="text-xs sm:text-sm text-gray-500">No channels yet. Add your first channel to start monetizing!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
