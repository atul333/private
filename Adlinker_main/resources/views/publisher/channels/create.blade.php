@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col flex-1">
        <!-- Header -->
        <div class="px-4 py-2.5 bg-gradient-to-r from-sky-50 to-blue-50/80 border-b border-[#0088cc]/15 flex items-center min-h-[52px]">
            <a href="{{ route('publisher.dashboard', ['user' => Auth::id()]) }}" class="mr-3 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-base sm:text-lg font-bold text-gray-900">Add New Channel</h1>
        </div>

        <!-- Content -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12 flex-1">
            <div class="max-w-lg mx-auto">
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-sm border border-[#0088cc]/20 overflow-hidden">
                    <form method="POST" action="{{ route('channels.store', ['user' => Auth::id()]) }}" class="p-4 sm:p-6 space-y-4">
                        @csrf

                        @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                <ul class="text-xs text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Channel Name</label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   class="block w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-300 shadow-sm focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/30 focus:outline-none transition duration-200"
                                   required autofocus>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="block w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-300 shadow-sm focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/30 focus:outline-none transition duration-200">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="subscribers" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Subscribers</label>
                                <input type="number" id="subscribers" name="subscribers"
                                       value="{{ old('subscribers') }}"
                                       class="block w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-300 shadow-sm focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/30 focus:outline-none transition duration-200"
                                       required>
                                @error('subscribers')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="views" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Total Views</label>
                                <input type="number" id="views" name="views"
                                       value="{{ old('views') }}"
                                       class="block w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-300 shadow-sm focus:border-[#0088cc] focus:ring-2 focus:ring-[#0088cc]/30 focus:outline-none transition duration-200"
                                       required>
                                @error('views')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('publisher.dashboard', ['user' => Auth::id()]) }}"
                               class="flex-1 inline-flex items-center justify-center py-3 px-4 rounded-xl text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center py-3 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-[#0088cc] to-[#0099ff] hover:from-[#0077b5] hover:to-[#0088cc] shadow-md hover:shadow-lg transition-all duration-200">
                                Add Channel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection