@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header Section - Mobile Optimized -->
        <div class="px-3 sm:px-4 py-2 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
            <div class="flex items-center w-full sm:w-auto">
                <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-2 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm"></span>
                </a>
                <h1 class="text-base font-bold text-black">All Channels</h1>
            </div>
            
            <!-- Filter Section -->
            <div class="flex items-center w-full sm:w-auto space-x-2">
                <form id="filterForm" action="{{ url()->current() }}" method="GET" class="flex justify-end items-center gap-2 overflow-x-auto whitespace-nowrap">
                    <!-- Status Filter -->
                    <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[90px]">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Subscribers</option>
                        <option value="0-10000" {{ request('status') == '0-10000' ? 'selected' : '' }}>< 10K</option>
                        <option value="10000-50000" {{ request('status') == '10000-50000' ? 'selected' : '' }}>10K - 50K</option>
                        <option value="50000+" {{ request('status') == '50000+' ? 'selected' : '' }}>50K+</option>
                    </select>

                    <!-- Sort By -->
                    <select name="sort" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[110px]">
                        <option value="subscribers-desc" {{ request('sort') == 'subscribers-desc' || !request('sort') ? 'selected' : '' }}>Most Subscribers</option>
                        <option value="subscribers-asc" {{ request('sort') == 'subscribers-asc' ? 'selected' : '' }}>Least Subscribers</option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Main Content Area - Mobile Optimized -->
        <div class="flex-1 p-2 sm:p-4">
            <div class="max-w-7xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <div class="py-6 px-3 sm:px-6">
                  
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 pl-4">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('campaigns.store', ['user' => Auth::id()]) }}" enctype="multipart/form-data">
                        @csrf

                        <div id="channels-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 max-w-7xl mx-auto">
                            @foreach($channels as $channel)
                                <div class="w-full channel-card" 
                                     data-name="{{ strtolower($channel->name) }}"
                                     data-subscribers="{{ $channel->subscribers_count }}">
                                    <div class="bg-gradient-to-br from-white to-blue-50/50 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden group border-2 border-gray-300">
                                        <!-- Card Header with Channel Info -->
                                        <div class="p-4 bg-white/90">
                                            <div class="flex items-center mb-3">
                                                @if($channel->logo_path)
                                                    <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-gray-100 shadow-sm">
                                                @else
                                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-500 font-semibold text-lg shadow-sm border border-blue-200">
                                                        {{ substr($channel->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="ml-3">
                                                    <h3 class="font-semibold text-gray-800 text-base sm:text-lg">{{ $channel->name }}</h3>
                                                    <p class="text-xs text-gray-500">{{ Str::limit($channel->description, 40) }}</p>
                                                </div>
                                            </div>

                                            <!-- Channel Description - Mobile Friendly -->
                                            <p class="text-xs sm:text-sm text-gray-600 mb-3 hidden sm:block">{{ Str::limit($channel->description, 100) }}</p>
                                            
                                            <!-- Subscriber Count -->
                                            <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100/60 text-blue-700 border border-gray-200">
                                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ number_format($channel->subscribers_count) }} Subscribers
                                            </div>
                                        </div>
                                        
                                        <!-- View Channel Section -->
                                        <div class="p-3 bg-gradient-to-r from-blue-50/40 to-indigo-50/40">
                                            @if($channel->link)
                                                <a href="{{ $channel->link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-2 py-1 text-xs sm:text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    View Channel
                                                </a>
                                            @endif
                                        </div>
                                        
                                        <!-- Duration Selector Section -->
                                        <div class="p-3 bg-gradient-to-r from-indigo-50/30 to-blue-50/30">
                                            <select name="durations[{{ $channel->id }}]" class="w-full rounded-md text-xs sm:text-sm border-2 border-gray-300/50 shadow-sm focus:ring-blue-500 focus:border-blue-500 channel-duration bg-blue-50/20" data-channel-id="{{ $channel->id }}" data-price-1="{{ $channel->price_1_day }}" data-price-2="{{ $channel->price_2_days }}" data-price-3="{{ $channel->price_3_days }}" data-price-7="{{ $channel->price_7_days }}">
                                                <option value="">Select Duration</option>
                                                <option value="1">1 Day (${{ number_format($channel->price_1_day, 2) }})</option>
                                                <option value="2">2 Days (${{ number_format($channel->price_2_days, 2) }})</option>
                                                <option value="3">3 Days (${{ number_format($channel->price_3_days, 2) }})</option>
                                                <option value="7">7 Days (${{ number_format($channel->price_7_days, 2) }})</option>
                                            </select>
                                        </div>

                                        <!-- Select Channel Button Section -->
                                        <div class="p-3 bg-gradient-to-b from-blue-50/40 to-gray-50/60">
                                            <a href="{{ route('campaigns.channel.details', ['user' => Auth::id(), 'channel' => $channel->id]) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border-2 border-blue-700 text-xs sm:text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 select-channel-btn transition-colors shadow-sm" data-channel-id="{{ $channel->id }}">
                                                Select Channel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- No Results Message -->
                        <div id="no-channels-message" class="hidden text-center py-8 sm:py-10">
                            <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No channels found</h3>
                            <p class="mt-1 text-xs sm:text-sm text-gray-500">Try changing your search or filter criteria.</p>
                            <div class="mt-4 sm:mt-6">
                                <button id="clear-filters-btn" type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs sm:text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Clear all filters
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-center mt-6">
                            {{ $channels->links() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const clearBtn = document.getElementById('clear-filters-btn');
    const noChannelsMsg = document.getElementById('no-channels-message');
    const channelCards = document.querySelectorAll('.channel-card');
    const channelsContainer = document.getElementById('channels-container');
    const subscriberFilter = document.querySelector('select[name="status"]');
    const sortFilter = document.querySelector('select[name="sort"]');
    
    // Clear all filters button
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = window.location.pathname;
        });
    }
    
    // Show/hide no results message based on server-side data
    if (noChannelsMsg && channelsContainer) {
        const hasChannels = channelCards.length > 0;
        channelsContainer.classList.toggle('hidden', !hasChannels);
        noChannelsMsg.classList.toggle('hidden', hasChannels);
    }
    
    // Initialize filters
    if (subscriberFilter) {
        subscriberFilter.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (sortFilter) {
        sortFilter.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    // Clear all filters button
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (subscriberFilter) subscriberFilter.value = 'all';
            if (sortFilter) sortFilter.value = 'subscribers-desc';
            document.getElementById('filterForm').submit();
        });
    }
    
    // Channel selection logic
    const durationSelects = document.querySelectorAll('.channel-duration');
    const channelButtons = document.querySelectorAll('.select-channel-btn');

    durationSelects.forEach(select => {
        select.addEventListener('change', function() {
            const channelId = this.getAttribute('data-channel-id');
            const duration = this.value;
            const price = this.getAttribute(`data-price-${duration}`);

            if (duration && price) {
                localStorage.setItem(`channel_${channelId}_duration`, duration);
                localStorage.setItem(`channel_${channelId}_price`, price);
            }
        });
    });

    channelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const channelId = this.getAttribute('data-channel-id');
            const duration = localStorage.getItem(`channel_${channelId}_duration`);
            const price = localStorage.getItem(`channel_${channelId}_price`);

            if (duration && price) {
                const baseUrl = this.getAttribute('href');
                const url = `${baseUrl}?duration=${duration}&price=${price}`;
                window.location.href = url;
            } else {
                alert('Please select a duration first');
            }
        });
    });
});
</script>

<style>
    /* Additional styling for dropdown options */
    select option {
        font-size: 0.75rem !important;
        padding: 4px !important;
    }
</style>
@endsection
