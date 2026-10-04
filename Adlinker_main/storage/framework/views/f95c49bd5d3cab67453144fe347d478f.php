<?php
use App\Models\Channel;
?>



<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#0088cc]/5 via-[#4361EE]/5 to-[#0099ff]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-2 bg-gradient-to-r from-[#0088cc]/10 to-[#0099ff]/10 border-b border-[#0088cc]/20 flex justify-between items-center min-h-[52px]">
      <div class="flex items-center">
        <a href="<?php echo e(route('platform.selection')); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
        </a>
        <h1 class="text-base sm:text-lg font-bold text-gray-900"><?php echo e(__('Publisher Dashboard')); ?></h1>
      </div>
      <div>
        <a href="<?php echo e(route('channels.create', ['user' => Auth::id()])); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 whitespace-nowrap">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add New Channel
        </a>
      </div>
    </div>

    <!-- Platform Tab Switcher -->
    <div class="px-4 bg-white border-b border-gray-200 shrink-0">
      <div class="flex gap-0">
        <!-- Telegram Tab (Active) -->
        <a href="<?php echo e(url('/'. Auth::id() .'/publisher/dashboard')); ?>"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-[#0088cc] text-[#0088cc] bg-sky-50/70 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
          </svg>
          Telegram
        </a>
        <!-- Instagram Tab -->
        <a href="<?php echo e(route('instagram.publisher.dashboard', ['user' => Auth::id()])); ?>"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-[#E1306C] hover:border-[#E1306C]/40 hover:bg-pink-50/40 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
          Instagram
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/40 backdrop-blur-sm px-4 py-3 border-b border-[#0088cc]/10 shrink-0">
      <div class="grid grid-cols-3 gap-3 sm:gap-4">
        <!-- Metrics cards -->
        <div class="bg-gradient-to-br from-[#0088cc]/15 to-[#0099ff]/15 rounded-xl p-3 sm:p-4 text-[#0077b5] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#0088cc]/30 hover:border-[#0088cc]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Active Channels</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900"><?php echo e($activeChannels); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#4361EE]/15 to-[#3A0CA3]/15 rounded-xl p-3 sm:p-4 text-[#4361EE] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#4361EE]/30 hover:border-[#4361EE]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Total Earnings</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900">₹<?php echo e(number_format($totalEarnings, 2)); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#0284c7]/15 to-[#0369a1]/15 rounded-xl p-3 sm:p-4 text-[#0284c7] shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300 border border-[#0284c7]/30 hover:border-[#0284c7]/50">
          <div class="text-center">
            <h3 class="text-xs sm:text-sm font-semibold opacity-90 text-gray-900 leading-tight">Total Subscribers</h3>
            <p class="text-base sm:text-lg font-bold mt-1 sm:mt-2 text-gray-900"><?php echo e(Channel::where('publisher_id', Auth::user()->publisher->id)->sum('subscribers_count')); ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4">
      <!-- Channel Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <!-- Channel Card -->
          <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#0088cc]/20 hover:border-[#0088cc]/40">
            <div class="relative border-b border-gray-100">
              <div class="absolute top-3 right-3">
                <?php if($channel->status === 'moderation'): ?>
                  <div class="flex flex-col items-end">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border bg-amber-50 text-amber-700 border-amber-300">
                      <?php echo e(ucfirst($channel->status)); ?>

                    </span>
                    <span class="text-[11px] text-amber-600 mt-1">Wait 24h for activation</span>
                  </div>
                <?php elseif($channel->status === 'active'): ?>
                  <span class="px-2.5 py-1 text-xs font-semibold rounded-full border bg-green-50 text-green-700 border-green-300">
                    <?php echo e(ucfirst($channel->status)); ?>

                  </span>
                <?php else: ?>
                  <span class="px-2.5 py-1 text-xs font-semibold rounded-full border bg-red-50 text-red-700 border-red-300">
                    <?php echo e(ucfirst($channel->status)); ?>

                  </span>
                <?php endif; ?>
              </div>
              <div class="p-4">
                <div class="flex items-center space-x-3 mb-3 border-b border-gray-100 pb-3">
                  <?php if($channel->logo_path): ?>
                    <img src="<?php echo e(asset('storage/' . $channel->logo_path)); ?>" alt="<?php echo e($channel->name); ?> Logo" class="h-12 w-12 rounded-full object-cover border border-gray-200 shadow-sm">
                  <?php else: ?>
                    <div class="h-12 w-12 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-[#0088cc]">
                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                      </svg>
                    </div>
                  <?php endif; ?>
                  <div>
                    <h3 class="text-base font-semibold text-gray-900"><?php echo e($channel->name); ?></h3>
                    <div class="flex items-center mt-0.5 text-xs text-gray-500">
                      <svg class="h-3.5 w-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span><?php echo e(number_format($channel->subscribers_count)); ?> Subscribers</span>
                    </div>
                  </div>
                </div>

                <div class="pt-2">
                  <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-gray-500">Earnings</span>
                    <span class="text-xs font-semibold text-gray-900">₹<?php echo e(number_format($channel->campaigns->where('status', 'completed')->sum('price') ?? 0, 2)); ?></span>
                  </div>

                  <div class="flex items-center justify-between space-x-2 pt-3 border-t border-gray-100">
                    <a href="<?php echo e(route('channels.edit', ['user' => Auth::id(), 'channel' => $channel])); ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 rounded-lg shadow-sm text-xs font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                      Edit
                    </a>

                    <?php $pendingCount = $channel->campaigns->whereIn('status', ['active', 'pending'])->count(); ?>
                    <a href="<?php echo e(route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel])); ?>" class="inline-flex items-center text-xs px-3.5 py-1.5 rounded-lg bg-[#0088cc]/10 text-[#0088cc] hover:bg-[#0088cc]/20 border border-[#0088cc]/30 font-medium transition-all duration-200">
                      Ad Details
                      <?php if($pendingCount > 0): ?>
                        <span class="ml-2 px-1.5 py-0.5 text-xs rounded-full bg-[#0088cc]/20 text-[#0088cc] font-semibold"><?php echo e($pendingCount); ?></span>
                      <?php endif; ?>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-span-full text-center text-gray-500 py-12">No channels found.</div>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#0088cc]/15">
          <p class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900"><?php echo e($channels->firstItem() ?? 0); ?></span> to
            <span class="font-medium text-gray-900"><?php echo e($channels->lastItem() ?? 0); ?></span> of
            <span class="font-medium text-gray-900"><?php echo e($channels->total()); ?></span> results
          </p>

          <div class="flex items-center gap-2">
            <?php if($channels->onFirstPage()): ?>
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Previous
              </span>
            <?php else: ?>
              <a href="<?php echo e($channels->previousPageUrl()); ?>" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 shadow-sm border border-gray-200">
                Previous
              </a>
            <?php endif; ?>

            <?php if($channels->hasMorePages()): ?>
              <a href="<?php echo e($channels->nextPageUrl()); ?>" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#0088cc] to-[#0099ff] rounded-lg hover:from-[#0077b5] hover:to-[#0088cc] transition-all duration-200 shadow-sm hover:shadow">
                Next
              </a>
            <?php else: ?>
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Next
              </span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/publisher/dashboard.blade.php ENDPATH**/ ?>