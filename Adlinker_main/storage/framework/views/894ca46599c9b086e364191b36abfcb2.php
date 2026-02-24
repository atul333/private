<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
  <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center shrink-0">
      <div class="flex items-center">
        <a href="<?php echo e(route('platform.selection')); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span></span>
        </a>
        <h1 class="text-lg font-bold text-gray-800"><?php echo e(__('Instagram Publisher Dashboard')); ?></h1>
      </div>
      <div>
        <a href="<?php echo e(route('instagram.publisher.profile.create', ['user' => auth()->id()])); ?>" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add New Profile
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
      <div class="grid grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold text-gray-900">Active Profiles</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e($profiles->where('is_active', true)->count()); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#F72585]/20 to-[#B5179E]/20 rounded-xl p-4 text-[#B5179E] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#F72585]/30 hover:border-[#F72585]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold text-gray-900">Total Earnings</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900">₹<?php echo e(number_format($totalEarnings, 2)); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#3A0CA3]/20 to-[#4361EE]/20 rounded-xl p-4 text-[#3A0CA3] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#3A0CA3]/30 hover:border-[#3A0CA3]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Total Followers</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e(number_format($profiles->sum('followers'))); ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Scrollable Content Section -->
    <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
      <!-- Profile Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <!-- Profile Card -->
          <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
            <div class="relative border-b border-gray-100">
              <div class="absolute top-3 right-3">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full border 
                  <?php if($profile->status === 'active'): ?> bg-green-100 text-green-800 border-green-300
                  <?php elseif($profile->status === 'moderation'): ?> bg-yellow-100 text-yellow-800 border-yellow-300
                  <?php else: ?> bg-red-100 text-red-800 border-red-300
                  <?php endif; ?>">
                  <?php echo e(ucfirst($profile->status)); ?>

                </span>
              </div>
              <div class="p-4">
                <div class="flex items-center space-x-3 mb-3 border-b border-gray-200 pb-3">
                  <?php if($profile->profile_photo): ?>
                    <img src="<?php echo e(asset('storage/' . $profile->profile_photo)); ?>" alt="<?php echo e($profile->instagram_id); ?>" class="h-12 w-12 rounded-full object-cover border border-blue-900 shadow-sm">
                  <?php else: ?>
                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  <?php endif; ?>
                  <div>
                    <h3 class="text-sm font-semibold text-gray-900"><?php echo e('@' . $profile->instagram_id); ?></h3>
                    <div class="flex items-center mt-1">
                      <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span class="text-xs text-gray-900"><?php echo e(number_format($profile->followers)); ?> Followers</span>
                    </div>
                  </div>
                </div>

                <div class="border-t border-gray-50 pt-3">
                  <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-gray-900">Price per Story</span>
                    <span class="text-xs font-semibold text-gray-900">₹<?php echo e(number_format($profile->price_per_story, 2)); ?></span>
                  </div>

                  <div class="flex items-center justify-between space-x-2">
                    <div class="flex space-x-2">
                      <a href="<?php echo e(route('instagram.publisher.profile.edit', ['user' => auth()->id(), 'profile' => $profile])); ?>" class="inline-flex items-center px-3 py-1.5 border border-[#B5179E] shadow-sm text-xs font-medium rounded-md bg-[#B5179E]/10 text-[#B5179E] hover:bg-[#B5179E]/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B5179E]">Edit</a>
                    </div>
                    <a href="<?php echo e(route('instagram.publisher.profile.campaigns', ['user' => auth()->id(), 'profile' => $profile])); ?>" class="inline-flex items-center text-xs px-3 py-1.5 rounded-md bg-[#4361EE]/10 text-[#3A0CA3] hover:bg-[#4361EE]/20 border border-[#4361EE]">
                      Campaigns
                      <?php if($profile->campaigns->count() > 0): ?>
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-[#4361EE]/20"><?php echo e($profile->campaigns->count()); ?></span>
                      <?php endif; ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-span-3">
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-400">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900">No profiles found</h3>
              <p class="mt-1 text-xs text-gray-500">Get started by creating a new Instagram profile.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-6 w-full overflow-x-auto pb-4">
        <div class="min-w-full flex justify-center">
          <?php echo e($profiles->links('pagination::tailwind')); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/instagram/publisher/dashboard.blade.php ENDPATH**/ ?>