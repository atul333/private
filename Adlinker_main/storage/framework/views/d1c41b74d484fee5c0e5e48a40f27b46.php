<?php $__env->startSection('title', 'Select Platform'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 py-6 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900">
                Choose Your <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Platform</span>
            </h1>
            <p class="text-sm text-gray-500 mt-1">Select a platform to manage your campaigns</p>
        </div>

        <!-- Platforms Grid — 2 columns on mobile, 4 on md -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

            <!-- Telegram -->
            <form action="<?php echo e(route('platform.select')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="platform" value="telegram">
                <button type="submit" class="w-full group">
                    <div class="relative bg-white rounded-xl shadow hover:shadow-md transition-all duration-200 border-2 border-transparent hover:border-blue-400 p-4 text-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl"></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 mx-auto mb-2 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Telegram</h3>
                            <p class="text-xs text-gray-500 mt-0.5 mb-2 leading-tight">Channel ads</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span>Active
                            </span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- Instagram -->
            <form action="<?php echo e(route('platform.select')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="platform" value="instagram">
                <button type="submit" class="w-full group">
                    <div class="relative bg-white rounded-xl shadow hover:shadow-md transition-all duration-200 border-2 border-transparent hover:border-pink-400 p-4 text-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-50 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-xl"></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 mx-auto mb-2 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-xl flex items-center justify-center shadow group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Instagram</h3>
                            <p class="text-xs text-gray-500 mt-0.5 mb-2 leading-tight">Story ads</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span>Active
                            </span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- Facebook -->
            <form action="<?php echo e(route('platform.select')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="platform" value="facebook">
                <button type="submit" class="w-full cursor-not-allowed" disabled>
                    <div class="relative bg-white rounded-xl shadow border-2 border-gray-200 p-4 text-center opacity-60">
                        <div class="relative z-10">
                            <div class="w-12 h-12 mx-auto mb-2 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Facebook</h3>
                            <p class="text-xs text-gray-500 mt-0.5 mb-2 leading-tight">FB ads</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Soon
                            </span>
                        </div>
                    </div>
                </button>
            </form>

            <!-- YouTube -->
            <form action="<?php echo e(route('platform.select')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="platform" value="youtube">
                <button type="submit" class="w-full cursor-not-allowed" disabled>
                    <div class="relative bg-white rounded-xl shadow border-2 border-gray-200 p-4 text-center opacity-60">
                        <div class="relative z-10">
                            <div class="w-12 h-12 mx-auto mb-2 bg-gradient-to-br from-red-500 to-red-700 rounded-xl flex items-center justify-center shadow">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">YouTube</h3>
                            <p class="text-xs text-gray-500 mt-0.5 mb-2 leading-tight">YT ads</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Soon
                            </span>
                        </div>
                    </div>
                </button>
            </form>

        </div>

        <!-- Footer Note -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-400">More platforms coming soon. Stay tuned!</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/platform-selection.blade.php ENDPATH**/ ?>