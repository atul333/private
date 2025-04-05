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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Active Channels</h3>
                                <p class="text-3xl font-bold mt-2">{{ $activeChannels }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Total Earnings</h3>
                                <p class="text-3xl font-bold mt-2">${{ number_format($totalEarnings, 2) }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                            <div class="flex flex-col">
                                <h3 class="text-lg font-medium opacity-90">Total Subscribers</h3>
                                <p class="text-3xl font-bold mt-2">{{ $channels->sum('subscribers_count') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel Logo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribers</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($channels as $channel)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($channel->logo_path)
                                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }} Logo" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <span class="text-gray-400">No Logo</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $channel->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($channel->subscribers_count) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($channel->earnings ?? 0, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($channel->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('channels.show', ['user' => Auth::id(), 'channel' => $channel]) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel]) }}" 
                                               class="inline-flex items-center px-3 py-1 rounded-full {{ $channel->campaigns->count() > 0 ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                                                View Status
                                                @if($channel->campaigns->count() > 0)
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-blue-200">{{ $channel->campaigns->count() }}</span>
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No channels found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection