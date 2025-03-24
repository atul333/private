@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Channel Details</h5>
                    <a href="{{ route('campaigns.create', auth()->id()) }}" class="btn btn-sm btn-outline-primary">Back to Channel Selection</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            @if($channel->logo_path)
                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }}" class="img-fluid rounded">
                            @else
                                <div class="bg-light rounded p-3 text-center">No Logo</div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4>{{ $channel->name }}</h4>
                            <p class="text-muted">{{ $channel->description }}</p>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-users me-2"></i>
                                <span>{{ number_format($channel->subscribers_count) }} Subscribers</span>
                            </div>
                            @if($channel->link)
                                <a href="{{ $channel->link }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt me-1"></i> Visit Channel
                                </a>
                            @endif

                            @if(request('duration') && request('price'))
                                <div class="pricing-section mt-4">
                                    <h5 class="mb-3">Selected Advertising Plan</h5>
                                    <div class="card bg-primary-subtle border border-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-clock me-2"></i>
                                                    <span class="fw-bold">Duration:</span> {{ request('duration') }} Days
                                                </div>
                                                <div>
                                                    <i class="fas fa-tag me-2"></i>
                                                    <span class="fw-bold">Price:</span> ${{ request('price') }}
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('campaigns.store', ['user' => auth()->id()]) }}" class="mt-3">
                                                @csrf
                                                <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                                                <input type="hidden" name="duration" value="{{ request('duration') }}">
                                                <input type="hidden" name="price" value="{{ request('price') }}">
                                                <button type="submit" class="btn btn-primary w-100">Proceed with Campaign</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-3">
                                    Please select a duration and price on the previous page before proceeding.
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




