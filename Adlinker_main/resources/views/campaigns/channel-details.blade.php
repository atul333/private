@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col pb-28 sm:pb-12">
    <div class="flex flex-col flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/campaigns/create" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900">Channel Details</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-3 sm:px-6 py-4 flex-1">
            <div class="max-w-2xl mx-auto">
                <!-- Channel Info & Plan Summary Card (Compact for Mobile) -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl p-3.5 sm:p-5 shadow-sm border border-gray-200/80 mb-4">
                    <!-- Channel Header (Avatar + Name + Description) -->
                    <div class="flex items-center gap-3 sm:gap-4 mb-3">
                        @if($channel->logo_path)
                            <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover shadow-sm border border-gray-200 shrink-0">
                        @else
                            <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0088cc] shrink-0">
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $channel->name }}</h3>
                            @if($channel->description)
                                <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $channel->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Channel Metrics: Subscribers & Link (Compact) -->
                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <div class="bg-blue-50/70 border border-blue-200/60 rounded-lg py-2 px-3 text-center">
                            <span class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Subscribers</span>
                            <p class="text-sm sm:text-base font-bold text-[#0088cc]">{{ number_format($channel->subscribers_count) }}</p>
                        </div>
                        @if($channel->link)
                            <a href="{{ $channel->link }}" target="_blank" class="bg-sky-50/70 border border-sky-200/60 rounded-lg py-2 px-3 text-center hover:bg-sky-100/70 transition-colors flex flex-col justify-center">
                                <span class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Channel Link</span>
                                <p class="text-xs sm:text-sm font-semibold text-[#0088cc] flex items-center justify-center gap-1">
                                    <span>Visit Channel</span>
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </p>
                            </a>
                        @endif
                    </div>

                    <!-- Selected Advertising Plan (Compact side-by-side boxes) -->
                    @if(request('duration') && request('price'))
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2">Selected Advertising Plan</div>
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <!-- Duration Box -->
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200/70 rounded-lg py-2 px-3 text-center shadow-xs">
                                    <div class="flex items-center justify-center gap-1.5 text-purple-700">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-[11px] font-medium text-gray-600">Duration</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-bold text-purple-900 mt-0.5">{{ request('duration') }} Days</p>
                                </div>

                                <!-- Price Box -->
                                <div class="bg-gradient-to-br from-pink-50 to-rose-50 border border-rose-200/70 rounded-lg py-2 px-3 text-center shadow-xs">
                                    <div class="flex items-center justify-center gap-1.5 text-rose-600">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        <span class="text-[11px] font-medium text-gray-600">Price</span>
                                    </div>
                                    <p class="text-sm sm:text-base font-bold text-rose-700 mt-0.5">₹{{ request('price') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if(request('duration') && request('price'))
                    <!-- Form Section -->
                    <form method="POST" action="{{ route('campaigns.store', ['user' => auth()->id()]) }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                        <input type="hidden" name="duration" value="{{ request('duration') }}">
                        <input type="hidden" name="price" value="{{ request('price') }}">

                        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/80 overflow-hidden">
                            <div class="p-4 sm:p-5">
                                <h4 class="text-sm sm:text-base font-bold text-gray-900 mb-3 pb-2 border-b border-gray-100 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#0088cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Advertisement Details
                                </h4>

                                <div class="space-y-4">
                                    <div>
                                        <label for="advertisement_image" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">
                                            Advertisement Image <span class="text-red-500">*</span>
                                        </label>
                                        <input type="file" class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0088cc] hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer bg-white" id="advertisement_image" name="advertisement_image" accept="image/*" required>
                                        <p class="mt-1 text-[11px] text-gray-500">Max size: 2MB (JPG, PNG, GIF)</p>
                                        @error('advertisement_image')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="advertisement_content" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">
                                            Advertisement Content <span class="text-red-500">*</span>
                                        </label>
                                        <textarea rows="3" class="shadow-xs block w-full text-xs sm:text-sm border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-[#0088cc]/40 focus:border-[#0088cc] focus:outline-none" id="advertisement_content" name="advertisement_content" required placeholder="Enter compelling advertisement text here...">{{ old('advertisement_content') }}</textarea>
                                        <p class="mt-1 text-[11px] text-gray-500">Write the text to be broadcasted with your image</p>
                                        @error('advertisement_content')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $wallet = \App\Models\Wallet::where('user_id', auth()->id())->first();
                            $campaignPrice = floatval(request('price'));
                            $walletBalance = $wallet ? floatval($wallet->balance) : 0;
                        @endphp

                        @if($wallet && $walletBalance >= $campaignPrice)
                            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl shadow-md text-sm font-semibold text-white bg-gradient-to-r from-[#0088cc] to-[#0099ff] hover:from-[#0077b5] hover:to-[#0088cc] transition-all duration-300 focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Create Campaign (Pay ₹{{ number_format($campaignPrice, 2) }})
                            </button>
                        @else
                            <div class="space-y-3">
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3 flex items-start gap-2.5">
                                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-red-800">Insufficient Wallet Balance</p>
                                        <p class="text-xs text-red-600 mt-0.5">Required: ₹{{ number_format($campaignPrice, 2) }} | Current: ₹{{ number_format($walletBalance, 2) }}</p>
                                    </div>
                                </div>
                                <a href="/{{ auth()->id() }}/advertiser/wallet/add-funds" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl shadow-md text-sm font-semibold text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Funds to Wallet
                                </a>
                            </div>
                        @endif
                    </form>
                @else
                    <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-center">
                        <p class="text-xs sm:text-sm font-medium text-yellow-800">Please select a duration and price before proceeding.</p>
                        <a href="/{{ Auth::user()->id }}/campaigns/create" class="inline-block mt-2 text-xs font-semibold text-blue-600 underline">← Return to Channels</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('advertisement_image');
    const form = document.querySelector('form');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const existingPreview = document.querySelector('.image-preview');
                if (existingPreview) existingPreview.remove();

                const preview = document.createElement('div');
                preview.className = 'image-preview mt-2';
                preview.innerHTML = `
                    <div class="relative inline-block">
                        <img src="${e.target.result}" alt="Preview" class="max-h-40 rounded-lg shadow-sm border border-gray-200">
                        <button type="button" class="mt-1.5 text-xs text-red-600 hover:text-red-700 font-medium flex items-center gap-1" onclick="removeImage()">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Remove Image
                        </button>
                    </div>
                `;
                imageInput.parentNode.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage() {
        const preview = document.querySelector('.image-preview');
        if (preview) preview.remove();
        if (imageInput) imageInput.value = '';
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            const content = document.getElementById('advertisement_content');
            const image = document.getElementById('advertisement_image');

            if (!content.value.trim()) {
                e.preventDefault();
                alert('Please enter advertisement content');
                content.focus();
                return;
            }

            if (!image.files.length) {
                e.preventDefault();
                alert('Please select an image for the advertisement');
                return;
            }
        });
    }
</script>
@endpush
