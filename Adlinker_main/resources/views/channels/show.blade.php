@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-2xl font-semibold text-gray-800">Channel Details</h1>
                    </div>
                    <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Channel
                    </a>
                </div>
            </div>

                <div class="p-6 space-y-6">
                    @if($channel->logo_path)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="Channel Logo" class="h-24 w-24 rounded-full object-cover ring-4 ring-indigo-50">
                    </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Channel Name</h6>
                        <p class="text-lg font-semibold text-gray-900">{{ $channel->name }}</p>
                    </div>

                    @if($channel->link)
                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Channel Link</h6>
                        <a href="{{ $channel->link }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium break-all">{{ $channel->link }}</a>
                    </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Description</h6>
                        <p class="text-gray-700">{{ $channel->description }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg p-4 text-white">
                        <h6 class="text-sm font-medium text-indigo-100">Subscribers Count</h6>
                        <p class="text-2xl font-bold mt-1">{{ number_format($channel->subscribers_count) }}</p>
                    </div>

                    <div class="space-y-3">
                        <h6 class="text-lg font-medium text-gray-900">Pricing Options</h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if($channel->price_1_day)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1 Day</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($channel->price_1_day, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_2_days)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($channel->price_2_days, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_3_days)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">3 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($channel->price_3_days, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_7_days)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">7 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($channel->price_7_days, 2) }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Status</h6>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($channel->status) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Created At</h6>
                        <p class="text-gray-700">{{ $channel->created_at->format('F j, Y') }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1">
                        <h6 class="text-sm font-medium text-gray-500">Last Updated</h6>
                        <p class="text-gray-700">{{ $channel->updated_at->format('F j, Y') }}</p>
                    </div>

                    <form action="{{ route('channels.destroy', ['user' => Auth::id(), 'channel' => $channel]) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this channel?')">
                            Delete Channel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection