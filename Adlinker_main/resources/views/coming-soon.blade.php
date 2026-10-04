@extends('layouts.app')

@section('title', ucfirst($platform) . ' - Coming Soon')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 flex items-center justify-center px-4 py-8 pb-28 sm:pb-12">
    <div class="max-w-lg w-full text-center">
        <!-- Platform Icon -->
        <div class="mb-6">
            @if($platform === 'snapchat')
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-3xl bg-[#FFFC00] flex items-center justify-center shadow-lg">
                    <i class="fab fa-snapchat text-5xl sm:text-6xl text-black"></i>
                </div>
            @elseif($platform === 'facebook')
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-3xl bg-[#1877F2] flex items-center justify-center shadow-lg text-white">
                    <i class="fab fa-facebook text-5xl sm:text-6xl"></i>
                </div>
            @elseif($platform === 'youtube')
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-3xl bg-[#FF0000] flex items-center justify-center shadow-lg text-white">
                    <i class="fab fa-youtube text-5xl sm:text-6xl"></i>
                </div>
            @else
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-3xl bg-gray-900 flex items-center justify-center shadow-lg text-white">
                    <i class="fas fa-rocket text-5xl sm:text-6xl"></i>
                </div>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">Coming Soon</h1>
        <p class="text-sm sm:text-base text-gray-600 mb-6">
            <span class="font-semibold text-gray-900">{{ ucfirst($platform) }}</span> integration will be available in the next phase of development. Stay tuned for updates!
        </p>

        <div class="bg-blue-50/80 border border-blue-200/80 rounded-xl px-4 py-3 text-xs sm:text-sm text-blue-800 inline-flex items-center gap-2 mb-6">
            <i class="fas fa-info-circle text-blue-500 shrink-0"></i>
            <span>This platform is currently under development and will be launched soon.</span>
        </div>

        <div class="mb-8">
            <a href="{{ route('platform.selection') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium text-sm sm:text-base shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Back to Platform Selection</span>
            </a>
        </div>

        <!-- Available Platforms -->
        <div class="pt-6 border-t border-gray-200">
            <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 mb-4">Currently Available Platforms</p>
            <div class="flex justify-center items-center gap-8">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 flex items-center justify-center text-[#0088cc] shadow-xs">
                        <i class="fab fa-telegram-plane text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-1.5">Telegram</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-xl bg-pink-50 border border-pink-200 flex items-center justify-center text-[#E1306C] shadow-xs">
                        <i class="fab fa-instagram text-2xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-1.5">Instagram</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
