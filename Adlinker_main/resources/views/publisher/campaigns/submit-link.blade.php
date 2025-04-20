@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#CDB4DB] to-[#BDE0FE] py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#CDB4DB]/20 transform transition-all duration-300 hover:shadow-2xl">
                <!-- Header Section -->
                <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#CDB4DB]/20 flex justify-between items-center shrink-0">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            
                        </a>
                        <h1 class="text-lg font-bold text-white">{{ __('Submit Post Link') }}</h1>
                    </div>
                </div>

                <!-- Scrollable Content Area -->
                <div class="p-6 max-h-[75vh] overflow-y-auto">
                <form method="POST" action="{{ route('publisher.campaign.submit-link', ['campaign' => $campaign->id]) }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="post_link" class="block text-sm font-medium text-gray-700">{{ __('Post Link') }}</label>
                        <input id="post_link" 
                               type="url" 
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('post_link') border-red-500 @enderror" 
                               name="post_link" 
                               value="{{ old('post_link') }}" 
                               required 
                               autocomplete="post_link" 
                               autofocus>

                        @error('post_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('Additional Notes') }} <span class="text-gray-500">(Optional)</span></label>
                        <textarea id="notes" 
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-500 @enderror" 
                                  name="notes" 
                                  rows="4">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            {{ __('Submit Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection