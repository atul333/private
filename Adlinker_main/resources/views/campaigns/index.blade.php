@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-sky-50 to-blue-50/80 border-b border-[#0088cc]/15 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900">Your Campaigns</h1>
            </div>
            <a href="{{ route('campaigns.create', ['user' => auth()->id()]) }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 whitespace-nowrap">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Campaign
            </a>
        </div>

        <!-- Content Section -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12 flex-1">
            @if (session('status'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            @if($campaigns->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($campaigns as $campaign)
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#0088cc]/20 hover:border-[#0088cc]/40 overflow-hidden">
                            <div class="p-4 sm:p-5">
                                <!-- Channel name + Status Badge -->
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-sm font-bold text-gray-900 truncate pr-2">{{ $campaign->channel_name }}</h3>
                                    <span class="shrink-0 px-2 py-0.5 text-xs font-semibold rounded-full
                                        {{ $campaign->status === 'active' ? 'bg-green-100 text-green-800' :
                                           ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                           ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </div>

                                <!-- Campaign Details -->
                                <div class="space-y-1.5 text-xs text-gray-600">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span><span class="font-medium text-gray-700">{{ number_format($campaign->subscribers) }}</span> subscribers</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $campaign->duration }} days</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <span class="font-semibold text-green-600">&#8377;{{ number_format($campaign->price, 2) }}</span>
                                    </div>
                                </div>

                                @if($campaign->advertisement_image)
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/' . $campaign->advertisement_image) }}"
                                             alt="Advertisement"
                                             class="w-full h-28 object-cover rounded-lg border border-gray-200">
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="px-4 py-3 bg-gray-50/60 border-t border-gray-100 flex items-center gap-2">
                                <a href="{{ route('campaigns.show', ['user' => auth()->id(), 'campaign' => $campaign]) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1 py-1.5 px-2 text-xs font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                    View
                                </a>
                                <a href="{{ route('campaigns.edit', ['user' => auth()->id(), 'campaign' => $campaign]) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1 py-1.5 px-2 text-xs font-medium rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-700 hover:bg-yellow-100 transition-all duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('campaigns.destroy', ['user' => auth()->id(), 'campaign' => $campaign]) }}"
                                      method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this campaign?')"
                                            class="w-full inline-flex items-center justify-center gap-1 py-1.5 px-2 text-xs font-medium rounded-lg bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 transition-all duration-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-[#0088cc]/20 p-8 sm:p-12 text-center max-w-lg mx-auto my-8">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-50 flex items-center justify-center text-[#0088cc]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No campaigns yet</h3>
                    <p class="text-sm text-gray-500 mb-4">Create your first campaign to get started!</p>
                    <a href="{{ route('campaigns.create', ['user' => auth()->id()]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-[#0088cc] to-[#0099ff] text-white rounded-lg shadow-sm text-sm font-medium hover:from-[#0077b5] hover:to-[#0088cc] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Create Campaign
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection