@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Channel</h5>
                    <a href="{{ route('channels.index') }}" class="btn btn-secondary">Back to Channels</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('channels.update', $channel) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Channel Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $channel->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $channel->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            @if($channel->logo_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="Channel Logo" class="img-thumbnail" style="max-width: 200px">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subscribers_count" class="form-label">Subscribers Count</label>
                            <input type="number" class="form-control @error('subscribers_count') is-invalid @enderror" id="subscribers_count" name="subscribers_count" value="{{ old('subscribers_count', $channel->subscribers_count) }}" required min="0">
                            @error('subscribers_count')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price_1_day" class="form-label">Price (1 Day)</label>
                            <input type="number" step="0.01" class="form-control @error('price_1_day') is-invalid @enderror" id="price_1_day" name="price_1_day" value="{{ old('price_1_day', $channel->price_1_day) }}" min="0">
                            @error('price_1_day')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price_2_days" class="form-label">Price (2 Days)</label>
                            <input type="number" step="0.01" class="form-control @error('price_2_days') is-invalid @enderror" id="price_2_days" name="price_2_days" value="{{ old('price_2_days', $channel->price_2_days) }}" min="0">
                            @error('price_2_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price_3_days" class="form-label">Price (3 Days)</label>
                            <input type="number" step="0.01" class="form-control @error('price_3_days') is-invalid @enderror" id="price_3_days" name="price_3_days" value="{{ old('price_3_days', $channel->price_3_days) }}" min="0">
                            @error('price_3_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price_7_days" class="form-label">Price (7 Days)</label>
                            <input type="number" step="0.01" class="form-control @error('price_7_days') is-invalid @enderror" id="price_7_days" name="price_7_days" value="{{ old('price_7_days', $channel->price_7_days) }}" min="0">
                            @error('price_7_days')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $channel->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $channel->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Channel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection