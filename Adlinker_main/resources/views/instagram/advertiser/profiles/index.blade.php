@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col pb-28 sm:pb-12">
  <div class="flex flex-col flex-1">
    <!-- Header Section -->
    <div class="px-4 py-3 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/15 flex items-center min-h-[52px]">
      <div class="flex items-center">
        <a href="{{ route('instagram.advertiser.dashboard', ['user' => auth()->id()]) }}" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-base sm:text-lg font-bold text-gray-900">Browse Profiles</h1>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/70 backdrop-blur-sm border-b border-[#E1306C]/10">
      <form action="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" method="GET" id="filterForm" class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-2.5">
        <div class="text-xs sm:text-sm text-gray-600 font-medium">
          Available Instagram Creators
        </div>
        <div class="flex items-center gap-2">
          <label for="sort_by" class="text-xs text-gray-500 hidden sm:inline whitespace-nowrap">Sort by:</label>
          <select id="sort_by" name="sort_by" onchange="document.getElementById('filterForm').submit()" class="text-xs sm:text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#E1306C]/40 focus:border-[#E1306C] py-2 px-3 w-full sm:w-auto sm:min-w-[170px] bg-white font-medium text-gray-700 shadow-sm">
            <option value="max_followers" {{ request('sort_by', 'max_followers') == 'max_followers' ? 'selected' : '' }}>Most Followers</option>
            <option value="lower_followers" {{ request('sort_by') == 'lower_followers' ? 'selected' : '' }}>Least Followers</option>
            <option value="max_price" {{ request('sort_by') == 'max_price' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="lower_price" {{ request('sort_by') == 'lower_price' ? 'selected' : '' }}>Price: Low to High</option>
          </select>
        </div>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4 flex-1">
      @if($profiles->count() > 0)
        <!-- Profiles Grid: 1 column on mobile, 2 on tablet, 3-4 on desktop -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-4">
          @foreach($profiles as $profile)
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#E1306C]/20 hover:border-[#E1306C]/40 overflow-hidden group flex flex-col justify-between">
              <div class="p-4 sm:p-5">
                <!-- Top Row: Avatar + Info + Price Badge -->
                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-center gap-3 min-w-0">
                    <!-- Instagram Gradient Ring Avatar -->
                    <div class="relative shrink-0">
                      <div class="p-0.5 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] shadow-sm">
                        @if($profile->profile_photo)
                          <img src="{{ asset('storage/' . $profile->profile_photo) }}" alt="{{ $profile->instagram_id }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover bg-white p-0.5">
                        @else
                          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-pink-50 flex items-center justify-center text-[#E1306C] bg-white p-0.5">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                          </div>
                        @endif
                      </div>
                    </div>

                    <!-- Handle & Followers -->
                    <div class="min-w-0">
                      <h3 class="text-base font-bold text-gray-900 truncate group-hover:text-[#E1306C] transition-colors">
                        {{ '@' . $profile->instagram_id }}
                      </h3>
                      <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="font-medium text-gray-700">{{ number_format($profile->followers) }}</span> followers
                      </p>
                    </div>
                  </div>

                  <!-- Price Badge -->
                  <div class="shrink-0 text-right">
                    <span class="inline-block px-2.5 py-1 text-xs font-bold rounded-lg bg-green-50 text-green-700 border border-green-200">
                      ₹{{ number_format($profile->price_per_story, 2) }}
                    </span>
                    <p class="text-[10px] text-gray-400 mt-0.5 font-medium">per story</p>
                  </div>
                </div>
              </div>

              <!-- Action Buttons Row -->
              <div class="px-4 py-3 bg-gray-50/60 border-t border-gray-100 flex items-center gap-2">
                <a href="https://instagram.com/{{ $profile->instagram_id }}" target="_blank" rel="noopener noreferrer" 
                   class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-medium rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 hover:text-gray-900 transition-all duration-200 shadow-sm whitespace-nowrap">
                  <svg class="w-3.5 h-3.5 text-[#E1306C] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                  </svg>
                  <span>View Profile</span>
                </a>
                <a href="{{ route('instagram.advertiser.campaigns.create', ['user' => auth()->id(), 'profile' => $profile->id]) }}" 
                   class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-semibold rounded-lg text-white bg-gradient-to-r from-[#E1306C] to-[#FD1D1D] hover:from-[#C13584] hover:to-[#E1306C] transition-all duration-300 shadow-sm hover:shadow whitespace-nowrap">
                  <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                  </svg>
                  <span>Create Campaign</span>
                </a>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#E1306C]/15">
            <p class="text-sm text-gray-600 text-center sm:text-left">
              Showing <span class="font-medium text-gray-900">{{ $profiles->firstItem() ?? 0 }}</span> to
              <span class="font-medium text-gray-900">{{ $profiles->lastItem() ?? 0 }}</span> of
              <span class="font-medium text-gray-900">{{ $profiles->total() }}</span> results
            </p>

            <div class="flex items-center gap-2">
              @if ($profiles->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed border border-gray-200">
                  Previous
                </span>
              @else
                <a href="{{ $profiles->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm border border-gray-200">
                  Previous
                </a>
              @endif

              @if ($profiles->hasMorePages())
                <a href="{{ $profiles->nextPageUrl() }}" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#E1306C] to-[#FD1D1D] rounded-lg hover:from-[#C13584] hover:to-[#E1306C] transition-all duration-200 shadow-sm hover:shadow">
                  Next
                </a>
              @else
                <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed border border-gray-200">
                  Next
                </span>
              @endif
            </div>
          </div>
        </div>
      @else
        <!-- No Profiles Found -->
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-[#E1306C]/20 p-8 sm:p-12 text-center max-w-lg mx-auto my-8">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-pink-50 flex items-center justify-center text-[#E1306C]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-1">No profiles found</h3>
          <p class="text-sm text-gray-500 mb-4">Try adjusting your filters or check back later.</p>
          <a href="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
