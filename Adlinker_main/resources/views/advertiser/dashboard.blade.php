@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-800">{{ __('Advertiser Dashboard') }}</h1>
                <div>
                    <a href="/{{ Auth::id() }}/campaigns/create" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Create New Campaign
                    </a>
                </div>
            </div>

                <div class="p-6">
                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium opacity-90">Active Campaigns</h3>
                                <p class="text-lg font-bold mt-2">{{ $activeCampaigns }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium opacity-90">Total Budget</h3>
                                <p class="text-base font-bold mt-2">${{ number_format($totalBudget, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium opacity-90">Total Impressions</h3>
                                <p class="text-base font-bold mt-2">{{ number_format($totalImpressions) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        @forelse($campaigns as $campaign)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <div class="absolute top-4 right-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $campaign->status === 'active' ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $campaign->status === 'active' ? ($campaign->post_link ? 'Active' : 'Payment Successful') : ($campaign->status === 'pending' ? 'Payment Unsuccessful' : ucfirst($campaign->status)) }}
                                        </span>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 mb-4">
                                            @if($campaign->advertisement_image)
                                                <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" alt="Advertisement" class="h-16 w-16 rounded-full object-cover shadow-sm">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $campaign->channel_name }}</h3>
                                                <div class="flex items-center mt-1">
                                                    <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    <span class="text-sm text-gray-500">{{ number_format($campaign->subscribers) }} Subscribers</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="border-t border-gray-100 pt-4">
                                            <div class="grid grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Duration</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $campaign->duration }} days</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Price</p>
                                                    <p class="text-sm font-medium text-green-600">${{ number_format($campaign->price, 2) }}</p>
                                                </div>
                                            </div>

                                            @if($campaign->advertisement_content)
                                                <div class="mb-4">
                                                    <p class="text-sm font-medium text-gray-500 mb-1">Content</p>
                                                    <p class="text-sm text-gray-700 line-clamp-2">{{ $campaign->advertisement_content }}</p>
                                                </div>
                                            @endif

                                            @if($campaign->status === 'active')
                                                <div class="mb-4">
                                                    <p class="text-sm font-medium text-gray-500 mb-1">Campaign Timer</p>
                                                    <div class="countdown-timer text-sm text-gray-700" data-campaign-id="{{ $campaign->id }}" 
                                                         data-duration="{{ $campaign->duration }}"
                                                         data-start="{{ $campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : '' }}"
                                                         data-submitted="{{ $campaign->post_submitted_at ? 'true' : 'false' }}">
                                                        <span class="countdown-text"></span>
                                                        {{ $campaign->post_submitted_at ? '' : 'Waiting for link submission...' }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between space-x-3">
                                                <a href="{{ $campaign->channel_link }}" target="_blank" 
                                                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View Channel
                                                </a>
                                                @if($campaign->post_link)
                                                    <a href="{{ $campaign->post_link }}" target="_blank" 
                                                       class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        View Post
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                No campaigns found
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- The countdown timer functionality is now handled by countdown.js -->
@endpush
