@extends('layouts.app') 

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
      <h1 class="text-lg font-bold text-black">{{ __('Advertiser Dashboard') }}</h1>
      <div>
        <a href="/{{ Auth::id() }}/campaigns/create" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow text-xs font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
          <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Create New Campaign
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
      <div class="grid grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-medium opacity-90">Active Campaigns</h3>
            <p class="text-lg font-bold mt-2">{{ $activeCampaigns }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#F72585]/20 to-[#B5179E]/20 rounded-xl p-4 text-[#B5179E] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#F72585]/30 hover:border-[#F72585]/50">
          <div class="text-center">
            <h3 class="text-sm font-medium opacity-90">Total Spent</h3>
            <p class="text-lg font-bold mt-2">${{ number_format($totalSpent, 2) }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-medium opacity-90">Completed Campaigns</h3>
            <p class="text-lg font-bold mt-2">{{ $completedCampaigns }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#4895EF]/10">
      <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[120px] flex-shrink-0">
          <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>

        <!-- Price Range Filter -->
        <select name="price_range" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[130px] flex-shrink-0">
          <option value="" {{ !request('price_range') ? 'selected' : '' }}>All Prices</option>
          <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>Under $50</option>
          <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>$50 - $100</option>
          <option value="100-200" {{ request('price_range') == '100-200' ? 'selected' : '' }}>$100 - $200</option>
          <option value="200+" {{ request('price_range') == '200+' ? 'selected' : '' }}>$200+</option>
        </select>

        <!-- Duration Filter -->
        <select name="duration" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[130px] flex-shrink-0">
          <option value="" {{ !request('duration') ? 'selected' : '' }}>All Durations</option>
          <option value="7" {{ request('duration') == '7' ? 'selected' : '' }}>7 Days</option>
          <option value="14" {{ request('duration') == '14' ? 'selected' : '' }}>14 Days</option>
          <option value="30" {{ request('duration') == '30' ? 'selected' : '' }}>30 Days</option>
        </select>

        <!-- Sort By -->
        <select name="sort" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[140px] flex-shrink-0">
          <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
          <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price (High to Low)</option>
          <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Price (Low to High)</option>
          <option value="duration-high" {{ request('sort') == 'duration-high' ? 'selected' : '' }}>Duration (High to Low)</option>
          <option value="duration-low" {{ request('sort') == 'duration-low' ? 'selected' : '' }}>Duration (Low to High)</option>
        </select>

        <!-- Search Input -->
        <input 
          type="text" 
          name="search" 
          value="{{ request('search') }}" 
          placeholder="Search channels..." 
          class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-3 min-w-[200px] flex-shrink-0"
        >

        <!-- Filter Button -->
        <button type="submit" class="text-sm bg-[#4361EE] hover:bg-[#3A0CA3] text-white font-medium py-2 px-3 sm:px-4 rounded-lg transition-colors flex-shrink-0">
          Apply Filters
        </button>

        <!-- Reset Button -->
        <a href="{{ url()->current() }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-3 sm:px-4 rounded-lg transition-colors flex-shrink-0">
          Reset
        </a>
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
            <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full {{ $campaign->status === 'active' ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
              {{ $campaign->status === 'active' ? ($campaign->post_link ? 'Active' : 'Payment Successful') : ucfirst($campaign->status) }}
            </span>

            <!-- Campaign Details -->
            <div class="flex items-center mb-4">
              @if($campaign->advertisement_image)
                <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" class="w-16 h-16 rounded-full object-cover shadow">
              @else
                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                  <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                  </svg>
                </div>
              @endif
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $campaign->channel_name }}</h3>
                <p class="text-sm text-gray-500">{{ number_format($campaign->subscribers) }} Subscribers</p>
              </div>
            </div>

            <div class="text-sm text-gray-700 space-y-2">
              <p><span class="font-semibold">Duration:</span> {{ $campaign->duration }} days</p>
              <p><span class="font-semibold">Price:</span> <span class="text-green-600">${{ number_format($campaign->price, 2) }}</span></p>
              
              @if($campaign->advertisement_content)
                <p class="line-clamp-2"><span class="font-semibold">Content:</span> {{ $campaign->advertisement_content }}</p>
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
            <div class="mt-4 flex justify-between items-center">
              <a href="{{ $campaign->channel_link }}" target="_blank" class="px-3 py-1.5 text-xs font-medium text-white/90 rounded-lg bg-gradient-to-r from-[#3A0CA3]/80 to-[#4361EE]/80 hover:from-[#3F37C9]/90 hover:to-[#4895EF]/90 transition-all duration-300 shadow-sm hover:shadow">View Channel</a>
              @if($campaign->post_link)
                <a href="{{ $campaign->post_link }}" target="_blank" class="px-3 py-1.5 text-xs font-medium text-white/90 rounded-lg bg-gradient-to-r from-[#F72585] to-[#B5179E] hover:from-[#B5179E] hover:to-[#F72585] transition-all duration-300 shadow-sm hover:shadow">View Post</a>
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
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-md border border-[#4895EF]/30 p-4">
          {{ $campaigns->links('pagination::tailwind') }}
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
    const deadline = new Date(createdAt.getTime() + (2 * 60 * 1000)); // 24 hours from creation
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
