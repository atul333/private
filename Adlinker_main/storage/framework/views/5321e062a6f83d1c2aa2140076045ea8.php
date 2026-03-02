<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20  flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="/<?php echo e(Auth::user()->id); ?>/publisher/dashboard" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-lg font-bold text-black">Channel Details</h1>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('channels.edit', ['user' => Auth::id(), 'channel' => $channel])); ?>" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] border border-transparent rounded-lg shadow-lg text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Channel
                </a>
            </div>
        </div>

        <!-- Scrollable Content Section -->
        <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
            <div class="max-w-4xl mx-auto">
                <!-- Channel Info Card -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-6">
                            <?php if($channel->logo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $channel->logo_path)); ?>" alt="<?php echo e($channel->name); ?> Logo" class="h-16 w-16 rounded-full object-cover border-2 border-[#4361EE] shadow-lg">
                            <?php else: ?>
                                <div class="h-16 w-16 rounded-full bg-[#4361EE]/10 flex items-center justify-center border-2 border-[#4361EE]">
                                    <svg class="h-8 w-8 text-[#4361EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900"><?php echo e($channel->name); ?></h2>
                                <div class="flex items-center mt-1">
                                    <span class="px-2.5 py-1 text-sm font-semibold rounded-full <?php echo e($channel->status === 'active' ? 'bg-[#4CC9F0]/20 text-[#3A0CA3] border border-[#4CC9F0]' : 'bg-[#F72585]/20 text-[#B5179E] border border-[#F72585]'); ?>">
                                        <?php echo e(ucfirst($channel->status)); ?>

                                    </span>
                                    <div class="flex items-center ml-4">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-900"><?php echo e(number_format($channel->subscribers_count)); ?> Subscribers</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <!-- Channel Link -->
                            <div class="bg-[#4CC9F0]/5 rounded-lg p-4 border border-[#4CC9F0]/20">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2">Channel Link</h3>
                                <a href="<?php echo e($channel->link); ?>" target="_blank" class="text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200 break-all"><?php echo e($channel->link); ?></a>
                            </div>

                            <!-- Description -->
                            <div class="bg-[#F72585]/5 rounded-lg p-4 border border-[#F72585]/20">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2">Description</h3>
                                <p class="text-gray-700"><?php echo e($channel->description); ?></p>
                            </div>

                            <!-- Pricing -->
                            <div class="bg-[#7209B7]/5 rounded-lg p-4 border border-[#7209B7]/20">
                                <h3 class="text-sm font-semibold text-gray-900 mb-4">Pricing</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-4 text-center border border-[#4895EF]/30">
                                        <span class="text-sm text-gray-600">1 Day</span>
                                        <p class="text-lg font-bold text-[#3A0CA3] mt-1">₹<?php echo e(number_format($channel->price_1_day, 2)); ?></p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-4 text-center border border-[#4895EF]/30">
                                        <span class="text-sm text-gray-600">2 Days</span>
                                        <p class="text-lg font-bold text-[#3A0CA3] mt-1">₹<?php echo e(number_format($channel->price_2_days, 2)); ?></p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-4 text-center border border-[#4895EF]/30">
                                        <span class="text-sm text-gray-600">3 Days</span>
                                        <p class="text-lg font-bold text-[#3A0CA3] mt-1">₹<?php echo e(number_format($channel->price_3_days, 2)); ?></p>
                                    </div>
                                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-4 text-center border border-[#4895EF]/30">
                                        <span class="text-sm text-gray-600">7 Days</span>
                                        <p class="text-lg font-bold text-[#3A0CA3] mt-1">₹<?php echo e(number_format($channel->price_7_days, 2)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/channels/show.blade.php ENDPATH**/ ?>