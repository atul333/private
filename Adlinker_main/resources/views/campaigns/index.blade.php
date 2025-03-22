@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Campaigns</h5>
                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">Create New Campaign</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($campaigns->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Campaign Name</th>
                                        <th>Budget</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaigns as $campaign)
                                        <tr>
                                            <td>{{ $campaign->name }}</td>
                                            <td>${{ number_format($campaign->budget, 2) }}</td>
                                            <td>{{ $campaign->start_date->format('Y-m-d') }}</td>
                                            <td>{{ $campaign->end_date->format('Y-m-d') }}</td>
                                            <td><span class="badge bg-{{ $campaign->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($campaign->status) }}</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-info">View</a>
                                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this campaign?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No campaigns found. Create your first campaign to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection