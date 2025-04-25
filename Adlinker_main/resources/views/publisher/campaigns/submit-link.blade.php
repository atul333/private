@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
      <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-lg font-bold text-black">{{ __('Submit Post Link') }}</h1>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="px-4 py-6">
      <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
          <div class="p-6">
            <form method="POST" action="{{ route('publisher.campaign.submit-link', ['campaign' => $campaign->id]) }}" class="space-y-6">
              @csrf

              <!-- Campaign Info Summary -->
              <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                  <h2 class="text-sm font-medium text-blue-800">Campaign #{{ $campaign->id }}</h2>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    {{ ucfirst($campaign->status) }}
                  </span>
                </div>
                @if($campaign->advertisement_content)
                <p class="text-xs text-blue-700 mb-2 line-clamp-2">{{ $campaign->advertisement_content }}</p>
                @endif
                <div class="flex justify-between items-center text-xs text-blue-600">
                  <div class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $campaign->duration }} days</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>${{ number_format($campaign->price, 2) }}</span>
                  </div>
                </div>
              </div>

              <div class="space-y-1">
                <label for="post_link" class="block text-sm font-medium text-gray-700">{{ __('Post Link') }}</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                  <input id="post_link" 
                         type="url" 
                         class="block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error('post_link') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" 
                         name="post_link" 
                         value="{{ old('post_link') }}" 
                         placeholder="https://t.me/yourchannel/123"
                         required 
                         autocomplete="post_link" 
                         autofocus>
                  @error('post_link')
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  @enderror
                </div>
                @error('post_link')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">
                  Please enter the link to your post where you've shared the advertisement.
                </p>
              </div>

              <div class="space-y-1">
                <label for="notes" class="block text-sm font-medium text-gray-700">
                  {{ __('Additional Notes') }} <span class="text-gray-500">(Optional)</span>
                </label>
                <div class="mt-1">
                  <textarea id="notes" 
                            name="notes" 
                            rows="4" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Any additional information about your post...">{{ old('notes') }}</textarea>
                </div>
                @error('notes')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <div class="mt-8">
                <button type="submit" class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] border border-transparent text-white text-center text-sm font-medium transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                  {{ __('Submit Link') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection