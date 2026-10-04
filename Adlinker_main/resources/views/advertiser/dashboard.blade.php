@extends('layouts.app') 

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#0088cc]/5 via-[#4361EE]/5 to-[#0099ff]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-2 bg-gradient-to-r from-[#0088cc]/10 to-[#0099ff]/10 border-b border-[#0088cc]/20 flex justify-between items-center min-h-[52px]">
      <div class="flex items-center">
        <a href="{{ route('platform.selection') }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-base sm:text-lg font-bold text-gray-900">{{ __('Advertiser Dashboard') }}</h1>
      </div>
      <div>
        <a href="/{{ Auth::id() }}/campaigns/create" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 whitespace-nowrap">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Create New Campaign
        </a>
      </div>
    </div>

    <!-- Platform Tab Switcher -->
    <div class="px-4 bg-white border-b border-gray-200 shrink-0">
      <div class="flex gap-0">
        <!-- Telegram Tab (Active) -->
        <a href="{{ url('/'. Auth::id() .'/advertiser/dashboard') }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-[#0088cc] text-[#0088cc] bg-sky-50/70 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
          </svg>
          Telegram
        </a>
        <!-- Instagram Tab -->
        <a href="{{ route('instagram.advertiser.dashboard', ['user' => Auth::id()]) }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-[#E1306C] hover:border-[#E1306C]/40 hover:bg-pink-50/40 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
          Instagram
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <!-- Fixed Metrics Section -->
    <div class="bg-white/40 backdrop-blur-sm px-3 sm:px-4 py-3 border-b border-[#0088cc]/10 shrink-0">
      <div class="grid grid-cols-3 gap-2 sm:gap-4">
        <div class="bg-gradient-to-br from-[#0088cc]/10 to-[#0099ff]/15 rounded-xl p-2.5 sm:p-4 text-[#0077b5] shadow-sm border border-[#0088cc]/20">
          <div class="text-center">
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-700 leading-tight">Active Campaigns</h3>
            <p class="text-sm sm:text-lg font-bold mt-1 text-gray-900">{{ $activeCampaigns }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#4361EE]/10 to-[#3A0CA3]/15 rounded-xl p-2.5 sm:p-4 text-[#4361EE] shadow-sm border border-[#4361EE]/20">
          <div class="text-center">
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-700 leading-tight">Total Spent</h3>
            <p class="text-sm sm:text-lg font-bold mt-1 text-gray-900 truncate">₹{{ number_format($totalSpent, 2) }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#0284c7]/10 to-[#0369a1]/15 rounded-xl p-2.5 sm:p-4 text-[#0284c7] shadow-sm border border-[#0284c7]/20">
          <div class="text-center">
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-700 leading-tight">Completed</h3>
            <p class="text-sm sm:text-lg font-bold mt-1 text-gray-900">{{ $completedCampaigns }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-3 sm:px-4 py-2.5 bg-white/50 backdrop-blur-sm border-b border-[#0088cc]/10">
      <form id="filterForm" action="{{ url()->current() }}" method="GET" class="flex justify-end items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()" class="text-xs sm:text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] py-1.5 sm:py-2 px-2 sm:px-3 min-w-[85px] bg-white">
          <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>

        <!-- Sort By -->
        <select name="sort" onchange="this.form.submit()" class="text-xs sm:text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] py-1.5 sm:py-2 px-2 sm:px-3 min-w-[100px] bg-white">
          <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
          <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price (High to Low)</option>
          <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Price (Low to High)</option>
          <option value="duration-high" {{ request('sort') == 'duration-high' ? 'selected' : '' }}>Duration (High to Low)</option>
          <option value="duration-low" {{ request('sort') == 'duration-low' ? 'selected' : '' }}>Duration (Low to High)</option>
        </select>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12">
      <!-- Campaign Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($campaigns as $campaign)
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-md overflow-hidden transition-all duration-300 border border-[#0088cc]/15 hover:border-[#0088cc]/30">
          <div class="relative p-4 sm:p-5">
            <!-- Status Badge -->
            <span class="absolute top-3.5 right-3.5 text-[11px] font-semibold px-2.5 py-0.5 rounded-full {{ $campaign->status === 'active' ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
              {{ $campaign->status === 'active' ? ($campaign->post_link ? 'Active' : 'Payment Successful') : ucfirst($campaign->status) }}
            </span>

            <!-- Campaign Details -->
            <div class="flex items-center mb-3 pr-20">
              @if($campaign->advertisement_image)
                <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover shadow-sm shrink-0">
              @else
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-sky-50 border border-sky-100 flex items-center justify-center text-[#0088cc] shrink-0">
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                  </svg>
                </div>
              @endif
              <div class="ml-3 min-w-0 flex-1">
                <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate">{{ $campaign->channel_name }}</h3>
                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ number_format($campaign->subscribers) }} Subscribers</p>
              </div>
            </div>

            <div class="text-sm text-gray-700 space-y-2">
              <p><span class="font-semibold">Duration:</span> {{ $campaign->duration }} days</p>
              <p><span class="font-semibold">Price:</span> <span class="text-green-600 font-semibold">₹{{ number_format($campaign->price, 2) }}</span></p>
              
              @if($campaign->advertisement_content)
                <p class="line-clamp-2 text-xs text-gray-600"><span class="font-semibold text-gray-700">Content:</span> {{ $campaign->advertisement_content }}</p>
              @endif

              @if($campaign->status === 'active')
                @if(!$campaign->post_submitted_at)
                  <div class="countdown-container rounded-lg bg-red-50 p-3 mb-2">
                    <div class="submission-countdown-timer text-xs" 
                         data-campaign-id="{{ $campaign->id }}"
                         data-created-at="{{ $campaign->created_at->toISOString() }}">
                      <div class="countdown-text text-red-600 font-semibold">
                        Time Left to Submit Post: <span class="submission-time">Loading...</span>
                      </div>
                    </div>
                  </div>
                @endif
                <p><span class="font-semibold">Campaign Timer:</span>
                  <span class="countdown-timer text-gray-600" 
                    data-campaign-id="{{ $campaign->id }}" 
                    data-duration="{{ $campaign->duration }}"
                    data-start="{{ $campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : '' }}"
                    data-submitted="{{ $campaign->post_submitted_at ? 'true' : 'false' }}">
                    <span class="countdown-text"></span>
                    {{ $campaign->post_submitted_at ? '' : 'Waiting for link submission...' }}
                  </span>
                </p>
              @endif
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-between items-center pt-3 border-t border-gray-100">
              <a href="{{ $campaign->channel_link }}" target="_blank" class="px-3.5 py-1.5 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-[#0088cc] to-[#0099ff] hover:from-[#0077b5] hover:to-[#0088cc] transition-all duration-300 shadow-sm hover:shadow">View Channel</a>
              @if($campaign->post_link)
                <a href="{{ $campaign->post_link }}" target="_blank" class="px-3.5 py-1.5 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4361EE] transition-all duration-300 shadow-sm hover:shadow">View Post</a>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500 py-12">No campaigns found.</div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#0088cc]/15">
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
              <a href="{{ $campaigns->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm border border-gray-200">
                Previous
              </a>
            @endif

            @if ($campaigns->hasMorePages())
              <a href="{{ $campaigns->nextPageUrl() }}" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#0088cc] to-[#0099ff] rounded-lg hover:from-[#0077b5] hover:to-[#0088cc] transition-all duration-200 shadow-sm hover:shadow">
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
@endsection

<script>
function updateSubmissionCountdown(element) {
    // Check if campaign is already expired
    if (element.dataset.status === 'expired') {
        element.querySelector('.submission-time').textContent = 'Campaign Expired';
        return;
    }

    const campaignId = element.dataset.campaignId;
    const createdAt = new Date(element.dataset.createdAt);
    const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 hours from creation
    const now = new Date();
    const timeLeft = deadline - now;

    if (timeLeft <= 0) {
        element.querySelector('.submission-time').textContent = 'Submission deadline passed';
        
        // Call the expire endpoint
        fetch(`/api/campaigns/${campaignId}/expire`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/login';
                    throw new Error('Please log in to continue');
                }
                if (response.status === 403) {
                    throw new Error('You are not authorized to expire this campaign');
                }
                return response.json().then(data => {
                    throw new Error(data.message || 'Failed to expire campaign');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (data.status === 'expired') {
                    element.dataset.status = 'expired';
                    element.querySelector('.submission-time').textContent = 'Campaign Expired';
                    
                    // Show refund success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'text-green-600 text-sm mt-2';
                    successDiv.textContent = `Campaign expired. $${data.refunded_amount} has been refunded to your wallet.`;
                    element.appendChild(successDiv);
                    
                    // Remove any error messages
                    const errorMsg = element.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                    
                    // Stop the countdown interval
                    if (element.dataset.countdownInterval) {
                        clearInterval(parseInt(element.dataset.countdownInterval));
                    }
                    
                    // Reload immediately
                    window.location.reload();
                }
            } else {
                console.error('Campaign expiration failed:', data.message);
                showError(element, data.message || 'Failed to expire campaign');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError(element, error.message);
            if (error.message.includes('not authorized')) {
                // If unauthorized, stop trying to expire
                element.dataset.status = 'unauthorized';
                // Stop the countdown interval
                if (element.dataset.countdownInterval) {
                    clearInterval(parseInt(element.dataset.countdownInterval));
                }
            }
        });
        
        return;
    }

    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.submission-time').textContent = 
        `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

// Helper function to show error messages
function showError(element, message) {
    // Remove any existing error message
    const existingError = element.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create and append new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-600 text-sm mt-2';
    errorDiv.textContent = message;
    element.appendChild(errorDiv);
}

function initializeSubmissionCountdowns() {
    const submissionTimers = document.querySelectorAll('.submission-countdown-timer');
    submissionTimers.forEach(timer => {
        timer.dataset.status = timer.dataset.status || 'active';
        updateSubmissionCountdown(timer);
        const intervalId = setInterval(() => updateSubmissionCountdown(timer), 1000);
        timer.dataset.countdownInterval = intervalId;
    });
}

function updateCampaignTimer(element) {
    const campaignId = element.dataset.campaignId;
    const duration = parseInt(element.dataset.duration) * 24 * 60 * 60 * 1000; // Convert days to milliseconds
    const startDate = element.dataset.start ? new Date(element.dataset.start) : null;
    const submitted = element.dataset.submitted === 'true';
    
    if (!submitted || !startDate) {
        element.querySelector('.countdown-text').textContent = 'Waiting for link submission...';
        return;
    }

    const now = new Date();
    const timeLeft = duration - (now - startDate);

    if (timeLeft <= 0) {
        element.querySelector('.countdown-text').textContent = 'Campaign Ended';
        
        // Call the complete endpoint
        fetch(`/api/campaigns/${campaignId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to complete campaign');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update the status badge
                const statusBadge = element.closest('.bg-white').querySelector('[class*="bg-"][class*="text-"]');
                if (statusBadge) {
                    statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800';
                    statusBadge.textContent = 'Completed';
                }
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'text-green-600 text-sm mt-2';
                successDiv.textContent = `Campaign completed. Publisher has been paid $${data.amount_paid}.`;
                element.appendChild(successDiv);
                
                // Reload the page after a short delay
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error completing campaign:', error);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-600 text-sm mt-2';
            errorDiv.textContent = 'Failed to complete campaign. Please refresh the page.';
            element.appendChild(errorDiv);
        });
        
        return;
    }

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.countdown-text').textContent = 
        `${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
}

// Initialize campaign timers
function initializeCampaignTimers() {
    const campaignTimers = document.querySelectorAll('.countdown-timer');
    campaignTimers.forEach(timer => {
        updateCampaignTimer(timer);
        setInterval(() => updateCampaignTimer(timer), 1000);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSubmissionCountdowns();
    initializeCampaignTimers();
});
</script>
