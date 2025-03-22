@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Channel Details</h5>
                    <div>
                        <a href="{{ route('channels.edit', $channel) }}" class="btn btn-warning">Edit Channel</a>
                        <a href="{{ route('channels.index') }}" class="btn btn-secondary">Back to Channels</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Channel Name</h6>
                        <p class="h5">{{ $channel->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Description</h6>
                        <p>{{ $channel->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Status</h6>
                        <span class="badge bg-{{ $channel->status === 'active' ? 'success' : 'warning' }}">
                            {{ ucfirst($channel->status) }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Created At</h6>
                        <p>{{ $channel->created_at->format('F j, Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Last Updated</h6>
                        <p>{{ $channel->updated_at->format('F j, Y') }}</p>
                    </div>

                    <form action="{{ route('channels.destroy', $channel) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this channel?')">
                            Delete Channel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection