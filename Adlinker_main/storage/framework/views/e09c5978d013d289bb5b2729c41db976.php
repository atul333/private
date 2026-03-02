<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="<?php echo e(route('instagram.publisher.dashboard', ['user' => auth()->id()])); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200 mr-3">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-sm sm:text-lg font-bold text-gray-800 whitespace-nowrap"><?php echo e('@' . $profile->instagram_id); ?></h1>
                    <p class="text-xs text-gray-600 hidden sm:block"><?php echo e(number_format($profile->followers)); ?> followers • ₹<?php echo e(number_format($profile->price_per_story, 2)); ?> per story</p>
                </div>
            </div>
            <a href="<?php echo e(route('instagram.publisher.profile.edit', ['user' => auth()->id(), 'profile' => $profile->id])); ?>" class="inline-flex items-center gap-1 px-2 py-1.5 sm:px-3 sm:py-1.5 bg-white border border-gray-300 rounded-lg shadow-sm text-xs font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 whitespace-nowrap">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </a>
        </div>

        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="mx-4 mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="ml-3 text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mx-4 mt-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="ml-3 text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Content Section -->
        <div class="px-4 py-4">
            <?php if($campaigns->count() > 0): ?>
                <!-- Campaigns Grid -->
                <div class="grid grid-cols-1 gap-4 mb-4">
                    <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Campaign #<?php echo e($campaign->id); ?></h3>
                                        <p class="text-sm text-gray-500"><?php echo e($campaign->created_at->format('M d, Y')); ?> • <?php echo e($campaign->advertiser->name); ?></p>
                                    </div>
                                    <div class="flex gap-2">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            <?php if($campaign->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                            <?php elseif($campaign->status === 'approved'): ?> bg-green-100 text-green-800 border border-green-200
                                            <?php elseif($campaign->status === 'rejected'): ?> bg-red-100 text-red-800 border border-red-200
                                            <?php else: ?> bg-blue-100 text-blue-800 border border-blue-200
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($campaign->status)); ?>

                                        </span>
                                        <?php if($campaign->paid): ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Paid
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Unpaid
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Media Preview -->
                                    <div class="md:col-span-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="block text-xs font-semibold text-gray-700">Media Content</label>
                                            <a href="<?php echo e(route('instagram.publisher.campaign.download', ['user' => auth()->id(), 'profile' => $profile->id, 'campaign' => $campaign->id])); ?>" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded transition-colors duration-200" title="Download Media">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                        <div class="bg-gray-100 rounded-lg p-2 flex items-center justify-center" style="min-height: 150px;">
                                            <?php if($campaign->media_type === 'image'): ?>
                                                <img src="<?php echo e(asset('storage/' . $campaign->media_file)); ?>" class="max-h-40 rounded shadow-sm object-cover">
                                            <?php else: ?>
                                                <video controls class="max-h-40 rounded shadow-sm">
                                                    <source src="<?php echo e(asset('storage/' . $campaign->media_file)); ?>" type="video/mp4">
                                                </video>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 text-center">
                                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <?php if($campaign->media_type === 'video'): ?>
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                                <?php else: ?>
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                <?php endif; ?>
                                            </svg>
                                            <?php echo e(ucfirst($campaign->media_type)); ?>

                                        </p>
                                    </div>

                                    <!-- Campaign Details -->
                                    <div class="md:col-span-2 space-y-3">
                                        <!-- Advertisement Link Text -->
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Advertisement Link Text</label>
                                            <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-700 flex items-center justify-between">
                                                <span id="linkText<?php echo e($campaign->id); ?>"><?php echo e($campaign->link_text); ?></span>
                                                <button onclick="copyToClipboard('linkText<?php echo e($campaign->id); ?>', this)" class="ml-2 p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors duration-200" title="Copy to clipboard">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Advertisement Link -->
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Advertisement Link</label>
                                            <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center justify-between">
                                                <a href="<?php echo e($campaign->link_url); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-800 underline break-all flex-1" id="linkUrl<?php echo e($campaign->id); ?>">
                                                    <?php echo e($campaign->link_url); ?>

                                                </a>
                                                <button onclick="copyToClipboard('linkUrl<?php echo e($campaign->id); ?>', this)" class="ml-2 p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors duration-200 flex-shrink-0" title="Copy to clipboard">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">

                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700 mb-1">Price</label>
                                                <p class="text-lg font-bold text-green-600">₹<?php echo e(number_format($campaign->price, 2)); ?></p>
                                            </div>
                                        </div>

                                        <?php if($campaign->status === 'pending' && $campaign->paid): ?>
                                            <?php
                                                $approvalDeadline = $campaign->created_at->copy()->addHours(24);
                                                $now = now();
                                                $approvalRemaining = max(0, $now->diffInSeconds($approvalDeadline, false));
                                            ?>
                                            
                                            <div class="pt-3 border-t border-orange-200 mt-3 bg-orange-50 rounded-lg p-3">
                                                <p class="text-xs font-semibold text-orange-800 mb-2">⏳ Approve or Reject within:</p>
                                                <div class="flex items-center justify-center gap-2 text-center approval-countdown" data-approval-seconds="<?php echo e($approvalRemaining); ?>" data-campaign-id="<?php echo e($campaign->id); ?>">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-hours"><?php echo e(str_pad(floor($approvalRemaining / 3600), 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Hours</div>
                                                    </div>
                                                    <div class="text-xl font-bold text-orange-600">:</div>
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-minutes"><?php echo e(str_pad(floor(($approvalRemaining % 3600) / 60), 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Minutes</div>
                                                    </div>
                                                    <div class="text-xl font-bold text-orange-600">:</div>
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-seconds"><?php echo e(str_pad($approvalRemaining % 60, 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Seconds</div>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-orange-700 mt-1 text-center">If not actioned, campaign expires & advertiser is refunded.</p>
                                            </div>
                                            
                                            <div class="flex gap-2 pt-2">
                                                <form action="<?php echo e(route('instagram.publisher.campaign.reject', ['user' => auth()->id(), 'profile' => $profile->id, 'campaign' => $campaign->id])); ?>" method="POST" class="flex-1" style="z-index: 10; position: relative;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 cursor-pointer">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        Reject
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('instagram.publisher.campaign.approve', ['user' => auth()->id(), 'profile' => $profile->id, 'campaign' => $campaign->id])); ?>" method="POST" class="flex-1" style="z-index: 10; position: relative;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 cursor-pointer">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        Approve & Publish
                                                    </button>
                                                </form>
                                            </div>
                                        <?php elseif($campaign->status === 'approved'): ?>
                                            <?php
                                                // Same 24h deadline from created_at — continues from where approval happened
                                                $approvalDeadline  = $campaign->created_at->copy()->addHours(24);
                                                $now               = now();
                                                $approvalRemaining = max(0, $now->diffInSeconds($approvalDeadline, false));
                                            ?>
                                            <!-- Countdown continues from approval — time left to submit story link -->
                                            <div class="pt-3 border-t border-orange-200 mt-3 bg-orange-50 rounded-lg p-3">
                                                <p class="text-xs font-semibold text-orange-800 mb-2">⏳ Submit story link within:</p>
                                                <div class="flex items-center justify-center gap-2 text-center approval-countdown" data-approval-seconds="<?php echo e($approvalRemaining); ?>" data-campaign-id="<?php echo e($campaign->id); ?>">
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-hours"><?php echo e(str_pad(floor($approvalRemaining / 3600), 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Hours</div>
                                                    </div>
                                                    <div class="text-xl font-bold text-orange-600">:</div>
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-minutes"><?php echo e(str_pad(floor(($approvalRemaining % 3600) / 60), 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Minutes</div>
                                                    </div>
                                                    <div class="text-xl font-bold text-orange-600">:</div>
                                                    <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                        <div class="text-xl font-bold text-orange-600 approval-seconds"><?php echo e(str_pad($approvalRemaining % 60, 2, '0', STR_PAD_LEFT)); ?></div>
                                                        <div class="text-xs text-gray-500">Seconds</div>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-orange-700 mt-1 text-center">If not submitted in time, campaign expires & advertiser is refunded.</p>
                                            </div>
                                            <!-- Story Link Submission Form -->
                                            <div class="pt-3 border-t border-gray-200 mt-3">
                                                <form action="<?php echo e(route('instagram.publisher.campaign.submit-story', ['user' => auth()->id(), 'profile' => $profile->id, 'campaign' => $campaign->id])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <label class="block text-xs font-semibold text-gray-700 mb-2">Submit Story Link</label>
                                                    <div class="flex gap-2">
                                                        <input type="url" name="story_link" placeholder="https://instagram.com/stories/..." required class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">Submit</button>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Paste the Instagram story link here to start the 24-hour completion timer</p>
                                                </form>
                                            </div>
                                        <?php elseif($campaign->status === 'published'): ?>
                                            <!-- Story published countdown -->
                                            <div class="pt-3 border-t border-gray-200 mt-3">
                                                <?php
                                                    $publishedAt = $campaign->published_at;
                                                    $completionTime = $publishedAt->copy()->addHours(24);
                                                    $now = now();
                                                    $remainingSeconds = max(0, $now->diffInSeconds($completionTime, false));
                                                    $isCompleted = $remainingSeconds <= 0;
                                                ?>
                                                <?php if($isCompleted): ?>
                                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                        <p class="text-sm font-semibold text-green-800 flex items-center">
                                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                            Campaign Completed!
                                                        </p>
                                                        <p class="text-xs text-green-700 mt-1">Payment will be processed shortly</p>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                        <p class="text-xs font-semibold text-blue-800 mb-2">Story Published - Time Remaining:</p>
                                                        <div class="flex items-center justify-center gap-2 text-center" data-countdown="<?php echo e($remainingSeconds); ?>" data-campaign-id="<?php echo e($campaign->id); ?>">
                                                            <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                                <div class="text-2xl font-bold text-blue-600 countdown-hours"><?php echo e(str_pad(floor($remainingSeconds / 3600), 2, '0', STR_PAD_LEFT)); ?></div>
                                                                <div class="text-xs text-gray-500">Hours</div>
                                                            </div>
                                                            <div class="text-2xl font-bold text-blue-600">:</div>
                                                            <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                                <div class="text-2xl font-bold text-blue-600 countdown-minutes"><?php echo e(str_pad(floor(($remainingSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT)); ?></div>
                                                                <div class="text-xs text-gray-500">Minutes</div>
                                                            </div>
                                                            <div class="text-2xl font-bold text-blue-600">:</div>
                                                            <div class="bg-white rounded-lg px-3 py-2 shadow-sm">
                                                                <div class="text-2xl font-bold text-blue-600 countdown-seconds"><?php echo e(str_pad($remainingSeconds % 60, 2, '0', STR_PAD_LEFT)); ?></div>
                                                                <div class="text-xs text-gray-500">Seconds</div>
                                                            </div>
                                                        </div>
                                                        <p class="text-xs text-blue-700 mt-2 text-center">
                                                            <a href="<?php echo e($campaign->story_link); ?>" target="_blank" class="underline hover:text-blue-900">View Story</a>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php elseif($campaign->status === 'completed'): ?>
                                            <div class="pt-3">
                                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-green-800">✓ Campaign Completed</p>
                                                    <p class="text-xs text-green-700 mt-1">Payment received: ₹<?php echo e(number_format($campaign->price, 2)); ?></p>
                                                </div>
                                            </div>
                                        <?php elseif($campaign->status === 'expired'): ?>
                                            <div class="pt-3">
                                                <div class="bg-gray-50 border border-gray-300 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-gray-700">⏰ Campaign Expired</p>
                                                    <p class="text-xs text-gray-500 mt-1">You did not approve or reject within 24 hours. The advertiser was refunded.</p>
                                                </div>
                                            </div>
                                        <?php elseif($campaign->status === 'rejected'): ?>
                                            <div class="pt-3">
                                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-red-700">✗ Campaign Rejected</p>
                                                    <p class="text-xs text-red-600 mt-1">Advertiser has been refunded ₹<?php echo e(number_format($campaign->price, 2)); ?></p>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-xs text-gray-600 pt-2">Status: <?php echo e(ucfirst($campaign->status)); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#4895EF]/10">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-medium text-gray-900"><?php echo e($campaigns->firstItem() ?? 0); ?></span> to
                        <span class="font-medium text-gray-900"><?php echo e($campaigns->lastItem() ?? 0); ?></span> of
                        <span class="font-medium text-gray-900"><?php echo e($campaigns->total()); ?></span> results
                    </p>

                    <div class="flex items-center gap-2">
                        <?php if($campaigns->onFirstPage()): ?>
                            <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">Previous</span>
                        <?php else: ?>
                            <a href="<?php echo e($campaigns->previousPageUrl()); ?>" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">Previous</a>
                        <?php endif; ?>

                        <?php if($campaigns->hasMorePages()): ?>
                            <a href="<?php echo e($campaigns->nextPageUrl()); ?>" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] rounded-lg hover:from-[#3F37C9] hover:to-[#4895EF] transition-all duration-200 shadow-sm hover:shadow">Next</a>
                        <?php else: ?>
                            <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">Next</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- No Campaigns -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-[#4895EF]/30 p-12 text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No campaigns for this profile yet</h3>
                    <p class="text-gray-500">Campaign requests will appear here when advertisers select your profile</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ── Published story countdown (blue) ──────────────────────────────────────
    document.querySelectorAll('[data-countdown]').forEach(function(element) {
        let remaining = parseInt(element.getAttribute('data-countdown'));
        const interval = setInterval(function() {
            if (remaining <= 0) { clearInterval(interval); window.location.reload(); return; }
            remaining--;
            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;
            const hoursEl   = element.querySelector('.countdown-hours');
            const minutesEl = element.querySelector('.countdown-minutes');
            const secondsEl = element.querySelector('.countdown-seconds');
            if (hoursEl)   hoursEl.textContent   = String(h).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
        }, 1000);
    });

    // ── Approval countdown (orange) — 24h to approve/reject ──────────────────
    document.querySelectorAll('.approval-countdown').forEach(function(element) {
        let remaining = parseInt(element.getAttribute('data-approval-seconds'));
        const interval = setInterval(function() {
            if (remaining <= 0) {
                clearInterval(interval);
                // Replace the whole card to show expired message without a reload race
                const card = element.closest('.pt-3');
                if (card) {
                    card.innerHTML = '<div class="bg-gray-50 border border-gray-300 rounded-lg p-3"><p class="text-sm font-semibold text-gray-700">⏰ Campaign Expired</p><p class="text-xs text-gray-500 mt-1">Time is up. Refreshing…</p></div>';
                }
                setTimeout(() => window.location.reload(), 1500);
                return;
            }
            remaining--;
            const h = Math.floor(remaining / 3600);
            const m = Math.floor((remaining % 3600) / 60);
            const s = remaining % 60;
            const hoursEl   = element.querySelector('.approval-hours');
            const minutesEl = element.querySelector('.approval-minutes');
            const secondsEl = element.querySelector('.approval-seconds');
            if (hoursEl)   hoursEl.textContent   = String(h).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
        }, 1000);
    });

});

// Copy to clipboard function
function copyToClipboard(elementId, button) {
    const element = document.getElementById(elementId);
    const text = element.textContent || element.innerText;
    
    // Create a temporary textarea to copy the text
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    
    try {
        document.execCommand('copy');
        
        // Visual feedback - change icon temporarily
        const svg = button.querySelector('svg');
        const originalSVG = svg.innerHTML;
        
        // Show checkmark icon
        svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
        button.classList.add('text-green-600');
        
        // Reset after 2 seconds
        setTimeout(() => {
            svg.innerHTML = originalSVG;
            button.classList.remove('text-green-600');
        }, 2000);
    } catch (err) {
        console.error('Failed to copy text: ', err);
    }
    
    document.body.removeChild(textarea);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/instagram/publisher/profile/campaigns.blade.php ENDPATH**/ ?>