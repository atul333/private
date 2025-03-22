@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Channels</h5>
                    <a href="{{ route('channels.create') }}" class="btn btn-primary">Add Channel</a>
                </div>

                <div class="card-body">
                    @if($channels->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($channels as $channel)
                                        <tr>
                                            <td>{{ $channel->name }}</td>
                                            <td>{{ Str::limit($channel->description, 100) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $channel->status === 'active' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($channel->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('channels.show', $channel) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('channels.edit', $channel) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('channels.destroy', $channel) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this channel?')">Delete</button>
                                                </form>
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
</div>
@endsection