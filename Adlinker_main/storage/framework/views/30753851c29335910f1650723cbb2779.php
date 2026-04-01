<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SocialAdLinker - Social Media Ads Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="antialiased bg-gray-50">
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600">SocialAdLinker</span>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role === 'advertiser'): ?>
                            <a href="/advertiser/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        <?php elseif(Auth::user()->role === 'publisher'): ?>
                            <a href="/<?php echo e(Auth::user()->id); ?>/publisher/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 px-4 py-2">Log in</a>
                        <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Sign up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-b from-blue-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl leading-tight">
                            Amplify Your Reach on <span class="text-blue-600">Social Media</span>
                        </h1>
                        <p class="mt-6 text-xl text-gray-500 leading-relaxed">
                            Connect with millions of engaged users through targeted advertising on Telegram & Instagram. Launch successful campaigns that drive real results.
                        </p>
                        <div class="mt-10 sm:flex sm:justify-center lg:justify-start space-x-4">
                            <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-300 shadow-lg hover:shadow-xl">
                                Start Advertising
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#features" class="inline-flex items-center px-8 py-4 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                                Learn More
                            </a>
                        </div>
                    </div>
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-lg shadow-lg overflow-hidden">
                            <div class="relative block w-full bg-white pt-16 pb-20 px-6 sm:pt-20 sm:pb-24 lg:pb-28 rounded-lg">
                                <div class="space-y-8">
                                    <div class="flex items-center space-x-4 bg-blue-50 p-4 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-chart-line text-2xl text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">Real-time Analytics</h3>
                                            <p class="mt-1 text-sm text-gray-500">Track your campaign performance live</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 bg-green-50 p-4 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-users text-2xl text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">Targeted Reach</h3>
                                            <p class="mt-1 text-sm text-gray-500">Connect with your ideal audience</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 bg-purple-50 p-4 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-rocket text-2xl text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">Quick Launch</h3>
                                            <p class="mt-1 text-sm text-gray-500">Go live in minutes, not days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="mt-20 grid grid-cols-2 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php
                        $stats = app(\App\Http\Controllers\StatisticsController::class)->getStatistics();
                        $stats = json_decode($stats->getContent());
                    ?>
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg transform transition duration-300 hover:scale-105">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-5xl font-extrabold text-blue-600 mb-4"><?php echo e(number_format($stats->total_channels)); ?></dt>
                            <dd class="text-lg font-medium text-gray-600">Telegram Channels</dd>
                            <p class="mt-2 text-sm text-gray-500">Active and growing network</p>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg transform transition duration-300 hover:scale-105">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-5xl font-extrabold mb-4" style="background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo e(number_format($stats->total_instagram_profiles)); ?></dt>
                            <dd class="text-lg font-medium text-gray-600">Instagram Pages</dd>
                            <p class="mt-2 text-sm text-gray-500">Active creator profiles</p>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg transform transition duration-300 hover:scale-105">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-5xl font-extrabold text-blue-600 mb-4"><?php echo e(number_format($stats->active_advertisers)); ?></dt>
                            <dd class="text-lg font-medium text-gray-600">Active Advertisers</dd>
                            <p class="mt-2 text-sm text-gray-500">Trust our platform</p>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg transform transition duration-300 hover:scale-105">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <dt class="text-5xl font-extrabold text-blue-600 mb-4"><?php echo e(number_format($stats->active_publishers)); ?></dt>
                            <dd class="text-lg font-medium text-gray-600">Active Publishers</dd>
                            <p class="mt-2 text-sm text-gray-500">Active community</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why Choose AdLinker?</h2>
                    <p class="mt-4 text-xl text-gray-600">Everything you need to succeed in social media advertising</p>
                </div>

                <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative p-6 bg-white rounded-lg">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                <i class="fas fa-bullseye text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Precise Targeting</h3>
                            <p class="mt-4 text-base text-gray-500">Reach your ideal audience with advanced targeting options based on interests, demographics, and behavior.</p>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative p-6 bg-white rounded-lg">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                <i class="fas fa-chart-bar text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Detailed Analytics</h3>
                            <p class="mt-4 text-base text-gray-500">Monitor your campaign performance with real-time analytics and comprehensive reporting tools.</p>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-300"></div>
                        <div class="relative p-6 bg-white rounded-lg">
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Secure Platform</h3>
                            <p class="mt-4 text-base text-gray-500">Your campaigns and data are protected with enterprise-grade security measures.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-600">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Ready to grow your reach?</span>
                    <span class="block text-blue-200">Start your campaign today.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 transition duration-300">
                            Get started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Company Info & Contact -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Contact Us</h3>
                    <div class="text-gray-400 space-y-2">
                        <p><i class="fas fa-envelope mr-2"></i>socialadlinker@gmail.com</p>
                        <p><i class="fas fa-phone mr-2"></i>+91 8329707239</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Yashraj meadows, sector 20, Airoli, Navi mumbai, 400708</p>
                    </div>
                </div>

                <!-- Policies Column 1 -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Legal</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><a href="/terms" class="hover:text-white transition duration-150">Terms & Conditions</a></li>
                        <li><a href="/privacy" class="hover:text-white transition duration-150">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Policies Column 2 -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Policies</h3>
                    <ul class="text-gray-400 space-y-2">
                        <li><a href="/refund" class="hover:text-white transition duration-150">Refund Policy</a>
                            <p class="text-sm text-gray-500 mt-1">7-day refund window for unused credits</p>
                        </li>
                        <li><a href="/cancellation" class="hover:text-white transition duration-150">Cancellation Policy</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-telegram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-150"><i class="fab fa-linkedin text-xl"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <p class="text-center text-base text-gray-400">&copy; <?php echo e(date('Y')); ?> AdLinker. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/welcome.blade.php ENDPATH**/ ?>