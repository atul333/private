@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Create New Campaign</h1>
                <a href="/{{ Auth::id() }}/advertiser/dashboard" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-150">Go Back</a>
            </div>
            <div class="p-6">
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
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-4">
                        <div class="flex justify-between items-start space-x-4 mb-3">
                            <div class="flex items-center space-x-3">
                                @if($channel->logo_path)
                                    <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="w-12 h-12 rounded-full object-cover">
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $channel->name }}</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">{{ Str::limit($channel->description, 100) }}</p>
                        </div>
                        
                        <div class="flex items-center space-x-2 mt-3 mb-4">
                            <i class="bi bi-people-fill text-gray-600"></i>
                            <span class="text-sm text-gray-600">{{ number_format($channel->subscribers_count) }} Subscribers</span>
                        </div>
                        
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="bi bi-link-45deg text-gray-600"></i>
                            <a href="{{ $channel->channel_link }}" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">View Channel</a>
                        </div>
                        
                        <div class="mb-3">
                            <select name="durations[{{ $channel->id }}]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm channel-duration" data-channel-id="{{ $channel->id }}" data-price-1="{{ $channel->price_1_day }}" data-price-2="{{ $channel->price_2_days }}" data-price-3="{{ $channel->price_3_days }}" data-price-7="{{ $channel->price_7_days }}">
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

    <div class="d-flex justify-content-start mt-4">
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
});
</script>
@endpush