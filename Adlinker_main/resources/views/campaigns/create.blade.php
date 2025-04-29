@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col h-screen">
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
            
            <!-- Simple Search & Filter - Mobile Friendly -->
            <div class="flex items-center w-full sm:w-auto space-x-2">
                <div class="relative flex-grow">
                    <input 
                        type="text" 
                        id="simple-search" 
                        placeholder="Search..." 
                        class="w-full pl-8 pr-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="relative inline-block text-left">
                    <button id="simple-filter-btn" type="button" class="inline-flex items-center px-3 py-1.5 text-sm bg-white text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">
                        <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span class="hidden sm:inline">Filters</span>
                    </button>
                    
                    <div id="simple-filter-dropdown" class="hidden absolute right-0 mt-2 w-64 sm:w-72 bg-white rounded-xl shadow-xl z-50 overflow-hidden border border-gray-100">
                        <!-- Dropdown Header -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                            <h3 class="text-sm font-medium text-gray-700">Filter Channels</h3>
                        </div>
                        
                        <!-- Filter Options -->
                        <div class="p-4 space-y-4">
                            <!-- Subscribers Filter -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                                    Subscribers
                                </label>
                                <div class="relative">
                                    <select id="simple-subscriber-filter" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 appearance-none pr-10 bg-white text-xs">
                                        <option value="all" class="text-xs">All Subscribers</option>
                                        <option value="0-10000" class="text-xs">< 10K</option>
                                        <option value="10000-50000" class="text-xs">10K - 50K</option>
                                        <option value="50000+" class="text-xs">50K+</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sort By Filter -->
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                                    Sort By
                                </label>
                                <div class="relative">
                                    <select id="simple-sort-filter" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 appearance-none pr-10 bg-white text-xs">
                                        <option value="subscribers-desc" class="text-xs">Most Subscribers</option>
                                        <option value="subscribers-asc" class="text-xs">Least Subscribers</option>
                                        <option value="name-asc" class="text-xs">Name A-Z</option>
                                        <option value="name-desc" class="text-xs">Name Z-A</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Actions -->
                        <div class="p-3 bg-gray-50 border-t border-gray-100 flex justify-end space-x-2">
                            <button id="simple-reset-filter" class="px-3 py-1.5 bg-white text-gray-700 rounded-lg border border-gray-300 text-sm font-medium hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Reset
                            </button>
                            <button id="simple-apply-filter" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area - Mobile Optimized -->
        <div class="flex-1 p-2 sm:p-4 overflow-y-auto">
            <div class="max-w-7xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
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
    // DOM elements
    const filterBtn = document.getElementById('simple-filter-btn');
    const filterDropdown = document.getElementById('simple-filter-dropdown');
    const searchInput = document.getElementById('simple-search');
    const subscriberFilter = document.getElementById('simple-subscriber-filter');
    const sortFilter = document.getElementById('simple-sort-filter');
    const applyBtn = document.getElementById('simple-apply-filter');
    const resetBtn = document.getElementById('simple-reset-filter');
    const clearBtn = document.getElementById('clear-filters-btn');
    const channelCards = document.querySelectorAll('.channel-card');
    const channelsContainer = document.getElementById('channels-container');
    const noChannelsMsg = document.getElementById('no-channels-message');
    
    // Toggle dropdown
    if (filterBtn && filterDropdown) {
        filterBtn.addEventListener('click', function() {
            filterDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!filterBtn.contains(event.target) && !filterDropdown.contains(event.target)) {
                filterDropdown.classList.add('hidden');
            }
        });
    }
    
    // Apply filters
    function applyFilters() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const subscriberValue = subscriberFilter ? subscriberFilter.value : 'all';
        const sortValue = sortFilter ? sortFilter.value : 'subscribers-desc';
        
        let visibleCount = 0;
        
        // Filter cards
        channelCards.forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const subscribers = parseInt(card.getAttribute('data-subscribers') || '0');
            
            let isVisible = true;
            
            // Filter by search
            if (searchTerm && !name.includes(searchTerm)) {
                isVisible = false;
            }
            
            // Filter by subscribers
            if (subscriberValue !== 'all') {
                if (subscriberValue === '0-10000' && subscribers >= 10000) {
                    isVisible = false;
                } else if (subscriberValue === '10000-50000' && (subscribers < 10000 || subscribers > 50000)) {
                    isVisible = false;
                } else if (subscriberValue === '50000+' && subscribers < 50000) {
                    isVisible = false;
                }
            }
            
            // Show/hide card
            if (isVisible) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Sort visible cards
        if (channelsContainer) {
            const visibleCards = Array.from(channelCards).filter(card => card.style.display !== 'none');
            
            visibleCards.sort((a, b) => {
                const aName = (a.getAttribute('data-name') || '').toLowerCase();
                const bName = (b.getAttribute('data-name') || '').toLowerCase();
                const aSubscribers = parseInt(a.getAttribute('data-subscribers') || '0');
                const bSubscribers = parseInt(b.getAttribute('data-subscribers') || '0');
                
                if (sortValue === 'subscribers-desc') {
                    return bSubscribers - aSubscribers;
                } else if (sortValue === 'subscribers-asc') {
                    return aSubscribers - bSubscribers;
                } else if (sortValue === 'name-asc') {
                    return aName.localeCompare(bName);
                } else if (sortValue === 'name-desc') {
                    return bName.localeCompare(aName);
                }
                
                return 0;
            });
            
            // Reappend sorted cards
            visibleCards.forEach(card => {
                channelsContainer.appendChild(card);
            });
        }
        
        // Show/hide no results message
        if (noChannelsMsg) {
            if (visibleCount === 0) {
                channelsContainer.classList.add('hidden');
                noChannelsMsg.classList.remove('hidden');
            } else {
                channelsContainer.classList.remove('hidden');
                noChannelsMsg.classList.add('hidden');
            }
        }
        
        // Hide dropdown
        if (filterDropdown) {
            filterDropdown.classList.add('hidden');
        }
    }
    
    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    
    // Apply button
    if (applyBtn) {
        applyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }
    
    // Reset button
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            if (subscriberFilter) subscriberFilter.value = 'all';
            if (sortFilter) sortFilter.value = 'subscribers-desc';
            applyFilters();
        });
    }
    
    // Clear all filters button
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) searchInput.value = '';
            if (subscriberFilter) subscriberFilter.value = 'all';
            if (sortFilter) sortFilter.value = 'subscribers-desc';
            applyFilters();
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
