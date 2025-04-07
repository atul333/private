@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-800">{{ __('Publisher Dashboard') }}</h1>
                <div>
                    <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="btn btn-primary inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add New Channel
                    </a>
                </div>
            </div>

                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-500 rounded-lg p-6 text-white">
                            <div class="text-center">
                                <h3 class="text-sm font-medium">Active Channels</h3>
                                <p class="text-xl font-bold mt-2">{{ $activeChannels }}</p>
                            </div>
                        </div>
                        <div class="bg-green-500 rounded-lg p-6 text-white">
                            <div class="text-center">
                                <h3 class="text-sm font-medium">Total Earnings</h3>
                                <p class="text-xl font-bold mt-2">${{ number_format($totalEarnings, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-indigo-500 rounded-lg p-6 text-white">
                            <div class="text-center">
                                <h3 class="text-sm font-medium">Total Subscribers</h3>
                                <p class="text-xl font-bold mt-2">{{ $channels->sum('subscribers_count') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        @forelse($channels as $channel)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <div class="absolute top-4 right-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($channel->status) }}
                                        </span>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4 mb-4">
                                            @if($channel->logo_path)
                                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }} Logo" class="h-16 w-16 rounded-full object-cover shadow-sm">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $channel->name }}</h3>
                                                <div class="flex items-center mt-1">
                                                    <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    <span class="text-sm text-gray-500">{{ number_format($channel->subscribers_count) }} Subscribers</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="border-t border-gray-100 pt-4">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="text-sm text-gray-500">Earnings</span>
                                                <span class="text-lg font-semibold text-green-600">${{ number_format($channel->earnings ?? 0, 2) }}</span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between space-x-3">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('channels.show', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        View
                                                    </a>
                                                    <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Edit
                                                    </a>
                                                </div>
                                                <a href="{{ route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel]) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 rounded-md {{ $channel->campaigns->count() > 0 ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                                                    Ad Details
                                                    @if($channel->campaigns->count() > 0)
                                                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-200">{{ $channel->campaigns->count() }}</span>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <div class="text-center py-12 bg-gray-50 rounded-lg">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No channels found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new channel.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection