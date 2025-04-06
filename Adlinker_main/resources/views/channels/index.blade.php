@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Channels</h5>
                    <a href="{{ route('channels.create') }}" class="btn btn-primary">Add Channel</a>
                </div>

                <div class="card-body">
                    @if($channels->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($channels as $channel)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-xl font-semibold text-gray-800">{{ $channel->name }}</h3>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $channel->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($channel->status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-4">{{ Str::limit($channel->description, 100) }}</p>
                                        <div class="flex flex-wrap gap-2 mt-4">
                                            <a href="{{ route('channels.show', $channel) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors duration-300">
                                                <span>View</span>
                                            </a>
                                            <a href="{{ route('channels.edit', $channel) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md transition-colors duration-300">
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('channels.destroy', $channel) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors duration-300" onclick="return confirm('Are you sure you want to delete this channel?')">
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">No channels yet. Add your first channel to start monetizing!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection