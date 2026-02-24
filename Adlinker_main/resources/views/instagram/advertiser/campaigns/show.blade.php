@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('instagram.advertiser.dashboard', ['user' => auth()->id()]) }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200 mr-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-lg font-bold text-gray-800">Instagram Campaign #{{ $campaign->id }}</h1>
                    <p class="text-xs text-gray-600">Created on {{ $campaign->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
            <span class="px-3 py-1.5 text-sm font-semibold rounded-full 
                @if($campaign->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                @elseif($campaign->status === 'approved') bg-green-100 text-green-800 border border-green-200
                @elseif($campaign->status === 'rejected') bg-red-100 text-red-800 border border-red-200
                @else bg-blue-100 text-blue-800 border border-blue-200
                @endif">
                {{ ucfirst($campaign->status) }}
            </span>
        </div>

        <!-- Content Section -->
        <div class="px-4 py-4">
            <div class="max-w-4xl mx-auto">
                <!-- Main Content -->
                <div class="space-y-6">
                    <!-- Campaign Content Card -->
                    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/30 overflow-hidden">
                        <div class="bg-white border-b border-gray-300 px-6 py-4">
                            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Campaign Content
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Media Preview -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Media Preview</label>
                                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                                    @if($campaign->media_type === 'image')
                                        <img src="{{ asset('storage/' . $campaign->media_file) }}" class="max-h-96 rounded shadow-lg object-cover">
                                    @else
                                        <video controls class="max-h-96 rounded shadow-lg">
                                            <source src="{{ asset('storage/' . $campaign->media_file) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            </div>

                            <!-- Link Details -->
                            @if($campaign->link_text || $campaign->link_url)
                                <div class="space-y-3">
                                    @if($campaign->link_text)
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Advertisement Link Text</label>
                                            <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                                                {{ $campaign->link_text }}
                                            </div>
                                        </div>
                                    @endif

                                    @if($campaign->link_url)
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Advertisement Link</label>
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <a href="{{ $campaign->link_url }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline break-all">
                                                    {{ $campaign->link_url }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Link Details</label>
                                    <div class="bg-gray-50 rounded-lg p-4 text-gray-500 italic">
                                        No link details provided.
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
