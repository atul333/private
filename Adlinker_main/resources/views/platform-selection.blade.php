@extends('layouts.app')

@section('title', 'Select Platform')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Choose Your <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Platform</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                Select a platform to start managing your advertisement campaigns
            </p>
        </div>

        <!-- Platforms Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Telegram Platform -->
            <form action="{{ route('platform.select') }}" method="POST">
                @csrf
                <input type="hidden" name="platform" value="telegram">
                <button type="submit" class="w-full group">
                    <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border-2 border-transparent hover:border-blue-500 p-8">
                        <!-- Background Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Telegram</h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-4">Manage Telegram channel advertisements</p>
                            
                            <!-- Badge -->
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Active
                            </span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- Instagram Platform -->
            <form action="{{ route('platform.select') }}" method="POST">
                @csrf
                <input type="hidden" name="platform" value="instagram">
                <button type="submit" class="w-full group">
                    <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden border-2 border-transparent hover:border-pink-500 p-8">
                        <!-- Background Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Instagram</h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-4">Manage Instagram story advertisements</p>
                            
                            <!-- Badge -->
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                Active
                            </span>
                        </div>
                    </div>
                </button>
            </form>



            <!-- Facebook Platform -->
            <form action="{{ route('platform.select') }}" method="POST">
                @csrf
                <input type="hidden" name="platform" value="facebook">
                <button type="submit" class="w-full group cursor-not-allowed" disabled>
                    <div class="relative bg-white rounded-2xl shadow-md overflow-hidden border-2 border-gray-200 p-8 opacity-60">
                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Facebook</h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-4">Manage Facebook advertisements</p>
                            
                            <!-- Badge -->
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Coming Soon
                            </span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- YouTube Platform -->
            <form action="{{ route('platform.select') }}" method="POST">
                @csrf
                <input type="hidden" name="platform" value="youtube">
                <button type="submit" class="w-full group cursor-not-allowed" disabled>
                    <div class="relative bg-white rounded-2xl shadow-md overflow-hidden border-2 border-gray-200 p-8 opacity-60">
                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-red-500 to-red-700 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">YouTube</h3>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-4">Manage YouTube advertisements</p>
                            
                            <!-- Badge -->
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Coming Soon
                            </span>
                        </div>
                    </div>
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500">
                More platforms coming soon. Stay tuned for updates!
            </p>
        </div>
    </div>
</div>
@endsection
