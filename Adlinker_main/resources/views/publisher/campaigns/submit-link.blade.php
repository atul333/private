@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-2xl font-semibold text-gray-800">{{ __('Submit Post Link') }}</h1>
                    </div>

                
                
            </div>

            <div class="p-6">
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
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            {{ __('Submit Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection