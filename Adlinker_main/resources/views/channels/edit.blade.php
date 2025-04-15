@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 py-6 flex flex-col justify-center sm:py-12">
    <div class="container-custom py-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl h-[80vh] flex flex-col">

                <!-- Sticky Header -->
                <div class="px-4 py-3 bg-gradient-to-r from-[#F72585] to-[#B5179E] border-b border-[#7209B7]/20 flex justify-between items-center sticky top-0 z-10">
                    <div class="flex items-center">
                        <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="flex items-center text-white/90 hover:text-white transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Back</span>
                        </a>
                        <h1 class="ml-4 text-xl font-bold text-white">Edit Channel</h1>
                    </div>
                </div>

                <!-- Scrollable Content -->
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <form method="POST" action="{{ route('channels.update', ['user' => Auth::id(), 'channel' => $channel]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                                <label for="name" class="block text-sm font-medium text-gray-900">Channel Name</label>
                                <input type="text" class="mt-1 text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" id="name" name="name" value="{{ old('name', $channel->name) }}" required>
                                @error('name')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                                <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                                <textarea class="mt-1 block text-sm w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @enderror" id="description" name="description" rows="3" required>{{ old('description', $channel->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
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
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                                <label for="subscribers_count" class="block text-sm font-medium text-gray-900">Subscribers Count</label>
                                <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('subscribers_count') border-red-300 text-red-900 @enderror" id="subscribers_count" name="subscribers_count" value="{{ old('subscribers_count', $channel->subscribers_count) }}" required min="0">
                                @error('subscribers_count')
                                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-3">
                                <h2 class="text-lg font-medium text-gray-900">Pricing Options</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                                    @foreach(['1_day', '2_days', '3_days', '7_days'] as $day)
                                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 space-y-2 shadow-md hover:shadow-lg transition-all duration-300 border border-[#4895EF]/20">
                                        <label for="price_{{ $day }}" class="block text-sm font-medium text-gray-900">Price ({{ str_replace('_', ' ', ucfirst($day)) }})</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_' . $day) border-red-300 text-red-900 @enderror" id="price_{{ $day }}" name="price_{{ $day }}" value="{{ old('price_' . $day, $channel->{'price_' . $day}) }}" min="0">
                                        </div>
                                        @error('price_' . $day)
                                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endforeach
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
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                        Update Channel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
