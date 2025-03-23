<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdLinker - Telegram Ads Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-blue-600">AdLinker</span>
                </div>
                <div class="flex items-center space-x-4">
                   
                            @auth
                                @if(Auth::user()->role === 'advertiser')
                                    <a href="/advertiser/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                                @elseif(Auth::user()->role === 'publisher')
                                    <a href="/{{ Auth::user()->id }}/publisher/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Log in</a>
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Sign up</a>
                            @endauth
                           
                        
                    
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            Telegram ads platform: <span class="text-blue-600">trusted and effective</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg">
                            We help with finding target audiences on Telegram and launching successful advertising campaigns
                        </p>
                        <div class="mt-8 sm:mx-auto sm:max-w-lg lg:mx-0">
                            <button class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                Create Telegram Ad
                            </button>
                        </div>
                    </div>
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full lg:max-w-md">
                            <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                                <!-- Dashboard screenshot removed for cleaner layout -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-4xl font-extrabold text-blue-600">252,128</dt>
                            <dd class="mt-1 text-sm text-gray-500">Total Channels</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-4xl font-extrabold text-blue-600">7,087</dt>
                            <dd class="mt-1 text-sm text-gray-500">Active Advertisers</dd>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dt class="text-4xl font-extrabold text-blue-600">2,768</dt>
                            <dd class="mt-1 text-sm text-gray-500">Online Now</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
