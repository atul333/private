@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
  <div class="container-custom py-4">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-400">
            <div class="px-4 py-1 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-sm font-semibold text-gray-800">{{ __('Publisher Dashboard') }}</h1>
                <div>
                    <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="inline-flex items-center px-1 py-1 bg-gradient-to-r from-indigo-600 to-indigo-700 border border-transparent rounded-lg shadow-sm text-[0.65rem] font-medium text-white hover:from-indigo-700 hover:to-indigo-800 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-0 h-4 w-5" fill="none" stroke="currentColor" viewBox="0 0 28 28"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add New Channel
                    </a>
                </div>
            </div>

            <div class="p-4">
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-700 rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-center">
                            <h3 class="text-sm font-medium opacity-90">Active Channels</h3>
                            <p class="text-sm font-bold mt-2">{{ $activeChannels }}</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-400 to-green-700 rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-center">
                            <h3 class="text-sm font-medium opacity-90">Total Earnings</h3>
                            <p class="text-sm font-bold mt-2">${{ number_format($channels->sum(function($channel) { return $channel->campaigns->where('status', 'completed')->sum('price'); }), 2) }}</p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-400 to-indigo-800 rounded-xl p-4 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        <div class="text-center">
                            <h3 class="text-sm font-medium opacity-90">Total Subscribers</h3>
                            <p class="text-sm font-bold mt-2">{{ $channels->sum('subscribers_count') }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    @forelse($channels as $channel)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border-2 border-gray-400 hover:border-indigo-400">
                            <div class="relative border-b border-gray-100">
                                <div class="absolute top-3 right-3">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border {{ $channel->status === 'active' ? 'bg-green-100 text-green-800 border-green-400' : 'bg-yellow-100 text-yellow-800 border-yellow-400' }}">
                                        {{ ucfirst($channel->status) }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center space-x-3 mb-3 border-b border-gray-200 pb-3">
                                        @if($channel->logo_path)
                                            <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }} Logo" class="h-12 w-12 rounded-full object-cover border border-blue-900 shadow-sm">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900">{{ $channel->name }}</h3>
                                            <div class="flex items-center mt-1">
                                                <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span class="text-xs text-gray-900">{{ number_format($channel->subscribers_count) }} Subscribers</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="border-t border-gray-50 pt-3">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs text-gray-900">Earnings</span>
                                            <span class="text-xs font-semibold text-gray-900 rounded-md ">${{ number_format($channel->campaigns->where('status', 'completed')->sum('price') ?? 0, 2) }}</span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between space-x-2">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('channels.show', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 bg-red-50 text-red-700 hover:bg-red-100  shadow-sm text-xs font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View
                                                </a>
                                                <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 shadow-sm text-xs font-medium rounded-md bg-yellow-50 text-yellow-700 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Edit
                                                </a>
                                            </div>
                                            <a href="{{ route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel]) }}" 
                                               class="inline-flex items-center text-xs px-1 py-0.5 rounded-md {{ $channel->campaigns->count() > 0 ? 'bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-400'  : 'bg-gray-50 text-gray-400 border border-gray-400 cursor-not-allowed'}}">
                                                Ad Details
                                                @if($channel->campaigns->count() > 0)
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-100">{{ $channel->campaigns->count() }}</span>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3">
                            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No channels found</h3>
                                <p class="mt-1 text-xs text-gray-500">Get started by creating a new channel.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="mt-6">
                    {{ $channels->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection