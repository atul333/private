@extends('layouts.app') 

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 flex flex-col max-h-[90vh]">

                <!-- Fixed Header -->
                <div id="dashboardHeader" class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 flex justify-between items-center shrink-0 sticky top-0 z-10">
                    <h1 class="text-lg font-bold text-white">{{ __('Advertiser Dashboard') }}</h1>
                    <div>
                        <a href="/{{ Auth::id() }}/campaigns/create" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Create New Campaign
                        </a>
                    </div>
                </div>

                <!-- Scrollable Content Below Header -->
                <div id="scrollContainer" class="overflow-y-auto p-4 h-full">
                    <!-- Metrics Section -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-[#7209B7] to-[#560BAD] rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="text-center">
                                <h3 class="text-sm font-medium opacity-90">Active Campaigns</h3>
                                <p class="text-lg font-bold mt-2">{{ $activeCampaigns }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-[#F72585] to-[#B5179E] rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="text-center">
                                <h3 class="text-sm font-medium opacity-90">Total Budget</h3>
                                <p class="text-lg font-bold mt-2">${{ number_format($totalBudget, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-[#3A0CA3] to-[#4361EE] rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <div class="text-center">
                                <h3 class="text-sm font-medium opacity-90">Total Impressions</h3>
                                <p class="text-lg font-bold mt-2">{{ number_format($totalImpressions) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Campaign Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($campaigns as $campaign)
                        <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/20 transition hover:shadow-2xl hover:-translate-y-1">
                            <div class="relative p-6">
                                <!-- Status Badge -->
                                <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full 
                                    {{ $campaign->status === 'active' 
                                        ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')
                                        : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' 
                                        : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' 
                                        : 'bg-red-100 text-red-800')) }}">
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
                                    <a href="{{ $campaign->channel_link }}" target="_blank" class="px-4 py-2 text-sm text-white rounded-lg bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transition shadow-lg">View Channel</a>
                                    @if($campaign->post_link)
                                        <a href="{{ $campaign->post_link }}" target="_blank" class="px-3 py-2 text-sm text-white rounded-lg bg-gradient-to-r from-[#F72585] to-[#B5179E] hover:from-[#B5179E] hover:to-[#F72585] transition shadow">View Post</a>
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
                        {{ $campaigns->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
