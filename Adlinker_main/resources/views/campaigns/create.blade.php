@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#fb8500] to-[#ffb703] border-b border-[#7209B7]/20 flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="/{{ Auth::user()->id }}/advertiser/dashboard" class="btn-back mr-4 text-sm flex items-center text-white/90 hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
                <h1 class="text-lg font-bold text-white">Create New Campaign</h1>
            </div>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
            <div class="max-w-3xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <div class="p-6">
                    <div class="mb-6 flex justify-end">
                        <select id="sortSubscribers" class="rounded-md border-[#4895EF]/30 shadow-sm focus:border-[#4361EE] focus:ring focus:ring-[#4361EE]/20 focus:ring-opacity-50 bg-white/90">
                            <option value="default">Sort by Subscribers</option>
                            <option value="asc">Lowest to Highest</option>
                            <option value="desc">Highest to Lowest</option>
                        </select>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('campaigns.store', ['user' => Auth::id()]) }}" enctype="multipart/form-data">
                        @csrf

                        <h6 class="mb-3 fs-5">Select Channels</h6>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($channels as $channel)
                                <div class="w-full">
                                    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
                                        <div class="relative p-6 text-gray-800">
                                            <div class="flex justify-between items-start space-x-4 mb-3">
                                                <div class="flex items-center space-x-3">
                                                    @if($channel->logo_path)
                                                        <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-12 h-12 rounded-full object-cover">
                                                    @endif
                                                    <div>
                                                        <h3 class="font-semibold text-gray-800">{{ $channel->name }}</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">{{ Str::limit($channel->description, 100) }}</p>
                                            </div>

                                            <div class="flex items-center space-x-2 mt-3 mb-4">
                                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span class="text-sm text-gray-600">{{ number_format($channel->subscribers_count) }} Subscribers</span>
                                            </div>
                                        </div>
                                        <div class="p-6 bg-white">
                                            @if($channel->link)
                                                <a href="{{ $channel->link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-4">
                                                    View Channel
                                                </a>
                                            @endif

                                            <div class="mb-3">
                                                <select name="durations[{{ $channel->id }}]" class="w-auto min-w-fit rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm channel-duration" data-channel-id="{{ $channel->id }}" data-price-1="{{ $channel->price_1_day }}" data-price-2="{{ $channel->price_2_days }}" data-price-3="{{ $channel->price_3_days }}" data-price-7="{{ $channel->price_7_days }}">
                                                    <option value="">Select Duration</option>
                                                    <option value="1">1 Day (${{ number_format($channel->price_1_day, 2) }})</option>
                                                    <option value="2">2 Days (${{ number_format($channel->price_2_days, 2) }})</option>
                                                    <option value="3">3 Days (${{ number_format($channel->price_3_days, 2) }})</option>
                                                    <option value="7">7 Days (${{ number_format($channel->price_7_days, 2) }})</option>
                                                </select>
                                            </div>

                                            <a href="{{ route('campaigns.channel.details', ['user' => Auth::id(), 'channel' => $channel->id]) }}" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 select-channel-btn" data-channel-id="{{ $channel->id }}">Select Channel</a>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const durationSelects = document.querySelectorAll('.channel-duration');
                                                    const channelButtons = document.querySelectorAll('.select-channel-btn');

                                                    durationSelects.forEach(select => {
                                                        select.addEventListener('change', function() {
                                                            const channelId = this.getAttribute('data-channel-id');
                                                            const duration = this.value;
                                                            const price = this.getAttribute(`data-price-${duration}`);

                                                            if (duration && price) {
                                                                localStorage.setItem(`channel_${channelId}_duration`, duration);
                                                                localStorage.setItem(`channel_${channelId}_price`, price);
                                                            }
                                                        });
                                                    });

                                                    channelButtons.forEach(button => {
                                                        button.addEventListener('click', function(e) {
                                                            e.preventDefault();
                                                            const channelId = this.getAttribute('data-channel-id');
                                                            const duration = localStorage.getItem(`channel_${channelId}_duration`);
                                                            const price = localStorage.getItem(`channel_${channelId}_price`);

                                                            if (duration && price) {
                                                                const baseUrl = this.getAttribute('href');
                                                                const url = `${baseUrl}?duration=${duration}&price=${price}`;
                                                                window.location.href = url;
                                                            } else {
                                                                alert('Please select a duration first');
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-8">
                            {{ $channels->links() }}
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const durationSelects = document.querySelectorAll('.channel-duration');
    const sortSelect = document.getElementById('sortSubscribers');
    const channelGrid = document.querySelector('.grid');

    sortSelect.addEventListener('change', function() {
        const channels = Array.from(channelGrid.children);
        const sortOrder = this.value;

        if (sortOrder !== 'default') {
            channels.sort((a, b) => {
                const subscribersTextA = a.querySelector('.text-sm.text-gray-600').textContent;
                const subscribersTextB = b.querySelector('.text-sm.text-gray-600').textContent;

                const subscribersA = parseInt(subscribersTextA.replace(/[^0-9]/g, ''));
                const subscribersB = parseInt(subscribersTextB.replace(/[^0-9]/g, ''));

                return sortOrder === 'asc' ? subscribersA - subscribersB : subscribersB - subscribersA;
            });

            channelGrid.innerHTML = '';
            channels.forEach(channel => channelGrid.appendChild(channel));
        }
    });
});
</script>
@endpush
