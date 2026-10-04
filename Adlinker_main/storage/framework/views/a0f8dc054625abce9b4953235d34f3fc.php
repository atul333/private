<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'SocialAdLinker')); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js', 'resources/js/countdown.js','resources/sass/app.scss']); ?>
</head>
<body class="bg-gray-50 <?php echo e(in_array(Request::path(), ['login', 'register']) ? 'overflow-hidden' : 'min-h-screen flex flex-col'); ?>">
    <?php
        $balance = '0.00';
        if(Auth::check()) {
            $wallet = \App\Models\Wallet::where('user_id', Auth::id())->first();
            $balance = $wallet ? number_format($wallet->balance, 2) : '0.00';
        }
    ?>
    <div id="app" class="flex flex-col min-h-screen">
        <nav class="bg-white/80 backdrop-blur-sm shadow-sm fixed top-0 left-0 right-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="<?php echo e(url('/')); ?>" class="text-lg font-bold text-blue-600 hover:text-blue-700 transition duration-300">SocialAdLinker</a>
                        </div>
                    </div>

                    <!-- Mobile navigation -->
                    <div class="flex items-center sm:hidden space-x-2">
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login') && !Request::is('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-200"><?php echo e(__('Login')); ?></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(!Request::is('login') && !Request::is('register')): ?>
                                <!-- Removed FAQ button -->
                            <?php endif; ?>
                            <?php if(Auth::check()): ?>
                                <a href="<?php echo e(auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet')); ?>" class="flex items-center space-x-1 bg-white hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg shadow-sm border border-gray-200 transition-all duration-200">
                                    <i class="fas fa-wallet text-blue-500"></i>
                                    <span class="font-medium">₹<?php echo e($balance); ?></span>
                                </a>
                                <div class="relative">
                                    <button type="button" class="mobile-menu-button text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center">
                                        <span><?php echo e(Auth::user()->name); ?></span>
                                        <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div class="mobile-menu-dropdown hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white/90 backdrop-blur-sm ring-1 ring-black ring-opacity-5 z-50">
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200" onclick="document.getElementById('logout-form').submit();">
                                            <?php echo e(__('Logout')); ?>

                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="flex space-x-4">
                            <?php if(!Request::is('login') && !Request::is('register')): ?>
                             
                                <!-- Removed FAQ button and link -->
                            <?php endif; ?>

                        <!-- Authentication Links -->
                            <?php if(auth()->guard()->guest()): ?>
                            <?php else: ?>
                                <?php if(Auth::check()): ?>
                                    <div class="relative group">
                                        <a href="<?php echo e(auth()->user()->role === 'publisher' ? url('/' . auth()->user()->id . '/publisher/wallet') : url('/' . auth()->user()->id . '/advertiser/wallet')); ?>" class="flex items-center space-x-1 bg-white hover:bg-gray-50 text-gray-700 px-2 py-1.5 rounded-lg shadow-sm border border-gray-200 transition-all duration-200">
                                            <i class="fas fa-wallet text-blue-500 text-sm"></i>
                                            <span class="font-medium text-sm">₹<?php echo e($balance); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="ml-3 relative group">
                                    <div>
                                        <button type="button" class="bg-white/90 backdrop-blur-sm rounded-lg flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:bg-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <span class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium"><?php echo e(Auth::user()->name); ?></span>
                                            <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                
                                    <div class="hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg py-1 bg-white/90 backdrop-blur-sm ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu-dropdown" style="pointer-events: auto;">
                                        <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors duration-200" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="document.getElementById('logout-form').submit();">
                                            <?php echo e(__('Logout')); ?>

                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu placeholder for spacing -->
            <div class="sm:hidden h-0"></div>
        </nav>

        <main class="w-full <?php echo e(in_array(Request::path(), ['login', 'register']) ? 'h-screen flex items-center justify-center' : 'max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12 flex-1 overflow-y-auto py-4'); ?>">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Contact Support Button -->
        <div class="fixed bottom-20 right-5 z-50">
            <button onclick="toggleFAQ()" class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] text-white rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </button>
        </div>

        <!-- Telegram Contact Button -->
        <div class="fixed bottom-5 right-5 z-50">
            <a href="https://t.me/SocialAdLinker_Admin" target="_blank" class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-[#0088cc] to-[#0099ff] text-white rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                <i class="fab fa-telegram-plane text-xl"></i>
            </a>
        </div>

         



        <!-- FAQ Window -->
        <div id="faq-window" class="hidden fixed bottom-32 right-5 w-80 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl z-50 transform transition-all duration-300 ease-in-out max-h-[80vh] overflow-y-auto">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] bg-clip-text text-transparent">Frequently Asked Questions</h3>
                <button onclick="toggleFAQ()" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 h-[400px] overflow-y-auto space-y-4 custom-scrollbar">
                <div class="space-y-3">
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">What is AdLinker?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>AdLinker is a platform that connects advertisers with publishers to facilitate effective advertising campaigns on Telegram channels. We provide a seamless marketplace for Telegram advertising, helping businesses reach their target audience and channel owners monetize their content.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How do I get started?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>Sign up as either an advertiser or publisher, complete your profile, and start using our platform. Advertisers can create campaigns and browse channels, while publishers can list their channels and start receiving ad requests.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How does payment work?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>We use secure payment processing through RazorPay. Advertisers can add funds to their wallet using various payment methods, and publishers receive automatic payments for successful ad placements through our platform.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">What types of ads are supported?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>AdLinker supports various ad formats suitable for Telegram channels, including text posts, media posts (images/videos), and pinned messages. Each format can be customized to meet your campaign objectives.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How are ad prices determined?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>Ad prices are set by channel owners based on factors like subscriber count, engagement rates, and content niche. We provide pricing guidelines to ensure fair market rates while allowing flexibility for premium placements.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How do I track ad performance?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>Our platform provides detailed analytics including views. You can track campaign performance in real-time through your dashboard and generate comprehensive reports.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>You can target your ads based on channel categories, audience demographics, language, and geographic location. Our platform helps match your ads with channels that best reach your target audience.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How long does ad approval take?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>Ad approval typically takes 24 hours. Publishers review ads to ensure they meet channel guidelines. Once approved, ads are scheduled according to your campaign settings.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">Is there a minimum budget requirement?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>There's no strict minimum budget requirement. You can start advertising with any amount, though effectiveness may vary based on your target channels and campaign goals.</p>
                        </div>
                    </div>
                    <div class="faq-item rounded-lg overflow-hidden bg-white/50 hover:bg-white/80 transition-colors duration-200 shadow-sm">
                        <button class="w-full px-4 py-3 text-left flex justify-between items-center group" onclick="toggleAnswer(this)">
                            <span class="font-medium text-gray-800 group-hover:text-[#4361EE] transition-colors duration-200">How do you ensure ad quality?</span>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-[#4361EE] transform transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer hidden px-4 py-3 text-gray-600 border-t border-gray-50">
                            <p>We have content guidelines and review processes to ensure ads meet quality standards. Publishers can also review and approve ads before posting, maintaining their channel's integrity.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center space-y-3 border-t border-gray-100 pt-4">
                    <p class="text-gray-600">Still have questions?</p>
                    <a href="https://t.me/SocialAdLinker_Admin" target="_blank" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] text-white rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fab fa-telegram-plane mr-2"></i>
                        <span class="font-medium">Contact Support</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
    function toggleFAQ() {
        const faqWindow = document.getElementById('faq-window');
        faqWindow.classList.toggle('hidden');
        faqWindow.classList.toggle('translate-y-4');
        faqWindow.classList.toggle('opacity-0');
        
        if (!faqWindow.classList.contains('hidden')) {
            setTimeout(() => {
                faqWindow.classList.remove('translate-y-4', 'opacity-0');
            }, 10);
        }
    }

    function toggleAnswer(button) {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.fa-chevron-down');
        const allAnswers = document.querySelectorAll('.faq-answer');
        const allIcons = document.querySelectorAll('.fa-chevron-down');
        
        // Close other answers
        allAnswers.forEach(item => {
            if (item !== answer && !item.classList.contains('hidden')) {
                item.classList.add('hidden');
            }
        });
        
        allIcons.forEach(item => {
            if (item !== icon && item.classList.contains('rotate-180')) {
                item.classList.remove('rotate-180');
            }
        });

        // Toggle current answer
        answer.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    function toggleChat() {
        const faqModal = document.getElementById('faq-modal');
        const chatWindow = document.getElementById('chat-window');
        faqModal.classList.add('hidden');
        chatWindow.classList.toggle('hidden');
    }

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
        const faqModal = document.getElementById('faq-modal');
        const chatWindow = document.getElementById('chat-window');
        
        // If FAQ modal is hidden, show it first
        if (faqModal.classList.contains('hidden')) {
            faqModal.classList.remove('hidden');
            chatWindow.classList.add('hidden');
        } else {
            // If FAQ modal is visible and user clicks contact support
            faqModal.classList.add('hidden');
            chatWindow.classList.toggle('hidden');
        }
        if (!chatWindow.classList.contains('hidden')) {
            loadMessages();
            markMessagesAsRead();
        }
    }
        
        // If FAQ modal is hidden, show it first
        if (faqModal.classList.contains('hidden')) {
            faqModal.classList.remove('hidden');
            chatWindow.classList.add('hidden');
        } else {
            // If FAQ modal is visible and user clicks contact support
            faqModal.classList.add('hidden');
            chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            loadMessages();
            markMessagesAsRead();
        }
    }

    function loadMessages() {
        fetch('<?php echo e(route('chat.messages')); ?>')
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
        fetch('<?php echo e(route('chat.mark-as-read')); ?>', {
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
            fetch('<?php echo e(route('chat.send')); ?>', {
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
<?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/layouts/app.blade.php ENDPATH**/ ?>