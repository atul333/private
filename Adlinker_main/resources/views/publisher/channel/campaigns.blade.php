@extends('layouts.app')

@section('content')
<div class="container-custom py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('publisher.dashboard') }}" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back
                    </a>
                    <h1 class="text-lg font-semibold text-gray-800">Channel Campaigns</h1>
                </div>
            </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                        <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex flex-col">
                                <h3 class="text-base font-medium opacity-90">Active Campaigns</h3>
                                <p class="text-2xl font-bold mt-2">{{ $channel->campaigns->where('status', 'active')->count() }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex flex-col">
                                <h3 class="text-base font-medium opacity-90">Total Budget</h3>
                                <p class="text-2xl font-bold mt-2">${{ number_format($channel->campaigns->sum('budget'), 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-violet-400 to-violet-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="flex flex-col">
                                <h3 class="text-base font-medium opacity-90">Completed Campaigns</h3>
                                <p class="text-2xl font-bold mt-2">{{ $channel->campaigns->where('status', 'completed')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    @if($channel->campaigns->count() > 0)
                        <div class="overflow-x-auto rounded-xl shadow-md border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl overflow-hidden border-separate border-spacing-0">
                                <thead class="bg-gradient-to-r from-gray-50 to-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Campaign Name</th>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Post Link</th>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        <th class="px-6 py-4 text-left text-[0.65rem] font-medium text-gray-500 uppercase tracking-wider">Time Left</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($channel->campaigns as $campaign)
                                        <tr class="hover:bg-gray-50 transition-all duration-300 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-gray-800">{{ $campaign->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-gray-600">${{ number_format($campaign->budget, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1.5 inline-flex text-[0.65rem] leading-5 font-semibold rounded-full shadow-sm transition-all duration-200 {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800 ring-2 ring-green-100/50' : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800 ring-2 ring-yellow-100/50' : 'bg-gray-100 text-gray-800 ring-2 ring-gray-100/50') }}">
                                                    {{ ucfirst($campaign->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                                                @if($campaign->post_link)
                                                    <a href="{{ $campaign->post_link }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm hover:shadow">View Post</a>
                                                @else
                                                    <a href="{{ route('publisher.campaign.submit-link.form', $campaign) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-sm hover:shadow">Submit Link</a>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs font-medium">
                                                @if($campaign->status === 'pending')
                                                    <div class="flex space-x-2">
                                                        <form action="{{ route('publisher.campaign.accept', $campaign) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm hover:shadow">Accept</button>
                                                        </form>
                                                        <form action="{{ route('publisher.campaign.reject', $campaign) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 shadow-sm hover:shadow">Reject</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($campaign->post_link && $campaign->status === 'active')
                                                    <div class="countdown-timer font-medium text-indigo-600" 
                                                         data-duration="{{ $campaign->duration * 24 * 60 * 60 }}" 
                                                         data-start-time="{{ $campaign->post_submitted_at }}"
                                                         data-campaign-id="{{ $campaign->id }}"
                                                    >Calculating...</div>
                                                @elseif(!$campaign->post_link && $campaign->status === 'active')
                                                    <span class="text-yellow-600 font-semibold bg-yellow-50 px-3 py-1.5 rounded-lg shadow-sm">Awaiting Post Link</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 transition-all duration-300 hover:bg-gray-100">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="mt-4 text-base font-semibold text-gray-900">No Active Campaigns</h3>
                            <p class="mt-2 text-xs text-gray-600">There are no campaigns currently associated with this channel.</p>
                            <p class="mt-4 text-xs text-gray-500">Campaigns will appear here once advertisers start booking your channel.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateCountdownTimers() {
    document.querySelectorAll('.countdown-timer').forEach(function(element) {
        try {
            const duration = parseInt(element.dataset.duration);
            const startTime = new Date(element.dataset.startTime).getTime();
            const now = new Date().getTime();
            
            if (isNaN(startTime)) {
                element.innerHTML = 'Invalid start time';
                return;
            }
            
            const elapsed = Math.floor((now - startTime) / 1000);
            const remaining = duration - elapsed;

            if (remaining <= 0) {
                element.innerHTML = '<span class="text-red-600 font-semibold bg-red-50 px-3 py-1.5 rounded-lg shadow-sm">Campaign Ended</span>';
                return;
            }

            const days = Math.floor(remaining / (24 * 60 * 60));
            const hours = Math.floor((remaining % (24 * 60 * 60)) / (60 * 60));
            const minutes = Math.floor((remaining % (60 * 60)) / 60);
            const seconds = remaining % 60;

            element.innerHTML = `<span class="text-green-600 font-semibold bg-green-50 px-3 py-1.5 rounded-lg shadow-sm">${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
        } catch (error) {
            console.error('Error updating countdown:', error);
            element.innerHTML = 'Error calculating time';
        }
    });
}

// Update countdown every second
setInterval(updateCountdownTimers, 1000);

// Initial update
updateCountdownTimers();
</script>
@endpush
@endsection