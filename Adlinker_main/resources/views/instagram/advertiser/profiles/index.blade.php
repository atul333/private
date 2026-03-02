@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-2 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center min-h-[52px]">
      <div class="flex items-center">
        <a href="{{ route('instagram.advertiser.dashboard', ['user' => auth()->id()]) }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span></span>
        </a>
        <h1 class="text-sm sm:text-lg font-bold text-gray-800 whitespace-nowrap">Browse Profiles</h1>
      </div>
    </div>

    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#4895EF]/10">
      <form action="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" method="GET" id="filterForm" class="flex justify-end items-center gap-2">
        <!-- Combined Sort Dropdown -->
        <select name="sort_by" onchange="document.getElementById('filterForm').submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-3 w-full sm:w-auto sm:min-w-[180px]">
          <option value="max_followers" {{ request('sort_by', 'max_followers') == 'max_followers' ? 'selected' : '' }}>Max Followers</option>
          <option value="lower_followers" {{ request('sort_by') == 'lower_followers' ? 'selected' : '' }}>Lower Followers</option>
          <option value="max_price" {{ request('sort_by') == 'max_price' ? 'selected' : '' }}>Max Price</option>
          <option value="lower_price" {{ request('sort_by') == 'lower_price' ? 'selected' : '' }}>Lower Price</option>
        </select>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4">
      @if($profiles->count() > 0)
        <!-- Profiles Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
          @foreach($profiles as $profile)
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
              <div class="p-6 text-center">
                <div class="mb-4">
                  @if($profile->profile_photo)
                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $profile->instagram_id }}" class="w-24 h-24 rounded-full mx-auto object-cover shadow-md border-4 border-[#4CC9F0]/30">
                  @else
                    <div class="w-24 h-24 rounded-full mx-auto bg-gray-100 flex items-center justify-center shadow-md border-4 border-[#4CC9F0]/30">
                      <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                    </div>
                  @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ '@' . $profile->instagram_id }}</h3>
                <p class="text-sm text-gray-500 mb-3">
                  <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                  {{ number_format($profile->followers) }} followers
                </p>

                <div class="flex justify-center gap-2 mb-4 flex-wrap">
                  <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                    ₹{{ number_format($profile->price_per_story, 2) }}
                  </span>
                  @if($profile->mention_available)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                      <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                      </svg>
                      Mentions
                    </span>
                  @endif
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2">
                  <div class="flex justify-center">
                    <a href="https://instagram.com/{{ $profile->instagram_id }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-1.5 bg-white border border-purple-300 hover:border-purple-400 hover:bg-purple-50 text-purple-700 text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                      <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                      </svg>
                      View Instagram Profile
                    </a>
                  </div>
                  
                  <a href="{{ route('instagram.advertiser.campaigns.create', ['user' => auth()->id(), 'profile' => $profile->id]) }}" class="block w-full px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 hover:border-gray-400 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Campaign
                  </a>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#4895EF]/10">
          <p class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900">{{ $profiles->firstItem() ?? 0 }}</span> to
            <span class="font-medium text-gray-900">{{ $profiles->lastItem() ?? 0 }}</span> of
            <span class="font-medium text-gray-900">{{ $profiles->total() }}</span> results
          </p>

          <div class="flex items-center gap-2">
            @if ($profiles->onFirstPage())
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Previous
              </span>
            @else
              <a href="{{ $profiles->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                Previous
              </a>
            @endif

            @if ($profiles->hasMorePages())
              <a href="{{ $profiles->nextPageUrl() }}" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] rounded-lg hover:from-[#3F37C9] hover:to-[#4895EF] transition-all duration-200 shadow-sm hover:shadow">
                Next
              </a>
            @else
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Next
              </span>
            @endif
          </div>
        </div>
      @else
        <!-- No Profiles Found -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-[#4895EF]/30 p-12 text-center">
          <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">No profiles found</h3>
          <p class="text-gray-500 mb-4">Try adjusting your filters to see more results.</p>
          <a href="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Clear Filters
          </a>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
