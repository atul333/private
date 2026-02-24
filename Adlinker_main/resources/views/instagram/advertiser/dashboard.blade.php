@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center">
      <div class="flex items-center">
        <a href="{{ route('platform.selection') }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200 flex-shrink-0">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span></span>
        </a>
        <h1 class="text-sm font-bold text-gray-800 leading-tight max-w-[200px]">{{ __('Instagram Advertiser Dashboard') }}</h1>
      </div>
      <div class="flex-shrink-0">
        <a href="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" class="inline-flex items-center px-2 py-1 bg-white border border-gray-300 rounded-lg shadow-sm text-xs font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 max-w-[100px] text-center leading-tight">
          <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          <span class="break-words">Create New Campaign</span>
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
      <div class="grid grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Active Campaigns</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900">{{ $activeCampaigns }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#F72585]/20 to-[#B5179E]/20 rounded-xl p-4 text-[#B5179E] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#F72585]/30 hover:border-[#F72585]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Total Spent</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900">₹{{ number_format($totalSpent, 2) }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Completed Campaigns</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900">{{ $completedCampaigns }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#4895EF]/10">
      <form id="filterForm" action="{{ url()->current() }}" method="GET" class="flex justify-end items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[90px]">
          <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <!-- Sort By -->
        <select name="sort" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[110px]">
          <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
          <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price (High to Low)</option>
          <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Price (Low to High)</option>
        </select>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4">
      <!-- Campaign Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($campaigns as $campaign)
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
          <div class="relative p-6">
            <!-- Status Badge -->
            <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full 
              {{ $campaign->status === 'approved' ? 'bg-green-100 text-green-800' : 
                 ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                 ($campaign->status === 'published' ? 'bg-purple-100 text-purple-800' : 
                 ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800'))) }}">
              {{ ucfirst($campaign->status) }}
            </span>

            <!-- Campaign Details -->
            <div class="flex items-center mb-4">
              @if($campaign->instagramProfile->profile_photo)
                <img src="{{ asset('storage/' . $campaign->instagramProfile->profile_photo) }}" class="w-16 h-16 rounded-full object-cover shadow">
              @else
                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                  <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                  </svg>
                </div>
              @endif
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ '@' . $campaign->instagramProfile->instagram_id }}</h3>
                <p class="text-sm text-gray-500">{{ number_format($campaign->instagramProfile->followers) }} Followers</p>
              </div>
            </div>

            <div class="text-sm text-gray-700 space-y-2">
              <p><span class="font-semibold">Media:</span> {{ ucfirst($campaign->media_type) }}</p>
              <p><span class="font-semibold">Price:</span> <span class="text-green-600">₹{{ number_format($campaign->price, 2) }}</span></p>
              
              @if($campaign->caption)
                <p class="line-clamp-2"><span class="font-semibold">Caption:</span> {{ $campaign->caption }}</p>
              @endif

              <p><span class="font-semibold">Payment:</span> 
                @if($campaign->paid)
                  <span class="text-green-600">Paid</span>
                @else
                  <span class="text-red-600">Unpaid</span>
                @endif
              </p>

              @if($campaign->status === 'published' && $campaign->published_at)
                @php
                    $publishedAt = $campaign->published_at;
                    $completionTime = $publishedAt->copy()->addHours(24);
                    $now = now();
                    // Calculate remaining seconds: if completion time is in future, get positive difference
                    $remainingSeconds = $completionTime > $now ? $completionTime->diffInSeconds($now) : 0;
                @endphp
                <div class="mt-3 pt-3 border-t border-gray-200">
                  <p class="font-semibold text-blue-600 mb-2 text-xs">Time Remaining:</p>
                  <div class="flex items-center justify-center gap-1 text-center" data-countdown="{{ $remainingSeconds }}" data-campaign-id="{{ $campaign->id }}">
                    <div class="bg-blue-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-blue-600 countdown-hours">{{ str_pad(floor($remainingSeconds / 3600), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">H</div>
                    </div>
                    <div class="text-lg font-bold text-blue-600">:</div>
                    <div class="bg-blue-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-blue-600 countdown-minutes">{{ str_pad(floor(($remainingSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">M</div>
                    </div>
                    <div class="text-lg font-bold text-blue-600">:</div>
                    <div class="bg-blue-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-blue-600 countdown-seconds">{{ str_pad($remainingSeconds % 60, 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">S</div>
                    </div>
                  </div>
                </div>
              @else
                <!-- Spacer to maintain consistent card height -->
                <div class="mt-3 pt-3 border-t border-gray-200">
                  <div class="h-16"></div>
                </div>
              @endif
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-between items-center gap-2">
              <a href="{{ route('instagram.advertiser.campaigns.show', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" class="px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600 transition-colors duration-200 shadow-sm hover:shadow flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Details
              </a>
              
              @if($campaign->status === 'published' && $campaign->story_link)
                <a href="{{ $campaign->story_link }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 text-sm font-medium text-white rounded-lg bg-purple-500 hover:bg-purple-600 transition-colors duration-200 shadow-sm hover:shadow flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                  </svg>
                  View Story
                </a>
              @endif
              
              @if(!$campaign->paid)
                <a href="{{ route('instagram.advertiser.campaigns.payment', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" class="px-4 py-2 text-sm font-medium text-white rounded-lg bg-green-500 hover:bg-green-600 transition-colors duration-200 shadow-sm hover:shadow flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                  </svg>
                  Pay
                </a>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500 py-8">No campaigns found.</div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#4895EF]/10">
          <p class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900">{{ $campaigns->firstItem() ?? 0 }}</span> to
            <span class="font-medium text-gray-900">{{ $campaigns->lastItem() ?? 0 }}</span> of
            <span class="font-medium text-gray-900">{{ $campaigns->total() }}</span> results
          </p>

          <div class="flex items-center gap-2">
            @if ($campaigns->onFirstPage())
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Previous
              </span>
            @else
              <a href="{{ $campaigns->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                Previous
              </a>
            @endif

            @if ($campaigns->hasMorePages())
              <a href="{{ $campaigns->nextPageUrl() }}" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] rounded-lg hover:from-[#3F37C9] hover:to-[#4895EF] transition-all duration-200 shadow-sm hover:shadow">
                Next
              </a>
            @else
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Next
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Live countdown timer
document.addEventListener('DOMContentLoaded', function() {
    const countdownElements = document.querySelectorAll('[data-countdown]');
    
    countdownElements.forEach(function(element) {
        let remainingSeconds = parseInt(element.getAttribute('data-countdown'));
        
        // Update countdown every second
        const interval = setInterval(function() {
            if (remainingSeconds <= 0) {
                clearInterval(interval);
                // Reload page to show completion message
                window.location.reload();
                return;
            }
            
            remainingSeconds--;
            
            // Calculate hours, minutes, seconds
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;
            
            // Update display
            const hoursEl = element.querySelector('.countdown-hours');
            const minutesEl = element.querySelector('.countdown-minutes');
            const secondsEl = element.querySelector('.countdown-seconds');
            
            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }, 1000);
    });
});
</script>
@endsection
