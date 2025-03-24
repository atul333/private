@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Channel Details</h5>
                    <a href="{{ route('campaigns.create') }}" class="btn btn-sm btn-outline-primary">Back to Campaign Creation</a>
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
                        </div>
                    </div>

                    <div class="pricing-section mt-4">
                        <h5 class="mb-3">Advertising Pricing</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Duration</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($channel->price_1_day)
                                        <tr>
                                            <td>1 Day</td>
                                            <td>${{ number_format($channel->price_1_day, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($channel->price_2_days)
                                        <tr>
                                            <td>2 Days</td>
                                            <td>${{ number_format($channel->price_2_days, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($channel->price_3_days)
                                        <tr>
                                            <td>3 Days</td>
                                            <td>${{ number_format($channel->price_3_days, 2) }}</td>
                                        </tr>
                                    @endif
                                    @if($channel->price_7_days)
                                        <tr>
                                            <td>7 Days</td>
                                            <td>${{ number_format($channel->price_7_days, 2) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection