@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-lg font-semibold text-gray-800">{{ __('Campaign Status for') }} {{ $channel->name }}</h1>
                    </div>

              
            </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($campaigns as $campaign)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <div class="relative bg-gradient-to-r from-blue-50 to-indigo-50 p-4">
                                    @if($campaign->advertisement_image)
                                        <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" 
                                             alt="Advertisement Image" 
                                             class="w-full h-32 object-contain rounded-lg">
                                    @else
                                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-4 right-4 px-3 py-1 rounded-full text-[0.65rem] font-semibold {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>

                                <div class="p-6 space-y-4">
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-start gap-2">
                                            <p class="text-xs text-gray-900 line-clamp-2 flex-grow">{{ $campaign->advertisement_content }}</p>
                                            <button onclick="copyContent('{{ $campaign->advertisement_content }}', '{{ asset('/storage/' . $campaign->advertisement_image) }}')"

                                                    class="inline-flex items-center px-2 py-1 text-[0.65rem] font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                                </svg>
                                                Copy & Download
                                            </button>
                                        </div>
                                        <div class="flex justify-between items-center text-xs text-gray-500">
                                            <span>{{ $campaign->duration }} days</span>
                                            <span>${{ number_format($campaign->price, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        @if($campaign->status === 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('publisher.campaign.accept', ['campaign' => $campaign->id]) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Accept</button>
                                                </form>
                                                <form action="{{ route('publisher.campaign.reject', ['campaign' => $campaign->id]) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Reject</button>
                                                </form>
                                            </div>
                                        @elseif($campaign->status === 'active')
                                            @if($campaign->post_submitted_at)
                                                <button class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 opacity-50 cursor-not-allowed" disabled>Link Submitted</button>
                                            @else
                                                <a href="{{ route('publisher.campaign.submit-link.form', ['campaign' => $campaign->id]) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="submitLinkBtn-{{ $campaign->id }}">Submit Link</a>
                                            @endif
                                        @endif

                                        @if($campaign->status === 'active')
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
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyContent(content, imageUrl) {
    console.log('Copy operation started');
    
    // Disable the button during operation
    const button = event.currentTarget;
    button.disabled = true;
    console.log('Button disabled');
    
    // Save original button state
    const originalText = button.innerHTML;
    const originalClasses = button.className;
    console.log('Original button state saved');
    
    // Copy to clipboard
    console.log('Attempting to copy content:', content);
    navigator.clipboard.writeText(content)
        .then(() => {
            console.log('Content successfully copied to clipboard');
            // Show success state
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Copied!`;
            button.classList.remove('bg-blue-100', 'text-blue-700');
            button.classList.add('bg-green-100', 'text-green-700');
            console.log('Button updated to success state');
            
            // Download image if URL is provided
            if (imageUrl) {
                const link = document.createElement('a');
                link.href = imageUrl;
                link.download = 'campaign-image' + imageUrl.substring(imageUrl.lastIndexOf('.'));
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
            
            // Reset button state after delay
            setTimeout(() => {
                console.log('Resetting button state');
                button.disabled = false;
                button.innerHTML = originalText;
                button.className = originalClasses;
                console.log('Button state reset completed');
            }, 2000);
        })
        .catch(err => {
            console.error('Clipboard operation failed:', err);
            // Show error state
            button.innerHTML = `
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Failed!`;
            button.classList.remove('bg-blue-100', 'text-blue-700');
            button.classList.add('bg-red-100', 'text-red-700');
            console.log('Button updated to error state');
            
            // Reset button state after delay
            setTimeout(() => {
                console.log('Resetting button state after error');
                button.disabled = false;
                button.innerHTML = originalText;
                button.className = originalClasses;
                console.log('Button state reset completed');
            }, 2000);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Any additional initialization code can go here
});
</script>
@endpush

@endsection