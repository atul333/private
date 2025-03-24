@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Campaign</h5>
                </div>
                <div class="card-body">
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

    <h5 class="mb-4">Select Channels</h5>
    <div class="row g-4">
        @foreach($channels as $channel)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if($channel->logo_path)
                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                            <div>
                                <label class="text-muted small mb-1">Channel Name:</label>
                                <h6 class="card-title mb-0">{{ $channel->name }}</h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Description:</label>
                            <p class="card-text small mb-0">{{ Str::limit($channel->description, 100) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Subscribers:</label>
                            <p class="card-text small mb-0">
                                <i class="bi bi-people-fill"></i> {{ number_format($channel->subscribers_count) }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted small mb-1">Duration:</label>
                            <select name="durations[{{ $channel->id }}]" class="form-select channel-duration" data-channel-id="{{ $channel->id }}" data-price-1="{{ $channel->price_1_day }}" data-price-2="{{ $channel->price_2_days }}" data-price-3="{{ $channel->price_3_days }}" data-price-7="{{ $channel->price_7_days }}">
                                <option value="">Select Duration</option>
                                <option value="1">1 Day (${{ number_format($channel->price_1_day, 2) }})</option>
                                <option value="2">2 Days (${{ number_format($channel->price_2_days, 2) }})</option>
                                <option value="3">3 Days (${{ number_format($channel->price_3_days, 2) }})</option>
                                <option value="7">7 Days (${{ number_format($channel->price_7_days, 2) }})</option>
                            </select>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('campaigns.channel.details', ['user' => Auth::id(), 'channel' => $channel->id]) }}" class="btn btn-primary w-100 select-channel-btn" data-channel-id="{{ $channel->id }}">Select Channel</a>

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
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-start mt-4">
        <a href="/{{ Auth::id() }}/advertiser/dashboard" class="btn btn-secondary">Go Back</a>
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