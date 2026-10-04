@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#FD1D1D]/5 via-[#E1306C]/5 to-[#833AB4]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-2 bg-gradient-to-r from-[#FFEEF8] via-[#FFF0F5] to-[#FFF4E6] border-b border-[#E1306C]/15 flex justify-between items-center min-h-[52px]">
      <div class="flex items-center">
        <a href="{{ route('platform.selection') }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-base sm:text-lg font-bold text-gray-900">{{ __('Advertiser Dashboard') }}</h1>
      </div>
      <div>
        <a href="{{ route('instagram.advertiser.profiles.index', ['user' => auth()->id()]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 whitespace-nowrap">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Create New Campaign
        </a>
      </div>
    </div>

    <!-- Platform Tab Switcher -->
    <div class="px-4 bg-white border-b border-gray-200 shrink-0">
      <div class="flex gap-0">
        <!-- Telegram Tab -->
        <a href="{{ url('/'. auth()->id() .'/advertiser/dashboard') }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-[#0088cc] hover:border-[#0088cc]/40 hover:bg-sky-50/40 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
          </svg>
          Telegram
        </a>
        <!-- Instagram Tab (Active) -->
        <a href="{{ route('instagram.advertiser.dashboard', ['user' => auth()->id()]) }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-[#E1306C] text-[#E1306C] bg-pink-50/70 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
          Instagram
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/40 backdrop-blur-sm px-4 py-3 border-b border-[#E1306C]/10 shrink-0">
      <div class="grid grid-cols-3 gap-3 sm:gap-4">
        <div class="bg-gradient-to-br from-[#833AB4]/15 to-[#C13584]/15 rounded-xl p-3 sm:p-4 text-[#833AB4] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#833AB4]/30 hover:border-[#833AB4]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Active Campaigns</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900">{{ $activeCampaigns }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#E1306C]/15 to-[#FD1D1D]/15 rounded-xl p-3 sm:p-4 text-[#E1306C] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#E1306C]/30 hover:border-[#E1306C]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Total Spent</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900">₹{{ number_format($totalSpent, 2) }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#F56040]/15 to-[#FCAF45]/20 rounded-xl p-3 sm:p-4 text-[#E1306C] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#F56040]/30 hover:border-[#F56040]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Completed Campaigns</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900">{{ $completedCampaigns }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#E1306C]/10">
      <form id="filterForm" action="{{ url()->current() }}" method="GET" class="flex justify-end items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#E1306C]/40 focus:border-[#E1306C] py-2 px-2 sm:px-3 min-w-[90px] bg-white">
          <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
          <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>

        <!-- Sort By -->
        <select name="sort" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#E1306C]/40 focus:border-[#E1306C] py-2 px-2 sm:px-3 min-w-[110px] bg-white">
          <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
          <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price (High to Low)</option>
          <option value="price-low" {{ request('sort') == 'price-low' ? 'selected' : '' }}>Price (Low to High)</option>
        </select>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4">
      <!-- Campaign Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($campaigns as $campaign)
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#E1306C]/20 hover:border-[#E1306C]/40">
          <div class="relative p-6">
            <!-- Status Badge -->
            <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full 
              {{ $campaign->status === 'approved'  ? 'bg-green-100 text-green-800'  : 
                 ($campaign->status === 'pending'   ? 'bg-yellow-100 text-yellow-800': 
                 ($campaign->status === 'published' ? 'bg-purple-100 text-purple-800': 
                 ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800'   : 
                 ($campaign->status === 'expired'   ? 'bg-gray-200 text-gray-700'   : 'bg-red-100 text-red-800')))) }}">
              {{ ucfirst($campaign->status) }}
            </span>

            <!-- Campaign Details -->
            <div class="flex items-center mb-4">
              @if($campaign->instagramProfile->profile_photo)
                <img src="{{ asset('storage/' . $campaign->instagramProfile->profile_photo) }}" class="w-16 h-16 rounded-full object-cover shadow">
              @else
                <div class="w-16 h-16 rounded-full bg-pink-50 border border-pink-100 flex items-center justify-center text-[#E1306C]">
                  <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                  </svg>
                </div>
              @endif
              <div class="ml-4">
                <h3 class="text-base font-semibold text-gray-900">{{ '@' . $campaign->instagramProfile->instagram_id }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ number_format($campaign->instagramProfile->followers) }} Followers</p>
              </div>
            </div>

            <div class="text-sm text-gray-700 space-y-2">
              <p><span class="font-semibold">Media:</span> {{ ucfirst($campaign->media_type) }}</p>
              <p><span class="font-semibold">Price:</span> <span class="text-green-600 font-semibold">₹{{ number_format($campaign->price, 2) }}</span></p>
              
              @if($campaign->caption)
                <p class="line-clamp-2 text-xs text-gray-600"><span class="font-semibold text-gray-700">Caption:</span> {{ $campaign->caption }}</p>
              @endif

              <p><span class="font-semibold">Payment:</span> 
                @if($campaign->paid)
                  <span class="text-green-600 font-medium">Paid</span>
                @else
                  <span class="text-red-600 font-medium">Unpaid</span>
                @endif
              </p>

              @if($campaign->status === 'pending' && $campaign->paid)
                @php
                    $approvalDeadline  = $campaign->created_at->copy()->addHours(24);
                    $now               = now();
                    $approvalRemaining = max(0, $now->diffInSeconds($approvalDeadline, false));
                @endphp
                <div class="mt-3 pt-3 border-t border-orange-200">
                  <p class="font-semibold text-orange-600 mb-2 text-xs">⏳ Publisher must respond within:</p>
                  <div class="flex items-center justify-center gap-1 text-center approval-countdown" data-approval-seconds="{{ $approvalRemaining }}" data-campaign-id="{{ $campaign->id }}">
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-hours">{{ str_pad(floor($approvalRemaining / 3600), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">H</div>
                    </div>
                    <div class="text-lg font-bold text-orange-600">:</div>
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-minutes">{{ str_pad(floor(($approvalRemaining % 3600) / 60), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">M</div>
                    </div>
                    <div class="text-lg font-bold text-orange-600">:</div>
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-seconds">{{ str_pad($approvalRemaining % 60, 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">S</div>
                    </div>
                  </div>
                  <p class="text-xs text-orange-500 text-center mt-1">If not actioned, you will be auto-refunded.</p>
                </div>
              @elseif($campaign->status === 'approved')
                @php
                    $approvalDeadline  = $campaign->created_at->copy()->addHours(24);
                    $now               = now();
                    $approvalRemaining = max(0, $now->diffInSeconds($approvalDeadline, false));
                @endphp
                <div class="mt-3 pt-3 border-t border-orange-200">
                  <p class="font-semibold text-orange-600 mb-2 text-xs">⏳ Story link must be submitted within:</p>
                  <div class="flex items-center justify-center gap-1 text-center approval-countdown" data-approval-seconds="{{ $approvalRemaining }}" data-campaign-id="{{ $campaign->id }}">
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-hours">{{ str_pad(floor($approvalRemaining / 3600), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">H</div>
                    </div>
                    <div class="text-lg font-bold text-orange-600">:</div>
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-minutes">{{ str_pad(floor(($approvalRemaining % 3600) / 60), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">M</div>
                    </div>
                    <div class="text-lg font-bold text-orange-600">:</div>
                    <div class="bg-orange-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-orange-600 approval-seconds">{{ str_pad($approvalRemaining % 60, 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">S</div>
                    </div>
                  </div>
                  <p class="text-xs text-orange-500 text-center mt-1">Campaign expires if story link not submitted in time.</p>
                </div>
              @elseif($campaign->status === 'published' && $campaign->published_at)
                @php
                    $publishedAt = $campaign->published_at;
                    $completionTime = $publishedAt->copy()->addHours(24);
                    $now = now();
                    $remainingSeconds = $completionTime > $now ? $completionTime->diffInSeconds($now) : 0;
                @endphp
                <div class="mt-3 pt-3 border-t border-gray-200">
                  <p class="font-semibold text-rose-600 mb-2 text-xs">Time Remaining:</p>
                  <div class="flex items-center justify-center gap-1 text-center" data-countdown="{{ $remainingSeconds }}" data-campaign-id="{{ $campaign->id }}">
                    <div class="bg-pink-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-[#E1306C] countdown-hours">{{ str_pad(floor($remainingSeconds / 3600), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">H</div>
                    </div>
                    <div class="text-lg font-bold text-[#E1306C]">:</div>
                    <div class="bg-pink-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-[#E1306C] countdown-minutes">{{ str_pad(floor(($remainingSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">M</div>
                    </div>
                    <div class="text-lg font-bold text-[#E1306C]">:</div>
                    <div class="bg-pink-50 rounded px-2 py-1">
                      <div class="text-lg font-bold text-[#E1306C] countdown-seconds">{{ str_pad($remainingSeconds % 60, 2, '0', STR_PAD_LEFT) }}</div>
                      <div class="text-xs text-gray-500">S</div>
                    </div>
                  </div>
                </div>
              @elseif($campaign->status === 'expired')
                <div class="mt-3 pt-3 border-t border-gray-200">
                  <div class="bg-gray-50 border border-gray-300 rounded-lg p-3">
                    <p class="text-xs font-semibold text-gray-700">⏰ Campaign Expired</p>
                    <p class="text-xs text-gray-500 mt-1">Publisher did not respond in 24h.</p>
                    <p class="text-xs text-green-600 font-semibold mt-1">✓ ₹{{ number_format($campaign->price, 2) }} refunded to your wallet</p>
                  </div>
                </div>
              @else
                <div class="mt-3 pt-3 border-t border-gray-200">
                  <div class="h-16"></div>
                </div>
              @endif
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-between items-center gap-2 pt-3 border-t border-gray-100">
              <a href="{{ route('instagram.advertiser.campaigns.show', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" class="px-3.5 py-1.5 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-[#E1306C] to-[#FD1D1D] hover:from-[#C13584] hover:to-[#E1306C] transition-all duration-300 shadow-sm hover:shadow flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Details
              </a>
              
              @if($campaign->status === 'published' && $campaign->story_link)
                <a href="{{ $campaign->story_link }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-[#833AB4] to-[#C13584] hover:from-[#5851DB] hover:to-[#833AB4] transition-all duration-300 shadow-sm hover:shadow flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                  </svg>
                  View Story
                </a>
              @endif
              
              @if(!$campaign->paid)
                <a href="{{ route('instagram.advertiser.campaigns.payment', ['user' => auth()->id(), 'campaign' => $campaign->id]) }}" class="px-3.5 py-1.5 text-xs font-medium text-white rounded-lg bg-gradient-to-r from-[#10B981] to-[#059669] hover:from-[#059669] hover:to-[#047857] transition-all duration-300 shadow-sm hover:shadow flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                  </svg>
                  Pay
                </a>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-500 py-12">No campaigns found.</div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#E1306C]/15">
          <p class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900">{{ $campaigns->firstItem() ?? 0 }}</span> to
            <span class="font-medium text-gray-900">{{ $campaigns->lastItem() ?? 0 }}</span> of
            <span class="font-medium text-gray-900">{{ $campaigns->total() }}</span> results
          </p>

          <div class="flex items-center gap-2">
            @if ($campaigns->onFirstPage())
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Previous
              </span>
            @else
              <a href="{{ $campaigns->previousPageUrl() }}" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm border border-gray-200">
                Previous
              </a>
            @endif

            @if ($campaigns->hasMorePages())
              <a href="{{ $campaigns->nextPageUrl() }}" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#E1306C] to-[#FD1D1D] rounded-lg hover:from-[#C13584] hover:to-[#E1306C] transition-all duration-200 shadow-sm hover:shadow">
                Next
              </a>
            @else
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Next
              </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ── Published story countdown (blue) ──────────────────────────────────────
    document.querySelectorAll('[data-countdown]').forEach(function(element) {
        let remaining = parseInt(element.getAttribute('data-countdown'));
        const interval = setInterval(function() {
            if (remaining <= 0) { clearInterval(interval); window.location.reload(); return; }
            remaining--;
            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;
            const hoursEl   = element.querySelector('.countdown-hours');
            const minutesEl = element.querySelector('.countdown-minutes');
            const secondsEl = element.querySelector('.countdown-seconds');
            if (hoursEl)   hoursEl.textContent   = String(h).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
        }, 1000);
    });

    // ── Approval countdown (orange) — publisher has 24h to respond ───────────
    document.querySelectorAll('.approval-countdown').forEach(function(element) {
        let remaining = parseInt(element.getAttribute('data-approval-seconds'));
        const interval = setInterval(function() {
            if (remaining <= 0) {
                clearInterval(interval);
                setTimeout(() => window.location.reload(), 1500);
                return;
            }
            remaining--;
            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;
            const hoursEl   = element.querySelector('.approval-hours');
            const minutesEl = element.querySelector('.approval-minutes');
            const secondsEl = element.querySelector('.approval-seconds');
            if (hoursEl)   hoursEl.textContent   = String(h).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
        }, 1000);
    });

});
</script>
@endsection
