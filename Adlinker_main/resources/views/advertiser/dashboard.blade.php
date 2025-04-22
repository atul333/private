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
    const campaignId = element.dataset.campaignId;
    const createdAt = new Date(element.dataset.createdAt);
    const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 hours from creation
    const now = new Date();
    const timeLeft = deadline - now;

    if (timeLeft <= 0) {
        element.querySelector('.submission-time').textContent = 'Submission deadline passed';
        return;
    }

    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.submission-time').textContent = 
        `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

function initializeSubmissionCountdowns() {
    const submissionTimers = document.querySelectorAll('.submission-countdown-timer');
    submissionTimers.forEach(timer => {
        updateSubmissionCountdown(timer);
        setInterval(() => updateSubmissionCountdown(timer), 1000);
    });
}

document.addEventListener('DOMContentLoaded', initializeSubmissionCountdowns);
</script>
