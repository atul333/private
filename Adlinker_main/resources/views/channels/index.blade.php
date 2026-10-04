@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col">
        <!-- Header Section -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center min-w-0 mr-2">
                <a href="{{ url('/' . Auth::id() . '/publisher/dashboard') }}" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200 mr-2 sm:mr-3 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-base sm:text-lg font-bold text-gray-900 truncate">My Channels</h1>
            </div>
            <div class="flex items-center shrink-0">
                <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-[#0088cc] to-[#4361EE] rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white hover:opacity-95 transition-all duration-200 whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Channel
                </a>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex-1 px-3 sm:px-4 py-4 pb-28 sm:pb-12">
            <div class="max-w-7xl mx-auto">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-xs sm:text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($channels->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($channels as $channel)
                            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#0088cc]/20 overflow-hidden flex flex-col justify-between">
                                <div class="p-4 sm:p-5">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            @if($channel->logo_path)
                                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-xs shrink-0">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0088cc] font-bold text-lg shadow-xs shrink-0">
                                                    {{ substr($channel->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <h3 class="font-bold text-gray-900 text-base truncate">{{ $channel->name }}</h3>
                                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    <span>{{ number_format($channel->subscribers_count) }} Subscribers</span>
                                                </div>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold shrink-0 {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : ($channel->status === 'moderation' ? 'bg-amber-100 text-amber-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($channel->status) }}
                                        </span>
                                    </div>

                                    @if($channel->description)
                                        <p class="text-xs text-gray-600 line-clamp-2 mb-3">{{ $channel->description }}</p>
                                    @endif
                                </div>

                                <div class="px-4 py-3 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('channels.show', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-xs">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View
                                        </a>
                                        <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-xs">
                                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                    </div>
                                    <form action="{{ route('channels.destroy', ['user' => Auth::id(), 'channel' => $channel]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this channel?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-50 border border-red-200 rounded-lg text-xs font-medium text-red-600 hover:bg-red-100 transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200 p-8 text-center mt-4">
                        <svg class="mx-auto w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-800">No channels yet</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1 mb-4">Add your first channel to start monetizing your Telegram audience!</p>
                        <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-[#0088cc] to-[#4361EE] rounded-lg text-xs sm:text-sm font-medium text-white shadow-sm hover:opacity-95 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Your First Channel
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection