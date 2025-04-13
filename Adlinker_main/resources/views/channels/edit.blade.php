@extends('layouts.app')

@section('content')
<div class="container-custom py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-4 py-1 bg-gray-50 border-b border-gray-300">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="btn-back mr-4 flex items-center text-gray-600 hover:text-gray-900">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                        <h1 class="text-sm font-semibold text-gray-800">Edit Channel</h1>
                    </div>
                </div>
            </div>

                <div class="p-1 space-y-6">
                    <form method="POST" action="{{ route('channels.update', ['user' => Auth::id(), 'channel' => $channel]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="p-1 space-y-6">
                            <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                <label for="name" class="block text-sm font-medium text-gray-900">Channel Name</label>
                                <input type="text" class="mt-1 text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" id="name" name="name" value="{{ old('name', $channel->name) }}" required>
                                @error('name')
                                    <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                                <textarea class="mt-1 block text-sm w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" id="description" name="description" rows="3" required>{{ old('description', $channel->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                <label for="logo" class="block text-sm font-medium text-gray-900">Logo</label>
                                @if($channel->logo_path)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $channel->logo_path) }}" alt="Channel Logo" class="h-20 w-20 rounded-full object-cover border border-indigo-900 ring-4 ring-indigo-50">
                                    </div>
                                @endif
                                <div class="mt-2">
                                    <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('logo') border-red-300 text-red-900 @enderror" id="logo" name="logo">
                                </div>
                                @error('logo')
                                    <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                <label for="subscribers_count" class="block text-sm font-medium text-gray-900">Subscribers Count</label>
                                <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('subscribers_count') border-red-300 text-red-900 @enderror" id="subscribers_count" name="subscribers_count" value="{{ old('subscribers_count', $channel->subscribers_count) }}" required min="0">
                                @error('subscribers_count')
                                    <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        <div class="space-y-3">
                                <h2 class="text-lg font-medium text-gray-900">Pricing Options</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                    <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                        <label for="price_1_day" class="block text-sm font-medium text-gray-900">Price (1 Day)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_1_day') border-red-300 text-red-900 @enderror" id="price_1_day" name="price_1_day" value="{{ old('price_1_day', $channel->price_1_day) }}" min="0">
                                        </div>
                                        @error('price_1_day')
                                            <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                        <label for="price_2_days" class="block text-sm font-medium text-gray-900">Price (2 Days)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_2_days') border-red-300 text-red-900 @enderror" id="price_2_days" name="price_2_days" value="{{ old('price_2_days', $channel->price_2_days) }}" min="0">
                                        </div>
                                        @error('price_2_days')
                                            <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                        <label for="price_3_days" class="block text-sm font-medium text-gray-900">Price (3 Days)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_3_days') border-red-300 text-red-900 @enderror" id="price_3_days" name="price_3_days" value="{{ old('price_3_days', $channel->price_3_days) }}" min="0">
                                        </div>
                                        @error('price_3_days')
                                            <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                        <div class="bg-gray-50 rounded-lg p-1 space-y-2">
                                        <label for="price_7_days" class="block text-sm font-medium text-gray-900">Price (7 Days)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_7_days') border-red-300 text-red-900 @enderror" id="price_7_days" name="price_7_days" value="{{ old('price_7_days', $channel->price_7_days) }}" min="0">
                                        </div>
                                        @error('price_7_days')
                                            <p class="mt-2 text-xs	 text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        <div class="mb-3">
                            <label for="status" class="form-label font-medium text-gray-900">Status</label>
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
                            <div class="mt-6">
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Channel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection