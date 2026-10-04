<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
  <div class="flex-1 flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center shrink-0">
      <div class="flex items-center">
        <a href="<?php echo e(url()->previous()); ?>" class="mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-lg font-bold text-black"><?php echo e(__('Submit Post Link')); ?></h1>
      </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 px-3 sm:px-4 py-4 sm:py-8 pb-28 sm:pb-12 flex items-center justify-center">
      <div class="max-w-2xl w-full">
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden border border-[#0088cc]/20">
          <div class="p-4 sm:p-8">
            <!-- Header Icon -->
            <div class="text-center mb-6 sm:mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gradient-to-r from-[#0088cc]/10 to-[#4361EE]/10 mb-3 sm:mb-4">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-[#0088cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Submit Your Link</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Provide the link to your live post to complete the campaign.</p>
            </div>

            <form method="POST" action="<?php echo e(route('publisher.campaign.submit-link', ['campaign' => $campaign->id])); ?>" class="space-y-6">
              <?php echo csrf_field(); ?>

              <!-- Campaign Info Summary -->
              <div class="mb-6 bg-gradient-to-br from-[#4361EE]/5 to-[#3A0CA3]/5 border border-[#4361EE]/20 rounded-xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                  <h2 class="text-base font-semibold text-gray-900">Campaign #<?php echo e($campaign->id); ?></h2>
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <?php echo e(ucfirst($campaign->status)); ?>

                  </span>
                </div>
                <?php if($campaign->advertisement_content): ?>
                <div class="bg-white/60 p-3 rounded-lg border border-gray-100 mb-3">
                    <p class="text-sm text-gray-700 line-clamp-3"><?php echo e($campaign->advertisement_content); ?></p>
                </div>
                <?php endif; ?>
                <div class="grid grid-cols-2 gap-3 mt-4">
                  <div class="flex items-center justify-center p-3 bg-white/80 rounded-lg border border-gray-100 text-sm font-medium text-gray-700 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-[#4361EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo e($campaign->duration); ?> Days</span>
                  </div>
                  <div class="flex items-center justify-center p-3 bg-white/80 rounded-lg border border-gray-100 text-sm font-bold text-gray-900 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-[#4361EE]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-[#3A0CA3]">₹<?php echo e(number_format($campaign->price, 2)); ?></span>
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label for="post_link" class="block text-sm font-semibold text-gray-900"><?php echo e(__('Post Link')); ?></label>
                <div class="relative rounded-md shadow-sm">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                      </svg>
                  </div>
                  <input id="post_link" 
                         type="url" 
                         class="pl-10 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['post_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                         name="post_link" 
                         value="<?php echo e(old('post_link')); ?>" 
                         placeholder="https://t.me/yourchannel/123"
                         required 
                         autocomplete="post_link" 
                         autofocus>
                </div>
                <p class="mt-2 text-xs text-gray-500">
                  Please enter the link to your post exactly where you've shared the advertisement in your channel.
                </p>
                <?php $__errorArgs = ['post_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>

              <div class="pt-6">
                <button type="submit" class="w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                  <?php echo e(__('Submit Link')); ?>

                  <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/publisher/campaigns/submit-link.blade.php ENDPATH**/ ?>