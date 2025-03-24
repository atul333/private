@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Advertiser Dashboard') }}</span>
                    <div>
                        <a href="/{{ Auth::id() }}/campaigns/create" class="btn btn-primary">Create New Campaign</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Active Campaigns</h5>
                                    <h2 class="mb-0">{{ $activeCampaigns }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Budget</h5>
                                    <h2 class="mb-0">${{ number_format($totalBudget, 2) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Impressions</h5>
                                    <h2 class="mb-0">{{ number_format($totalImpressions) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Campaign Name</th>
                                    <th>Budget</th>
                                    <th>Impressions</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td>{{ $campaign->name }}</td>
                                        <td>${{ number_format($campaign->budget, 2) }}</td>
                                        <td>{{ number_format($campaign->impressions) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $campaign->status === 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $campaign->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $campaign->end_date->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No campaigns found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection