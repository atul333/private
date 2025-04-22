@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
  <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#CDB4DB]/20 flex justify-between items-center shrink-0">
      <div class="flex items-center">
        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          
        </a>
        <h1 class="text-lg font-bold text-black">{{ __('Campaign Status for') }} {{ $channel->name }}</h1>
      </div>
    </div>

    <!-- Scrollable Content Area -->
    <div class="flex-1 overflow-y-auto p-6 min-h-0">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($campaigns as $campaign)
                            <!-- Individual Campaign Card -->
                            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 border border-[#4895EF]/30 hover:border-[#4361EE]/50 transform hover:-translate-y-2 hover:scale-[1.02] group relative before:absolute before:inset-0 before:bg-gradient-to-br before:from-white/50 before:to-transparent before:opacity-0 hover:before:opacity-100 before:transition-opacity before:duration-500 before:pointer-events-none">
                                <!-- Advertisement Section -->
                                <div class="relative bg-gradient-to-br from-[#4CC9F0]/10 to-[#3A0CA3]/10 p-6 group-hover:from-[#4CC9F0]/20 group-hover:to-[#3A0CA3]/20 transition-colors duration-500">
                                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 shadow-md group-hover:shadow-lg transition-all duration-500 border border-white/20 group-hover:border-white/40">
                                        <div class="advertisement-content space-y-2">
                                            @if($campaign->advertisement_image)
                                                <div class="relative">
                                                    <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" 
                                                         alt="Advertisement Image" 
                                                         class="w-full h-32 object-contain rounded-lg">
                                                    <button onclick="downloadImage('{{ asset('storage/' . $campaign->advertisement_image) }}', '{{ basename($campaign->advertisement_image) }}')"
                                                            class="absolute top-2 right-2 p-2 bg-white/80 rounded-full hover:bg-white/90 transition-all duration-300 shadow-sm hover:shadow group/download">
                                                        <svg class="w-4 h-4 text-gray-600 group-hover/download:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <span class="text-gray-400">No Image</span>
                                                </div>
                                            @endif
                                            <div class="advertisement-details mt-2">
                                                <div class="flex justify-between items-start gap-2">
                                                    <p class="text-xs text-gray-900 line-clamp-2 flex-grow">{{ $campaign->advertisement_content }}</p>
                                                    <button onclick="copyToClipboard('{{ $campaign->advertisement_content }}', this)" class="ml-2 p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100/80 backdrop-blur-sm transition-all duration-300 hover:shadow-md" title="Copy content">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        </div>
                                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[0.65rem] font-semibold {{ $campaign->status === 'active' ? 'bg-[#4CC9F0]/20 text-[#3A0CA3] border border-[#4CC9F0]' : ($campaign->status === 'pending' ? 'bg-[#F72585]/20 text-[#B5179E] border border-[#F72585]' : 'bg-red-100 text-red-800 border border-red-300') }}">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                </div>

                                <div class="p-1 space-y-2">
                                    <div class="space-y-2">
                                        <div class="bg-white/70 backdrop-blur-lg rounded-xl p-4 shadow-lg hover:shadow-xl transition-all duration-500 border border-[#4895EF]/20 hover:border-[#4361EE]/40 transform hover:-translate-y-1 group/inner">
                                            <div class="flex justify-between items-center text-xs text-gray-600/90 mt-2 group-hover:text-gray-700/90 transition-colors duration-300">
                                                <span class="font-medium">{{ $campaign->duration }} days</span>
                                                <span class="font-medium">${{ number_format($campaign->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @if($campaign->status === 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('publisher.campaign.accept', ['campaign' => $campaign->id]) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-[#7209B7] bg-[#7209B7]/10 text-[#560BAD] hover:bg-[#7209B7]/20 shadow-sm text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7209B7] transition-all duration-300">Accept</button>
                                                </form>
                                                <form action="{{ route('publisher.campaign.reject', ['campaign' => $campaign->id]) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-[#B5179E] shadow-sm text-xs font-medium rounded-md bg-[#B5179E]/10 text-[#B5179E] hover:bg-[#B5179E]/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B5179E] transition-all duration-300">Reject</button>
                                                </form>
                                            </div>
                                        @elseif($campaign->status === 'active')
                                            @if($campaign->post_submitted_at)
                                                <button class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 opacity-50 cursor-not-allowed" disabled>Link Submitted</button>
                                            @else
                                                <a href="{{ route('publisher.campaign.submit-link.form', ['campaign' => $campaign->id]) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-[#4361EE] shadow-sm text-xs font-medium rounded-md bg-[#4361EE]/10 text-[#3A0CA3] hover:bg-[#4361EE]/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] transition-all duration-300" id="submitLinkBtn-{{ $campaign->id }}">Submit Link</a>
                                            @endif
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
                                            <div class="countdown-container rounded-lg bg-gray-50 p-3">
                                                <div class="countdown-timer text-xs" data-campaign-id="{{ $campaign->id }}" 
                                                     data-duration="{{ $campaign->duration }}"
                                                     data-start="{{ $campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : '' }}"
                                                     data-submitted="{{ $campaign->post_submitted_at ? 'true' : 'false' }}">
                                                    <div class="countdown-text">
                                                        {{ $campaign->post_submitted_at ? 'Loading...' : 'Waiting for link submission...' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                No active campaigns found
                            </div>
                        @endforelse
                    </div>
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $campaigns->links('pagination::tailwind') }}
                    </div>
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
        const submitButton = document.querySelector(`#submitLinkBtn-${campaignId}`);
        if (submitButton) {
            submitButton.classList.remove('bg-[#4361EE]/10', 'text-[#3A0CA3]', 'hover:bg-[#4361EE]/20');
            submitButton.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
            submitButton.setAttribute('disabled', 'disabled');
            submitButton.removeAttribute('href');
            
            // Process refund when submission deadline passes
            fetch(`/api/campaigns/${campaignId}/refund`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Refund processed successfully');
                } else {
                    console.error('Failed to process refund:', data.message);
                }
            })
            .catch(error => console.error('Error processing refund:', error));
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
