<?php
use App\Models\Channel;
?>



<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
  <div class="flex-1 flex flex-col min-h-0 max-h-screen overflow-hidden">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20  flex justify-between items-center shrink-0">
      <div class="flex items-center">
        <a href="<?php echo e(route('platform.selection')); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span></span>
        </a>
        <h1 class="text-lg font-bold text-black"><?php echo e(__('Publisher Dashboard')); ?></h1>
      </div>
      <div>
        <a href="<?php echo e(route('channels.create', ['user' => Auth::id()])); ?>" class="inline-flex items-center gap-1 px-2 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 whitespace-nowrap">
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
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-[#4361EE] text-[#4361EE] bg-blue-50/60 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
          </svg>
          Telegram
        </a>
        <!-- Instagram Tab -->
        <a href="<?php echo e(route('instagram.publisher.dashboard', ['user' => Auth::id()])); ?>"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-pink-600 hover:border-pink-400 hover:bg-pink-50/40 transition-all duration-200">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
          Instagram
        </a>
      </div>
    </div>
    <!-- Fixed Metrics Section -->
    <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
      <div class="grid grid-cols-3 gap-4">
        <!-- Metrics cards -->
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold text-gray-900">Active Channels</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e($activeChannels); ?></p>
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
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Total Subscribers</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e(Channel::where('publisher_id', Auth::user()->publisher->id)->sum('subscribers_count')); ?></p>
          </div>
        </div>
        
      </div>
    </div>

    <!-- Scrollable Content Section -->
    <div class="flex-1 overflow-y-auto px-4 py-4 min-h-0">
      <!-- Channel Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <!-- Channel Card -->
          <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
            <div class="relative border-b border-gray-100">
              <div class="absolute top-3 right-3">
                <?php if($channel->status === 'moderation'): ?>
                  <div class="flex flex-col items-end">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full border bg-[#F72585]/20 text-[#B5179E] border-[#F72585]">
                      <?php echo e(ucfirst($channel->status)); ?>

                    </span>
                    <span class="text-xs text-[#B5179E] mt-1">Wait 24h for activation</span>
                  </div>
                <?php else: ?>
                  <span class="px-2.5 py-1 text-xs font-semibold rounded-full border <?php echo e($channel->status === 'active' ? 'bg-[#4CC9F0]/20 text-[#3A0CA3] border-[#4CC9F0]' : 'bg-[#F72585]/20 text-[#B5179E] border-[#F72585]'); ?>">
                    <?php echo e(ucfirst($channel->status)); ?>

                  </span>
                <?php endif; ?>
              </div>
              <div class="p-4">
                <div class="flex items-center space-x-3 mb-3 border-b border-gray-200 pb-3">
                  <?php if($channel->logo_path): ?>
                    <img src="<?php echo e(asset('storage/' . $channel->logo_path)); ?>" alt="<?php echo e($channel->name); ?> Logo" class="h-12 w-12 rounded-full object-cover border border-blue-900 shadow-sm">
                  <?php else: ?>
                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                  <?php endif; ?>
                  <div>
                    <h3 class="text-sm font-semibold text-gray-900"><?php echo e($channel->name); ?></h3>
                    <div class="flex items-center mt-1">
                      <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                      </svg>
                      <span class="text-xs text-gray-900"><?php echo e(number_format($channel->subscribers_count)); ?> Subscribers</span>
                    </div>
                  </div>
                </div>

                <div class="border-t border-gray-50 pt-3">
                  <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-gray-900">Earnings</span>
                    <span class="text-xs font-semibold text-gray-900 rounded-md ">₹<?php echo e(number_format($channel->campaigns->where('status', 'completed')->sum('price') ?? 0, 2)); ?></span>
                  </div>

                  <div class="flex items-center justify-between space-x-2">
                    <div class="flex space-x-2">
                      <a href="<?php echo e(route('channels.edit', ['user' => Auth::id(), 'channel' => $channel])); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 rounded-lg shadow-sm text-xs font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                      </a>
                    </div>
                     <?php $pendingCount = $channel->campaigns->whereIn('status', ['active', 'pending'])->count(); ?>

                    <a href="<?php echo e(route('publisher.channel.campaigns', ['user' => Auth::id(), 'channel' => $channel])); ?>" class="inline-flex items-center text-xs px-3 py-1.5 rounded-md bg-[#4361EE]/10 text-[#3A0CA3] hover:bg-[#4361EE]/20 border border-[#4361EE]">
                      Ad Details
                      <?php if($pendingCount > 0): ?>
                        <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-[#4361EE]/20"><?php echo e($pendingCount); ?></span>
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
              <h3 class="mt-2 text-sm font-medium text-gray-900">No channels found</h3>
              <p class="mt-1 text-xs text-gray-500">Get started by creating a new channel.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-6 w-full overflow-x-auto pb-4">
        <div class="min-w-full flex justify-center">
          <?php echo e($channels->links('pagination::tailwind')); ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/publisher/dashboard.blade.php ENDPATH**/ ?>