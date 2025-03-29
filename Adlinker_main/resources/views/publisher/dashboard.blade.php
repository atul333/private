@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Publisher Dashboard') }}</span>
                    <div>
                        <a href="{{ route('publisher.withdrawals.create') }}" class="btn btn-success me-2">Withdraw Earnings</a>
                        <a href="{{ route('channels.create', ['user' => Auth::id()]) }}" class="btn btn-primary">Add New Channel</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Active Channels</h5>
                                    <h2 class="mb-0">{{ $activeChannels }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Earnings</h5>
                                    <h2 class="mb-0">${{ number_format($totalEarnings, 2) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Subscribers</h5>
                                    <h2 class="mb-0">{{ $channels->sum('subscribers_count') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Channel Logo</th>
                                    <th>Channel Name</th>
                                    <th>Subscribers</th>
                                    <th>Earnings</th>
                                    <th>Channel Status</th>
                                    <th>Actions</th>
                                    <th>Ad Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($channels as $channel)
                                    <tr>
                                        <td class="text-center">
                                            @if($channel->logo_path)
                                                <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="{{ $channel->name }} Logo" class="img-fluid rounded-circle" style="height: 40px; width: 40px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">No Logo</span>
                                            @endif
                                        </td>
                                        <td>{{ $channel->name }}</td>
                                        <td>{{ number_format($channel->subscribers_count) }}</td>
                                        <td>${{ number_format($channel->earnings ?? 0, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $channel->status === 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($channel->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('channels.show', ['user' => Auth::id(), 'channel' => $channel]) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('channels.edit', ['user' => Auth::id(), 'channel' => $channel]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel]) }}" 
                                               class="btn btn-sm btn-primary {{ $channel->campaigns->count() > 0 ? '' : 'disabled' }}">
                                                View Status
                                                @if($channel->campaigns->count() > 0)
                                                    <span class="badge bg-info ms-1">{{ $channel->campaigns->count() }}</span>
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No channels found</td>
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