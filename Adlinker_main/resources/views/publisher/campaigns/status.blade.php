@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
      <div class="flex items-center">
        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-lg font-bold text-black">{{ __('Campaign Status for') }} {{ $channel->name }}</h1>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#4895EF]/10">
      <form action="{{ url()->current() }}" method="GET" class="flex justify-between items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[90px]">
          <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>

        <!-- Sort By -->
        <select name="sort" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[110px]">
          <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
          <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price (High to Low)</option>
          <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Price (Low to High)</option>
          <option value="duration-high" {{ request('sort') == 'duration-high' ? 'selected' : '' }}>Duration (High to Low)</option>
          <option value="duration-low" {{ request('sort') == 'duration-low' ? 'selected' : '' }}>Duration (Low to High)</option>
        </select>

        <!-- Filter Button -->
        <button type="submit" class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-3 sm:px-4 rounded-lg transition-colors flex-shrink-0">
          Filter
        </button>

        <!-- Reset Button -->
        <a href="{{ url()->current() }}" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-3 sm:px-4 rounded-lg transition-colors flex-shrink-0">
          Reset
        </a>
      </form>
    </div>

    <!-- Main Content Area -->
    <div class="px-4 py-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="campaignGrid">
        @forelse($campaigns as $campaign)
          <div class="campaign-card bg-white rounded-2xl shadow-sm overflow-hidden border border-[#3A0CA3]/20 hover:border-[#3A0CA3]/40 hover:shadow-md transition-all duration-300"
               data-id="{{ $campaign->id }}"
               data-status="{{ $campaign->status }}"
               data-price="{{ $campaign->price }}"
               data-duration="{{ $campaign->duration }}"
               data-created="{{ $campaign->created_at->timestamp }}"
               data-link-status="{{ $campaign->post_submitted_at ? 'submitted' : 'pending' }}">
            <!-- Status Badge -->
            <div class="p-4 flex justify-between items-center">
              <p class="text-sm text-gray-600 font-medium">Campaign #{{ $campaign->id }}</p>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : 
                  ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($campaign->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                {{ ucfirst($campaign->status) }}
              </span>
            </div>
            
            <!-- Advertisement Content -->
            <div class="px-4">
              <!-- Image Section -->
              <div class="relative bg-gray-50 rounded-xl overflow-hidden mb-4 flex items-center justify-center h-48">
                @if($campaign->advertisement_image)
                  <img 
                    src="{{ asset('storage/' . $campaign->advertisement_image) }}" 
                    alt="Advertisement Image" 
                    class="w-full h-full object-contain"
                  >
                  <button 
                    onclick="downloadImage('{{ asset('storage/' . $campaign->advertisement_image) }}', '{{ basename($campaign->advertisement_image) }}')"
                    class="absolute top-2 right-2 p-2 bg-white/90 rounded-full shadow-sm hover:bg-white hover:shadow transition-all duration-200"
                    title="Download Image"
                  >
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                  </button>
                @else
                  <div class="flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">No Image Available</span>
                  </div>
                @endif
              </div>
              
              <!-- Text Content with Copy Button -->
              <div class="flex items-start space-x-2 mb-4">
                <div class="flex-1">
                  <p class="text-sm text-gray-700">{{ $campaign->advertisement_content }}</p>
                </div>
                <button 
                  onclick="copyToClipboard('{{ $campaign->advertisement_content }}', this)" 
                  class="flex-shrink-0 p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors"
                  title="Copy content"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                  </svg>
                </button>
              </div>
              
              <!-- Campaign Details -->
              <div class="flex justify-between items-center mb-4">
                <div class="flex items-center text-sm text-gray-600">
                  <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <span>{{ $campaign->duration }} days</span>
                </div>
                <div class="flex items-center text-sm font-medium text-gray-900">
                  <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  ${{ number_format($campaign->price, 2) }}
                </div>
              </div>
            </div>
            
            <!-- Action Section -->
            <div class="px-4 pb-4 space-y-3">
              @if($campaign->status === 'active')
                @if($campaign->post_submitted_at)
                  <button class="w-full py-2 px-4 rounded-lg bg-gray-100 text-gray-500 text-sm font-medium cursor-not-allowed" disabled>
                    Link Submitted
                  </button>
                @else
                  <a href="{{ route('publisher.campaign.submit-link.form', ['campaign' => $campaign->id]) }}" 
                     class="block w-full py-2 px-4 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-center text-sm font-medium transition-colors"
                     id="submitLinkBtn-{{ $campaign->id }}">
                    Submit Link
                  </a>
                @endif
              
                @if(!$campaign->post_submitted_at)
                  <div class="rounded-lg bg-red-50 p-3">
                    <div class="submission-countdown-timer flex items-center text-xs text-red-600" 
                         data-campaign-id="{{ $campaign->id }}"
                         data-created-at="{{ $campaign->created_at->toISOString() }}">
                      <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                      <div class="font-medium">
                        Time Left: <span class="submission-time">Loading...</span>
                      </div>
                    </div>
                  </div>
                @endif
                
                <div class="rounded-lg bg-gray-50 p-3">
                  <div class="countdown-timer flex items-center text-xs text-gray-600" 
                       data-campaign-id="{{ $campaign->id }}" 
                       data-duration="{{ $campaign->duration }}"
                       data-start="{{ $campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : '' }}"
                       data-submitted="{{ $campaign->post_submitted_at ? 'true' : 'false' }}">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="countdown-text font-medium">
                      {{ $campaign->post_submitted_at ? 'Loading...' : 'Waiting for link submission...' }}
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>
        @empty
          <div id="no-campaigns-message" class="col-span-full flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-500 text-lg">No active campaigns found</p>
            <p class="text-gray-400 text-sm mt-1">Check back later for new campaigns</p>
          </div>
          
          <div id="no-results-message" class="col-span-full flex flex-col items-center justify-center py-12 hidden">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h.01M3 15h.01M3 20h.01M8 3v1m0 5v1m0 5v1m0 5v1M12 3v1m0 5v1m0 5v1m0 5v1M16 3v1m0 5v1m0 5v1m0 5v1M20 3v1m0 5v1m0 5v1m0 5v1"/>
            </svg>
            <p class="text-gray-500 text-lg">No campaigns match your filters</p>
            <button id="clearFilters" class="mt-3 text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
              Clear All Filters
            </button>
          </div>
        @endforelse
      </div>
      
      <!-- Pagination -->
      <div class="mt-8">
        {{ $campaigns->links('pagination::tailwind') }}
      </div>
    </div>
  </div>
</div>

@endsection

<script>
function updateSubmissionCountdown(element) {
    const campaignId = element.dataset.campaignId;
    const createdAt = new Date(element.dataset.createdAt);
    const deadline = new Date(createdAt.getTime() + (2 * 60 * 1000)); // 24 hours from creation
    const now = new Date();
    const timeLeft = deadline - now;

    if (timeLeft <= 0) {
        element.querySelector('.submission-time').textContent = 'Submission deadline passed';
        const submitButton = document.querySelector(`#submitLinkBtn-${campaignId}`);
        if (submitButton) {
            submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'text-white');
            submitButton.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
            submitButton.setAttribute('disabled', 'disabled');
            submitButton.removeAttribute('href');
        }
        // Update campaign status to expired
        fetch(`/api/campaigns/${campaignId}/expire`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusBadge = document.querySelector(`[data-id="${campaignId}"] .inline-flex`);
                if (statusBadge) {
                    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                    statusBadge.textContent = 'Expired';
                }
            }
        })
        .catch(error => console.error('Error updating campaign status:', error));
        return;
    }

    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.submission-time').textContent = 
        `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

function updateCampaignStatus(campaignId) {
    fetch(`/api/campaigns/${campaignId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI to show completed status
            const campaignCard = document.querySelector(`[data-id="${campaignId}"]`);
            if (campaignCard) {
                const statusBadge = campaignCard.querySelector('.inline-flex');
                if (statusBadge) {
                    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                    statusBadge.textContent = 'Completed';
                }
            }
        }
    })
    .catch(error => console.error('Error updating campaign status:', error));
}

function checkAndUpdateCampaignStatus(element) {
    const campaignId = element.dataset.campaignId;
    const start = new Date(element.dataset.start);
    const duration = parseInt(element.dataset.duration);
    const now = new Date();
    const endTime = new Date(start.getTime() + (duration * 24 * 60 * 60 * 1000));

    if (now >= endTime && element.dataset.submitted === 'true') {
        updateCampaignStatus(campaignId);
        return true;
    }
    return false;
}

function initializeSubmissionCountdowns() {
    const submissionTimers = document.querySelectorAll('.submission-countdown-timer');
    submissionTimers.forEach(timer => {
        updateSubmissionCountdown(timer);
        setInterval(() => updateSubmissionCountdown(timer), 1000);
    });

    // Initialize campaign completion check
    const countdownTimers = document.querySelectorAll('.countdown-timer');
    countdownTimers.forEach(timer => {
        if (timer.dataset.submitted === 'true') {
            const checkInterval = setInterval(() => {
                if (checkAndUpdateCampaignStatus(timer)) {
                    clearInterval(checkInterval);
                }
            }, 1000);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSubmissionCountdowns();
});

function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(() => {
        const originalSvg = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        button.classList.remove('text-gray-500');
        button.classList.add('text-green-500');
        
        setTimeout(() => {
            button.innerHTML = originalSvg;
            button.classList.remove('text-green-500');
            button.classList.add('text-gray-500');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
        button.classList.remove('text-gray-500');
        button.classList.add('text-red-500');
        
        setTimeout(() => {
            button.classList.remove('text-red-500');
            button.classList.add('text-gray-500');
        }, 2000);
    });
}

function downloadImage(imageUrl, fileName) {
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        })
        .catch(error => console.error('Error downloading image:', error));
}
</script>
