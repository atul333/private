@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Channel Details</h5>
                    <div>
                        <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="btn btn-warning">Edit Channel</a>
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn btn-secondary">Back to Channels</a>
                    </div>
                </div>

                <div class="card-body">
                    @if($channel->logo_path)
                    <div class="mb-4 text-center">
                        <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="Channel Logo" class="img-fluid" style="max-width: 200px;">
                    </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Channel Name</h6>
                        <p class="h5">{{ $channel->name }}</p>
                    </div>

                    @if($channel->link)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Channel Link</h6>
                        <a href="{{ $channel->link }}" target="_blank" class="text-primary">{{ $channel->link }}</a>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Description</h6>
                        <p>{{ $channel->description }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Subscribers Count</h6>
                        <p class="h5">{{ number_format($channel->subscribers_count) }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Pricing Options</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
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

                    <form action="{{ route('channels.destroy', ['user' => Auth::id(), 'channel' => $channel]) }}" method="POST" class="mt-4">
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