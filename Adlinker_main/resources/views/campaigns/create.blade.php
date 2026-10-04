@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col pb-28 sm:pb-12">
    <div class="flex flex-col flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-sky-50 to-blue-50/80 border-b border-[#0088cc]/15 flex items-center min-h-[52px]">
            <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-base sm:text-lg font-bold text-gray-900">All Channels</h1>
        </div>

        <!-- Filter Section -->
        <div class="px-4 py-3 bg-white/70 backdrop-blur-sm border-b border-[#0088cc]/10">
            <form id="filterForm" action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-2.5">
                <div class="text-xs sm:text-sm text-gray-600 font-medium">
                    Available Telegram Channels
                </div>
                <div class="flex items-center gap-2 overflow-x-auto">
                    <!-- Status/Subscriber Filter -->
                    <select name="status" onchange="this.form.submit()" class="text-xs sm:text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] py-2 px-3 bg-white font-medium text-gray-700 shadow-xs flex-1 sm:flex-none sm:min-w-[130px]">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Subscribers</option>
                        <option value="0-10000" {{ request('status') == '0-10000' ? 'selected' : '' }}>< 10K</option>
                        <option value="10000-50000" {{ request('status') == '10000-50000' ? 'selected' : '' }}>10K - 50K</option>
                        <option value="50000+" {{ request('status') == '50000+' ? 'selected' : '' }}>50K+</option>
                    </select>

                    <!-- Sort By Filter -->
                    <select name="sort" onchange="this.form.submit()" class="text-xs sm:text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] py-2 px-3 bg-white font-medium text-gray-700 shadow-xs flex-1 sm:flex-none sm:min-w-[140px]">
                        <option value="subscribers-desc" {{ request('sort') == 'subscribers-desc' || !request('sort') ? 'selected' : '' }}>Most Subscribers</option>
                        <option value="subscribers-asc" {{ request('sort') == 'subscribers-asc' ? 'selected' : '' }}>Least Subscribers</option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name Z-A</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="px-4 py-4 flex-1">
            <div class="max-w-7xl mx-auto">
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-4 shadow-xs">
                        <ul class="text-xs sm:text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="channels-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($channels as $channel)
                        <div class="w-full channel-card" 
                             data-name="{{ strtolower($channel->name) }}"
                             data-subscribers="{{ $channel->subscribers_count }}">
                            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#0088cc]/20 hover:border-[#0088cc]/40 overflow-hidden flex flex-col justify-between group h-full">
                                <!-- Card Header with Channel Info -->
                                <div class="p-4 sm:p-5 flex-1">
                                    <div class="flex items-start gap-3 mb-3">
                                        @if($channel->logo_path)
                                            <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover border border-gray-200 shadow-xs shrink-0">
                                        @else
                                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0088cc] font-bold text-lg shadow-xs shrink-0">
                                                {{ substr($channel->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-bold text-gray-900 text-base sm:text-lg truncate group-hover:text-[#0088cc] transition-colors">
                                                {{ $channel->name }}
                                            </h3>
                                            @if($channel->description)
                                                <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $channel->description }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Metrics Badges: Subscribers and Link -->
                                    <div class="flex items-center justify-between gap-2 mb-4 flex-wrap">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-[#0088cc] border border-sky-100">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>{{ number_format($channel->subscribers_count) }} Subscribers</span>
                                        </div>

                                        @if($channel->link)
                                            <a href="{{ $channel->link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs text-[#0088cc] hover:text-[#0077b5] font-semibold hover:underline">
                                                <span>View Channel</span>
                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Duration Selector -->
                                    <div class="mt-2">
                                        <label class="block text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                            Select Duration & Price
                                        </label>
                                        <select name="durations[{{ $channel->id }}]" class="w-full rounded-xl text-xs sm:text-sm border border-gray-300 py-2.5 px-3 shadow-xs focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] focus:outline-none channel-duration bg-white font-medium text-gray-800" data-channel-id="{{ $channel->id }}" data-price-1="{{ $channel->price_1_day }}" data-price-2="{{ $channel->price_2_days }}" data-price-3="{{ $channel->price_3_days }}" data-price-7="{{ $channel->price_7_days }}">
                                            <option value="">Choose Duration</option>
                                            <option value="1">1 Day — ₹{{ number_format($channel->price_1_day, 2) }}</option>
                                            <option value="2">2 Days — ₹{{ number_format($channel->price_2_days, 2) }}</option>
                                            <option value="3">3 Days — ₹{{ number_format($channel->price_3_days, 2) }}</option>
                                            <option value="7">7 Days — ₹{{ number_format($channel->price_7_days, 2) }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Card Footer: Select Channel Button -->
                                <div class="px-4 py-3 bg-gray-50/70 border-t border-gray-100">
                                    <a href="{{ route('campaigns.channel.details', ['user' => Auth::id(), 'channel' => $channel->id]) }}" class="w-full inline-flex justify-center items-center gap-1.5 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-[#0088cc] to-[#0099ff] hover:from-[#0077b5] hover:to-[#0088cc] shadow-sm hover:shadow transition-all duration-200 select-channel-btn" data-channel-id="{{ $channel->id }}">
                                        <span>Select Channel</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-50 flex items-center justify-center text-[#0088cc]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 mb-1">No channels found</h3>
                            <p class="text-xs sm:text-sm text-gray-500 mb-4">Try changing your search or filter criteria.</p>
                            <a href="{{ url()->current() }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                Clear all filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- No Results Message (For JS filter fallback) -->
                <div id="no-channels-message" class="hidden text-center py-12">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-blue-50 flex items-center justify-center text-[#0088cc]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">No channels found</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-4">Try changing your search or filter criteria.</p>
                    <button id="clear-filters-btn" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                        Clear all filters
                    </button>
                </div>

                <!-- Pagination -->
                @if($channels->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $channels->links() }}
                    </div>
                @endif
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
@endsection
