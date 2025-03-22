@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="mb-4">Welcome, {{ auth()->user()->name }}!</h2>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if(auth()->user()->role === 'advertiser')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Campaign Dashboard</h5>
                                <a href="{{ route('campaigns.create') }}" class="btn btn-primary">Create Campaign</a>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Active Ads</h5>
                                                <h2 class="display-4 mb-0">{{ $activeAds }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Spent</h5>
                                                <h2 class="display-4 mb-0">${{ number_format($totalSpent, 2) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                @if($campaigns->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Campaign Name</th>
                                                    <th>Budget</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($campaigns as $campaign)
                                                    <tr>
                                                        <td class="align-middle">{{ $campaign->name }}</td>
                                                        <td class="align-middle">${{ number_format($campaign->budget, 2) }}</td>
                                                        <td class="align-middle"><span class="badge bg-{{ $campaign->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($campaign->status) }}</span></td>
                                                        <td class="align-middle">
                                                            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-info">View Details</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-0">No campaigns yet. Create your first campaign to start advertising!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(auth()->user()->role === 'publisher')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Channel Dashboard</h5>
                                <a href="{{ route('channels.create') }}" class="btn btn-primary">Add Channel</a>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Active Channels</h5>
                                                <h2 class="display-4 mb-0">{{ $activeChannels }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Earnings</h5>
                                                <h2 class="display-4 mb-0">${{ number_format($totalEarnings, 2) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($channels->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Channel Name</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($channels as $channel)
                                                    <tr>
                                                        <td class="align-middle">{{ $channel->name }}</td>
                                                        <td class="align-middle">{{ ucfirst($channel->type) }}</td>
                                                        <td class="align-middle"><span class="badge bg-{{ $channel->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($channel->status) }}</span></td>
                                                        <td class="align-middle">
                                                            <a href="{{ route('channels.show', $channel) }}" class="btn btn-sm btn-info">View Details</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-muted mb-0">No channels yet. Add your first channel to start monetizing!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
