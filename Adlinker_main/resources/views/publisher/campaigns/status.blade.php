@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Campaign Status for') }} {{ $channel->name }}</span>
                    <a href="{{ route('publisher.dashboard', ['user' => Auth::id()]) }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Advertisement</th>
                                    <th>Content</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Countdown</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $campaign)
                                    <tr>
                                        <td class="text-center">
                                            @if($campaign->advertisement_image)
                                                <img src="{{ asset('storage/' . $campaign->advertisement_image) }}" 
                                                     alt="Advertisement Image" 
                                                     class="img-fluid" 
                                                     style="max-height: 100px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $campaign->advertisement_content }}</td>
                                        <td>{{ $campaign->duration }} days</td>
                                        <td>${{ number_format($campaign->price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($campaign->status === 'pending')
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('publisher.campaign.accept', ['campaign' => $campaign->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success me-2">Accept</button>
                                                    </form>
                                                    <form action="{{ route('publisher.campaign.reject', ['campaign' => $campaign->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
                                                </div>
                                            @elseif($campaign->status === 'active')
                                                <a href="{{ route('publisher.campaign.submit-link.form', ['campaign' => $campaign->id]) }}" class="btn btn-sm btn-primary" id="submitLinkBtn-{{ $campaign->id }}">Submit Link</a>
                                            @else
                                                - 
                                            @endif
                                        </td>
                                        <td>
                                            @if($campaign->status === 'active')
                                                <div class="countdown-container">
                                                    <div class="countdown-timer" 
                                                         data-duration="{{ $campaign->duration }}"
                                                         data-start="{{ $campaign->created_at->toISOString() }}">
                                                        <div class="countdown-text">Loading...</div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No active campaigns found</td>
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

@push('scripts')
<!-- The countdown timer functionality is now handled by countdown.js -->
@endpush

@endsection