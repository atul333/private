@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Channel Campaigns</h5>
                    <a href="{{ route('publisher.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    @if($channel->campaigns->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Campaign Name</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Post Link</th>
                                        <th>Time Remaining</th>
                                        <th>Actions</th>
                                        <th>Time Left</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($channel->campaigns as $campaign)
                                        <tr>
                                            <td>{{ $campaign->name }}</td>
                                            <td>${{ number_format($campaign->budget, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $campaign->status === 'active' ? 'success' : ($campaign->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($campaign->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($campaign->post_link)
                                                    <a href="{{ $campaign->post_link }}" target="_blank" class="btn btn-sm btn-info">View Post</a>
                                                @else
                                                    <a href="{{ route('publisher.campaign.submit-link.form', $campaign) }}" class="btn btn-sm btn-primary">Submit Link</a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($campaign->status === 'pending')
                                                    <form action="{{ route('publisher.campaign.accept', $campaign) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                                    </form>
                                                    <form action="{{ route('publisher.campaign.reject', $campaign) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if($campaign->post_link && $campaign->status === 'active')
                                                    <div class="countdown-timer" 
                                                         data-duration="{{ $campaign->duration * 24 * 60 * 60 }}" 
                                                         data-start-time="{{ $campaign->post_submitted_at }}"
                                                         data-campaign-id="{{ $campaign->id }}"
                                                    >Calculating...</div>
                                                @elseif(!$campaign->post_link && $campaign->status === 'active')
                                                    <span class="text-warning">Awaiting Post Link</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center mb-0">No campaigns found for this channel.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateCountdownTimers() {
    document.querySelectorAll('.countdown-timer').forEach(function(element) {
        try {
            const duration = parseInt(element.dataset.duration);
            const startTime = new Date(element.dataset.startTime).getTime();
            const now = new Date().getTime();
            
            if (isNaN(startTime)) {
                element.innerHTML = 'Invalid start time';
                return;
            }
            
            const elapsed = Math.floor((now - startTime) / 1000);
            const remaining = duration - elapsed;

            if (remaining <= 0) {
                element.innerHTML = '<span class="text-danger">Campaign Ended</span>';
                return;
            }

            const days = Math.floor(remaining / (24 * 60 * 60));
            const hours = Math.floor((remaining % (24 * 60 * 60)) / (60 * 60));
            const minutes = Math.floor((remaining % (60 * 60)) / 60);
            const seconds = remaining % 60;

            element.innerHTML = `<span class="text-success">${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
        } catch (error) {
            console.error('Error updating countdown:', error);
            element.innerHTML = 'Error calculating time';
        }
    });
}

// Update countdown every second
setInterval(updateCountdownTimers, 1000);

// Initial update
updateCountdownTimers();
</script>
@endpush
@endsection