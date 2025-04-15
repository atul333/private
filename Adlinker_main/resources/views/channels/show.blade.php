@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                {{-- Header --}}
                <div class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 flex justify-between items-center sticky top-0 z-10">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Back</span>
                        </a>
                        <h1 class="ml-4 text-xl font-bold text-white">Channel Details</h1>
                    </div>
                    <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Channel
                    </a>
                </div>

                {{-- Scrollable Content --}}
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    @if($channel->logo_path)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="Channel Logo" class="h-24 w-24 rounded-full border-2 border-[#4895EF] object-cover ring-4 ring-[#4361EE]/20 transform hover:scale-105 transition-all duration-300">
                    </div>
                    @endif

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Channel Name</h6>
                        <p class="text-sm text-gray-700">{{ $channel->name }}</p>
                    </div>

                    @if($channel->link)
                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Channel Link</h6>
                        <a href="{{ $channel->link }}" target="_blank" class="text-sm text-[#4361EE] hover:text-[#3A0CA3] font-medium break-all transition-colors duration-200">{{ $channel->link }}</a>
                    </div>
                    @endif

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Description</h6>
                        <p class="text-sm text-gray-700">{{ $channel->description }}</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Subscribers Count</h6>
                        <p class="text-sm text-gray-700">{{ number_format($channel->subscribers_count) }}</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-4 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-lg font-semibold text-[#3A0CA3]">Pricing Options</h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#4895EF]/20 rounded-xl overflow-hidden bg-white/50 backdrop-blur-sm">
                                <thead class="bg-gradient-to-r from-[#4361EE] to-[#3A0CA3]">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/80 divide-y divide-[#4895EF]/20">
                                    @if($channel->price_1_day)
                                    <tr class="hover:bg-[#4CC9F0]/5 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm  text-gray-700">1 Day</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($channel->price_1_day, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_2_days)
                                    <tr class="hover:bg-[#4CC9F0]/5 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">2 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($channel->price_2_days, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_3_days)
                                    <tr class="hover:bg-[#4CC9F0]/5 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">3 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($channel->price_3_days, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($channel->price_7_days)
                                    <tr class="hover:bg-[#4CC9F0]/5 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">7 Days</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($channel->price_7_days, 2) }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Status</h6>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $channel->status === 'active' ? 'bg-[#4CC9F0]/20 text-[#3A0CA3] border border-[#4CC9F0]' : 'bg-[#F72585]/20 text-[#B5179E] border border-[#F72585]' }}">
                            {{ ucfirst($channel->status) }}
                        </span>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Created At</h6>
                        <p class="text-sm text-gray-700">{{ $channel->created_at->format('F j, Y') }}</p>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                        <h6 class="text-base font-semibold text-[#3A0CA3]">Last Updated</h6>
                        <p class="text-sm text-gray-700">{{ $channel->updated_at->format('F j, Y') }}</p>
                    </div>

                    <form action="{{ route('channels.destroy', ['user' => Auth::id(), 'channel' => $channel]) }}" method="POST" class="mt-6">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-red-700 hover:to-red-800 transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this channel?')">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Channel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
