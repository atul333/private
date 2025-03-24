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
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card h-100 bg-light">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-clock fa-2x mb-2 text-primary"></i>
                                                    <h6 class="fw-bold">Duration</h6>
                                                    <p class="mb-0 fs-5">{{ request('duration') }} Days</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card h-100 bg-light">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-tag fa-2x mb-2 text-primary"></i>
                                                    <h6 class="fw-bold">Price</h6>
                                                    <p class="mb-0 fs-5">${{ request('price') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('campaigns.store', ['user' => auth()->id()]) }}" class="mt-4" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="channel_id" value="{{ $channel->id }}">
                                        <input type="hidden" name="duration" value="{{ request('duration') }}">
                                        <input type="hidden" name="price" value="{{ request('price') }}">

                                        <div class="mb-4">
                                            <h5 class="mb-3">Advertisement Details</h5>
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="ad_image" class="form-label fw-bold">Advertisement Image</label>
                                                        <input type="file" class="form-control" id="ad_image" name="ad_image" accept="image/*" required>
                                                        <small class="text-muted">Upload your advertisement image (Max: 2MB)</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="ad_content" class="form-label fw-bold">Advertisement Content</label>
                                                        <textarea class="form-control" id="ad_content" name="ad_content" rows="4" required placeholder="Enter your advertisement content here..."></textarea>
                                                        <small class="text-muted">Write compelling content for your advertisement</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">Proceed with Campaign</button>
                                    </form>
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




