@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#7209B7]/20 flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back</span>
                </a>
                <h1 class="ml-4 text-xl font-bold text-white">Create New Channel</h1>
            </div>
        </div>
                        

           

         <!-- Scrollable Content Section -->
         <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
             <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                 <form method="POST" action="{{ route('channels.store', ['user' => Auth::id()]) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-900">Channel Name</label>
                                <div class="relative">
                                    <input type="text" class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('name') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="absolute inset-0 rounded-lg pointer-events-none border border-[#4895EF]/30 transition-colors duration-200"></div>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="link" class="block text-sm font-semibold text-gray-900">Channel Link</label>
                                <input type="url" class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('link') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="link" name="link" value="{{ old('link') }}" required placeholder="https://t.me/yourchannel">
                                @error('link')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="description" class="block text-sm font-semibold text-gray-900">Channel Description</label>
                                <textarea class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('description') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="logo" class="block text-sm font-semibold text-gray-900">Channel Logo</label>
                                <input type="file" class="mt-1 block w-full px-4 py-3 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#4CC9F0]/10 file:text-[#4361EE] hover:file:bg-[#4CC9F0]/20 transition duration-200 @error('logo') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="logo" name="logo" accept="image/*" required>
                                @error('logo')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="subscribers_count" class="block text-sm font-semibold text-gray-900">Subscribers Count</label>
                                <input type="number" class="mt-1 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('subscribers_count') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="subscribers_count" name="subscribers_count" value="{{ old('subscribers_count') }}" required min="0">
                                @error('subscribers_count')
                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-8">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-10"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg shadow-lg border border-[#4895EF]/20">
                                    <h3 class="text-xl font-bold text-gray-900 mb-6">Pricing Options</h3>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="relative group">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                            <div class="relative space-y-2">
                                                <label for="price_1_day" class="block text-sm font-semibold text-gray-900">Price for 1 Day ($)</label>
                                                <div class="relative rounded-lg shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('price_1_day') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="price_1_day" name="price_1_day" value="{{ old('price_1_day') }}" required min="0">
                                                </div>
                                                @error('price_1_day')
                                                    <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_2_days" class="block text-sm font-semibold text-gray-900">Price for 2 Days ($)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('price_2_days') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="price_2_days" name="price_2_days" value="{{ old('price_2_days') }}" required min="0">
                                        </div>
                                        @error('price_2_days')
                                            <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_3_days" class="block text-sm font-semibold text-gray-900">Price for 3 Days ($)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('price_3_days') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="price_3_days" name="price_3_days" value="{{ old('price_3_days') }}" required min="0">
                                        </div>
                                        @error('price_3_days')
                                            <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_7_days" class="block text-sm font-semibold text-gray-900">Price for 7 Days ($)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border-[#4895EF]/30 bg-white/80 backdrop-blur-sm shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 @error('price_7_days') border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] @enderror" id="price_7_days" name="price_7_days" value="{{ old('price_7_days') }}" required min="0">
                                        </div>
                                        @error('price_7_days')
                                            <p class="mt-2 text-xs text-[#F72585]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#F72585] to-[#7209B7] rounded-lg blur opacity-25"></div>
                        <button type="submit" class="relative w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                            Create Channel
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection