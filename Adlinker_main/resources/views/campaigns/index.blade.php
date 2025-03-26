@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Your Campaigns</h5>
                    <a href="{{ route('campaigns.create', ['user' => auth()->id()]) }}" class="btn btn-primary">Create New Campaign</a>
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
                                        <th>Channel Name</th>
                                        <th>Subscribers</th>
                                        <th>Channel Link</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Advertisement Content</th>                                 
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaigns as $campaign)
                                        <tr>
                                            <td>{{ $campaign->channel_name }}</td>
                                            <td>{{ number_format($campaign->subscribers) }}</td>
                                            <td><a href="{{ $campaign->channel_link }}" target="_blank">View Channel</a></td>
                                            <td>{{ $campaign->duration }} days</td>
                                            <td>${{ number_format($campaign->price, 2) }}</td>
                                            <td>
                                                @if($campaign->advertisement_image)
                                                    <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" alt="Advertisement" class="img-thumbnail" style="max-width: 100px;">
                                                @else
                                                    No image
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($campaign->advertisement_content, 50) }}</td>
                                            <td><span class="badge bg-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'pending' ? 'warning' : ($campaign->status === 'completed' ? 'info' : 'danger')) }}">{{ ucfirst($campaign->status) }}</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('campaigns.show', ['user' => auth()->id(), 'campaign' => $campaign]) }}" class="btn btn-sm btn-info">View</a>
                                                    <a href="{{ route('campaigns.edit', ['user' => auth()->id(), 'campaign' => $campaign]) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('campaigns.destroy', ['user' => auth()->id(), 'campaign' => $campaign]) }}" method="POST" class="d-inline">
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