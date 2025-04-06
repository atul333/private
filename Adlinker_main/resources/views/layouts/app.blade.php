<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialAdLinker') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/countdown.js','resources/sass/app.scss'])
</head>
<body class="bg-gray-50">
    <div id="app">
        <nav class="bg-white shadow-lg fixed top-0 left-0 right-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a class="text-2xl font-extrabold text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out" href="{{ url('/') }}">
                                SocialAdLinker
                            </a>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden fixed top-4 right-4 z-50">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition duration-150 ease-in-out bg-white shadow-md" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="flex space-x-4">

                        <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login') && !Request::is('login'))
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">{{ __('Login') }}</a>
                                @endif

                                @if (Route::has('register') && !Request::is('register'))
                                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">{{ __('Register') }}</a>
                                @endif
                            @else
                                @if(Auth::check())
                                    <a href="{{ auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                                        <i class="fas fa-wallet"></i>
                                        <span class="ml-1">Wallet</span>
                                    </a>
                                @endif
                                
                                <div class="ml-3 relative group">
                                    <div>
                                        <button type="button" class="bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <span class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">{{ Auth::user()->name }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                
                                    <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu-dropdown" style="pointer-events: auto;">
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-40" id="mobile-menu-backdrop" style="display: none;"></div>
            <div class="sm:hidden fixed inset-y-0 right-0 w-64 bg-white shadow-xl z-40 transform transition-transform duration-300 ease-in-out translate-x-full" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @guest
                        @if (Route::has('login') && !Request::is('login'))
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register') && !Request::is('register'))
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900 block px-3 py-2 rounded-md text-base font-medium">{{ __('Register') }}</a>
                        @endif
                    @else
                        @if(Auth::check())
                            <div class="flex flex-col space-y-4 px-3 py-2">
                                <a href="#" class="text-gray-600 hover:text-gray-900 rounded-md text-base font-medium">{{ Auth::user()->name }}</a>
                                <a href="{{ auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet') }}" class="text-gray-600 hover:text-gray-900 rounded-md text-base font-medium">
                                    <i class="fas fa-wallet"></i>
                                    <span class="ml-1">Wallet</span>
                                </a>
                                <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-900 rounded-md text-base font-medium"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        @endif
                    @endguest
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 mt-16">
            @yield('content')
        </main>
    </div>

    <script>
        // Toggle mobile menu
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
        let isMobileMenuOpen = false;

        if (mobileMenuButton && mobileMenu && mobileMenuBackdrop) {
            mobileMenuButton.addEventListener('click', function() {
                isMobileMenuOpen = !isMobileMenuOpen;
                mobileMenuButton.setAttribute('aria-expanded', isMobileMenuOpen);
                
                if (isMobileMenuOpen) {
                    mobileMenu.classList.remove('translate-x-full');
                    mobileMenuBackdrop.style.display = 'block';
                } else {
                    mobileMenu.classList.add('translate-x-full');
                    mobileMenuBackdrop.style.display = 'none';
                }
            });

            mobileMenuBackdrop.addEventListener('click', function() {
                isMobileMenuOpen = false;
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.add('translate-x-full');
                mobileMenuBackdrop.style.display = 'none';
            });
        }
    
        // Handle user menu dropdown
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        let isDropdownOpen = false;
    
        if (userMenuButton && userMenuDropdown) {
            // Toggle on click
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                userMenuDropdown.classList.toggle('hidden');
                userMenuButton.setAttribute('aria-expanded', isDropdownOpen);
            });
    
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
                    userMenuDropdown.classList.add('hidden');
                    isDropdownOpen = false;
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
    
            // Handle hover events with delay
            const menuContainer = userMenuButton.closest('.group');
            let hoverTimeout;
    
            if (menuContainer) {
                menuContainer.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                    userMenuDropdown.classList.remove('hidden');
                    isDropdownOpen = true;
                    userMenuButton.setAttribute('aria-expanded', 'true');
                });
    
                menuContainer.addEventListener('mouseleave', function() {
                    hoverTimeout = setTimeout(() => {
                        if (!isDropdownOpen) {
                            userMenuDropdown.classList.add('hidden');
                            userMenuButton.setAttribute('aria-expanded', 'false');
                        }
                    }, 200);
                });
    
                // Prevent dropdown from closing when hovering over it
                userMenuDropdown.addEventListener('mouseenter', function() {
                    clearTimeout(hoverTimeout);
                });
    
                userMenuDropdown.addEventListener('mouseleave', function() {
                    if (!isDropdownOpen) {
                        userMenuDropdown.classList.add('hidden');
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        }
    </script>
</body>
</html>
