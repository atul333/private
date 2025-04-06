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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Active Campaigns</h3>
                                <p class="text-3xl font-bold mt-2">{{ $activeCampaigns }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Total Budget</h3>
                                <p class="text-3xl font-bold mt-2">${{ number_format($totalBudget, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Total Impressions</h3>
                                <p class="text-3xl font-bold mt-2">{{ number_format($totalImpressions) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($campaigns as $campaign)
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $campaign->channel_name }}</h3>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $campaign->status === 'active' ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">{{ $campaign->status === 'active' ? ($campaign->post_link ? 'Active' : 'Payment Successful') : ($campaign->status === 'pending' ? 'Payment Unsuccessful' : ucfirst($campaign->status)) }}</span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Subscribers</p>
                                        <p class="text-sm text-gray-900">{{ number_format($campaign->subscribers) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Duration</p>
                                        <p class="text-sm text-gray-900">{{ $campaign->duration }} days</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Price</p>
                                        <p class="text-sm text-gray-900">${{ number_format($campaign->price, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Channel</p>
                                        <a href="{{ $campaign->channel_link }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900">View Channel</a>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    @if($campaign->advertisement_image)
                                        <div class="relative w-full h-32 rounded-lg overflow-hidden shadow-sm bg-gray-100 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" alt="Advertisement" class="w-full h-full object-contain">
                                        </div>
                                    @endif

                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Content</p>
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($campaign->advertisement_content, 100) }}</p>
                                    </div>
                                </div>

                                @if($campaign->status === 'active')
                                    <div class="countdown-container mb-4">
                                        <p class="text-sm font-medium text-gray-500 mb-1">Campaign Timer</p>
                                        <div class="countdown-timer" data-campaign-id="{{ $campaign->id }}" 
                                             data-duration="{{ $campaign->duration }}"
                                             data-start="{{ $campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : '' }}"
                                             data-submitted="{{ $campaign->post_submitted_at ? 'true' : 'false' }}">
                                            <div class="countdown-text text-sm text-gray-900">
                                                {{ $campaign->post_submitted_at ? 'Loading...' : 'Waiting for link submission...' }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($campaign->post_link)
                                    <a href="{{ $campaign->post_link }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full justify-center">View Post</a>
                                @endif
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