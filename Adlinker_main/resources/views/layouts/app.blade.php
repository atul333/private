<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialAdLinker') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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
<body class="bg-gray-50 h-screen flex flex-col overflow-hidden">
    @php
        $balance = '0.00';
        if(Auth::check()) {
            $wallet = \App\Models\Wallet::where('user_id', Auth::id())->first();
            $balance = $wallet ? number_format($wallet->balance, 2) : '0.00';
        }
    @endphp
    <div id="app" class="flex flex-col h-full overflow-auto">
        <nav class="bg-white/80 backdrop-blur-sm shadow-sm fixed top-0 left-0 right-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition duration-300">SocialAdLinker</a>
                        </div>
                    </div>

                    <!-- Mobile navigation -->
                    <div class="flex items-center sm:hidden space-x-2">
                        @guest
                            @if (Route::has('login') && !Request::is('login'))
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-200">{{ __('Login') }}</a>
                            @endif
                        @else
                            <button onclick="toggleChat()" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                                <i class="fas fa-envelope"></i>
                            </button>
                            @if(Auth::check())
                                <a href="{{ auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet') }}" class="flex items-center space-x-1 bg-white hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg shadow-sm border border-gray-200 transition-all duration-200">
                                    <i class="fas fa-wallet text-blue-500"></i>
                                    <span class="font-medium">${{ $balance }}</span>
                                </a>
                                <div class="relative">
                                    <button type="button" class="mobile-menu-button text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                        <span>{{ Auth::user()->name }}</span>
                                        <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="mobile-menu-dropdown hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white/90 backdrop-blur-sm ring-1 ring-black ring-opacity-5 z-50">
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200" onclick="document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endguest
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="flex space-x-4">
                            @if (!Request::is('login') && !Request::is('register'))
                                <button onclick="toggleChat()" class="flex items-center space-x-1.5 bg-white/95 hover:bg-white text-gray-700 px-3 py-1.5 rounded-md shadow-sm border border-gray-200/80 transition-all duration-200 hover:shadow group">
                                    <i class="fas fa-envelope text-blue-500 text-sm"></i>
                                    <span class="text-sm font-medium">Contact</span>
                                </button>
                            @endif

                        <!-- Authentication Links -->
                            @guest
                            @else
                                @if(Auth::check())
                                    <div class="relative group">
                                        <a href="{{ auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet') }}" class="flex items-center space-x-1.5 bg-white/95 hover:bg-white text-gray-700 px-3 py-1.5 rounded-md shadow-sm border border-gray-200/80 transition-all duration-200 hover:shadow group">
                                            <i class="fas fa-wallet text-blue-500 text-sm"></i>
                                            <span class="text-sm font-medium">${{ $balance }}</span>
                                        </a>
                                    </div>
                                @endif
                                
                                <div class="ml-3 relative group">
                                    <div>
                                        <button type="button" class="bg-white/90 backdrop-blur-sm rounded-lg flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:bg-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <span class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">{{ Auth::user()->name }}</span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                
                                    <div class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white/90 backdrop-blur-sm ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu-dropdown" style="pointer-events: auto;">
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="document.getElementById('logout-form').submit();">
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

            <!-- Mobile menu placeholder for spacing -->
            <div class="sm:hidden h-0"></div>
        </nav>

        <main class="max-w-7xl w-full mx-auto sm:px-6 lg:px-8 mt-16 flex-1 overflow-auto">
            @yield('content')
        </main>

        <!-- Chat Window -->
        <div id="chat-window" class="hidden fixed bottom-4 right-4 w-80 bg-white rounded-lg shadow-xl z-50">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Support Chat</h3>
                <button onclick="toggleChat()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="chat-messages" class="p-4 h-96 overflow-y-auto space-y-4">
                <!-- Messages will be inserted here -->
            </div>
            <div class="p-4 border-t">
                <form id="chat-form" class="flex space-x-2">
                    @csrf
                    <input type="text" id="message-input" name="message" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="Type your message..." required>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="mt-auto py-4 px-6 bg-gradient-to-r from-[#3A0CA3]/10 to-[#4361EE]/10 border-t border-[#7209B7]/20">
            <div class="text-center text-sm text-gray-600">
                © 2025 AdLinker. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu removed - using inline navigation
    
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
    
    // Mobile menu dropdown functionality
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenuDropdown = document.querySelector('.mobile-menu-dropdown');
    
    if (mobileMenuButton && mobileMenuDropdown) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenuDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!mobileMenuButton.contains(event.target) && !mobileMenuDropdown.contains(event.target)) {
                mobileMenuDropdown.classList.add('hidden');
            }
        });
    }

    // Chat functionality
    function toggleChat() {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            loadMessages();
            markMessagesAsRead();
        }
    }

    function loadMessages() {
        fetch('{{ route('chat.messages') }}')
            .then(response => response.json())
            .then(messages => {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.innerHTML = '';
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.className = message.is_admin_message ? 
                        'flex justify-start' : 'flex justify-end';
                    messageElement.innerHTML = `
                        <div class="${message.is_admin_message ? 
                            'bg-gray-100 text-gray-800' : 
                            'bg-blue-600 text-white'} rounded-lg px-4 py-2 max-w-[80%]">
                            <p class="text-sm">${message.message}</p>
                            <p class="text-xs opacity-75 mt-1">${new Date(message.created_at).toLocaleTimeString()}</p>
                            ${message.admin_reply ? `<div class='mt-2 p-2 bg-yellow-100 text-yellow-800 rounded text-xs'>Admin reply: ${message.admin_reply}</div>` : ''}
                        </div>
                    `;
                    chatMessages.appendChild(messageElement);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
    }

    function markMessagesAsRead() {
        fetch('{{ route('chat.mark-as-read') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }

    function sendMessage() {
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        
        if (message) {
            fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            })
            .then(response => response.json())
            .then(() => {
                input.value = '';
                loadMessages();
            });
        }
    }

    // Add event listener for Enter key
    document.getElementById('message-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Add event listener for chat form submission to use AJAX
    const chatForm = document.getElementById('chat-form');
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });
    }
</script>


</body>
</html>
