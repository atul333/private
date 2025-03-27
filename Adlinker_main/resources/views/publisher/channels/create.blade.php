@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Channel') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('channels.store', ['user' => Auth::id()]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Channel Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subscribers" class="form-label">{{ __('Subscriber Count') }}</label>
                            <input type="number" class="form-control @error('subscribers') is-invalid @enderror" id="subscribers" name="subscribers" value="{{ old('subscribers') }}" required>
                            @error('subscribers')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="views" class="form-label">{{ __('Total Views') }}</label>
                            <input type="number" class="form-control @error('views') is-invalid @enderror" id="views" name="views" value="{{ old('views') }}" required>
                            @error('views')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Add Channel') }}
                            </button>
                            <a href="{{ route('publisher.dashboard', ['user' => Auth::id()]) }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection