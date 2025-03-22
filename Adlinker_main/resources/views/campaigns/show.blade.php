@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Campaign Details</h5>
                    <div>
                        <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-warning">Edit Campaign</a>
                        <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this campaign?')">Delete Campaign</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Campaign Name</h6>
                            <p class="h5">{{ $campaign->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p><span class="badge bg-{{ $campaign->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($campaign->status) }}</span></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Budget</h6>
                            <p class="h5">${{ number_format($campaign->budget, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Target Audience</h6>
                            <p class="h5">{{ $campaign->target_audience }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Start Date</h6>
                            <p class="h5">{{ $campaign->start_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">End Date</h6>
                            <p class="h5">{{ $campaign->end_date->format('Y-m-d') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p>{{ $campaign->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Active Ads</h5>
                                    <h2 class="display-4 mb-0">{{ $campaign->ads->where('status', 'active')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Impressions</h5>
                                    <h2 class="display-4 mb-0">{{ $campaign->ads->sum('impressions') }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Total Clicks</h5>
                                    <h2 class="display-4 mb-0">{{ $campaign->ads->sum('clicks') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection