@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Channel</h5>
                    <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn btn-secondary">Back to Channels</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('channels.store', ['user' => Auth::id()]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Channel Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Channel Link</label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}" required placeholder="https://t.me/yourchannel">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Channel Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Channel Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*" required>
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subscribers_count" class="form-label">Subscribers Count</label>
                            <input type="number" class="form-control @error('subscribers_count') is-invalid @enderror" id="subscribers_count" name="subscribers_count" value="{{ old('subscribers_count') }}" required min="0">
                            @error('subscribers_count')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <h5 class="mb-3">Pricing Options</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="price_1_day" class="form-label">Price for 1 Day ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_1_day') is-invalid @enderror" id="price_1_day" name="price_1_day" value="{{ old('price_1_day') }}" required min="0">
                                @error('price_1_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price_2_days" class="form-label">Price for 2 Days ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_2_days') is-invalid @enderror" id="price_2_days" name="price_2_days" value="{{ old('price_2_days') }}" required min="0">
                                @error('price_2_days')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price_3_days" class="form-label">Price for 3 Days ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_3_days') is-invalid @enderror" id="price_3_days" name="price_3_days" value="{{ old('price_3_days') }}" required min="0">
                                @error('price_3_days')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="price_7_days" class="form-label">Price for 7 Days ($)</label>
                                <input type="number" step="0.01" class="form-control @error('price_7_days') is-invalid @enderror" id="price_7_days" name="price_7_days" value="{{ old('price_7_days') }}" required min="0">
                                @error('price_7_days')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Channel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection