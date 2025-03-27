@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Submit Post Link') }}</span>
                    <a href="{{ route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $campaign->channel_id]) }}" class="btn btn-secondary">Back to Campaigns</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('publisher.campaign.submit-link', ['campaign' => $campaign->id]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="post_link" class="form-label">{{ __('Post Link') }}</label>
                            <input id="post_link" type="url" class="form-control @error('post_link') is-invalid @enderror" name="post_link" value="{{ old('post_link') }}" required autocomplete="post_link" autofocus>

                            @error('post_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('Additional Notes') }} (Optional)</label>
                            <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes') }}</textarea>

                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection