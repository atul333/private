 

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5">
  <div class="flex flex-col">
    <!-- Header Section -->
    <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
      <div class="flex items-center">
        <a href="<?php echo e(route('platform.selection')); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          <span></span>
        </a>
        <h1 class="text-lg font-bold text-black"><?php echo e(__('Advertiser Dashboard')); ?></h1>
      </div>
      <div>
        <a href="/<?php echo e(Auth::id()); ?>/campaigns/create" class="inline-flex items-center gap-1 px-2 py-1.5 sm:px-4 sm:py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 whitespace-nowrap">
          <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Create New Campaign
        </a>
      </div>
    </div>

    <!-- Fixed Metrics Section -->
    <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10 shrink-0">
      <div class="grid grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Active Campaigns</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e($activeCampaigns); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#F72585]/20 to-[#B5179E]/20 rounded-xl p-4 text-[#B5179E] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#F72585]/30 hover:border-[#F72585]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Total Spent</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900">₹<?php echo e(number_format($totalSpent, 2)); ?></p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
          <div class="text-center">
            <h3 class="text-sm font-semibold opacity-90 text-gray-900">Completed Campaigns</h3>
            <p class="text-lg font-semibold mt-2 text-gray-900"><?php echo e($completedCampaigns); ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="px-4 py-3 bg-white/50 backdrop-blur-sm border-b border-[#4895EF]/10">
      <form id="filterForm" action="<?php echo e(url()->current()); ?>" method="GET" class="flex justify-end items-center gap-2 overflow-x-auto whitespace-nowrap">
        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[90px]">
          <option value="all" <?php echo e(request('status') == 'all' || !request('status') ? 'selected' : ''); ?>>All Statuses</option>
          <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
          <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
          <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
          <option value="expired" <?php echo e(request('status') == 'expired' ? 'selected' : ''); ?>>Expired</option>
        </select>

        <!-- Sort By -->
        <select name="sort" onchange="this.form.submit()" class="text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#4361EE]/50 focus:border-[#4361EE] py-2 px-2 sm:px-3 min-w-[110px]">
          <option value="newest" <?php echo e(request('sort') == 'newest' || !request('sort') ? 'selected' : ''); ?>>Newest First</option>
          <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest First</option>
          <option value="price-high" <?php echo e(request('sort') == 'price-high' ? 'selected' : ''); ?>>Price (High to Low)</option>
          <option value="price-low" <?php echo e(request('sort') == 'price-low' ? 'selected' : ''); ?>>Price (Low to High)</option>
          <option value="duration-high" <?php echo e(request('sort') == 'duration-high' ? 'selected' : ''); ?>>Duration (High to Low)</option>
          <option value="duration-low" <?php echo e(request('sort') == 'duration-low' ? 'selected' : ''); ?>>Duration (Low to High)</option>
        </select>
      </form>
    </div>

    <!-- Content Section -->
    <div class="px-4 py-4">
      <!-- Campaign Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
          <div class="relative p-6">
            <!-- Status Badge -->
            <span class="absolute top-4 right-4 text-xs font-semibold px-3 py-1 rounded-full <?php echo e($campaign->status === 'active' ? ($campaign->post_link ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') : ($campaign->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($campaign->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800'))); ?>">
              <?php echo e($campaign->status === 'active' ? ($campaign->post_link ? 'Active' : 'Payment Successful') : ucfirst($campaign->status)); ?>

            </span>

            <!-- Campaign Details -->
            <div class="flex items-center mb-4">
              <?php if($campaign->advertisement_image): ?>
                <img src="<?php echo e(asset('storage/' . $campaign->advertisement_image)); ?>" class="w-16 h-16 rounded-full object-cover shadow">
              <?php else: ?>
                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                  <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                  </svg>
                </div>
              <?php endif; ?>
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($campaign->channel_name); ?></h3>
                <p class="text-sm text-gray-500"><?php echo e(number_format($campaign->subscribers)); ?> Subscribers</p>
              </div>
            </div>

            <div class="text-sm text-gray-700 space-y-2">
              <p><span class="font-semibold">Duration:</span> <?php echo e($campaign->duration); ?> days</p>
              <p><span class="font-semibold">Price:</span> <span class="text-green-600">₹<?php echo e(number_format($campaign->price, 2)); ?></span></p>
              
              <?php if($campaign->advertisement_content): ?>
                <p class="line-clamp-2"><span class="font-semibold">Content:</span> <?php echo e($campaign->advertisement_content); ?></p>
              <?php endif; ?>

              <?php if($campaign->status === 'active'): ?>
                <?php if(!$campaign->post_submitted_at): ?>
                  <div class="countdown-container rounded-lg bg-red-50 p-3 mb-2">
                    <div class="submission-countdown-timer text-xs" 
                         data-campaign-id="<?php echo e($campaign->id); ?>"
                         data-created-at="<?php echo e($campaign->created_at->toISOString()); ?>">
                      <div class="countdown-text text-red-600 font-semibold">
                        Time Left to Submit Post: <span class="submission-time">Loading...</span>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <p><span class="font-semibold">Campaign Timer:</span>
                  <span class="countdown-timer text-gray-600" 
                    data-campaign-id="<?php echo e($campaign->id); ?>" 
                    data-duration="<?php echo e($campaign->duration); ?>"
                    data-start="<?php echo e($campaign->post_submitted_at ? $campaign->post_submitted_at->toISOString() : ''); ?>"
                    data-submitted="<?php echo e($campaign->post_submitted_at ? 'true' : 'false'); ?>">
                    <span class="countdown-text"></span>
                    <?php echo e($campaign->post_submitted_at ? '' : 'Waiting for link submission...'); ?>

                  </span>
                </p>
              <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-between items-center">
              <a href="<?php echo e($campaign->channel_link); ?>" target="_blank" class="px-3 py-1.5 text-xs font-medium text-white/90 rounded-lg bg-gradient-to-r from-[#3A0CA3]/80 to-[#4361EE]/80 hover:from-[#3F37C9]/90 hover:to-[#4895EF]/90 transition-all duration-300 shadow-sm hover:shadow">View Channel</a>
              <?php if($campaign->post_link): ?>
                <a href="<?php echo e($campaign->post_link); ?>" target="_blank" class="px-3 py-1.5 text-xs font-medium text-white/90 rounded-lg bg-gradient-to-r from-[#F72585] to-[#B5179E] hover:from-[#B5179E] hover:to-[#F72585] transition-all duration-300 shadow-sm hover:shadow">View Post</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center text-gray-500 py-8">No campaigns found.</div>
        <?php endif; ?>
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white/50 backdrop-blur-sm rounded-lg px-6 py-4 border border-[#4895EF]/10">
          <p class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900"><?php echo e($campaigns->firstItem() ?? 0); ?></span> to
            <span class="font-medium text-gray-900"><?php echo e($campaigns->lastItem() ?? 0); ?></span> of
            <span class="font-medium text-gray-900"><?php echo e($campaigns->total()); ?></span> results
          </p>

          <div class="flex items-center gap-2">
            <?php if($campaigns->onFirstPage()): ?>
              <span class="px-4 py-2 text-sm text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed">
                Previous
              </span>
            <?php else: ?>
              <a href="<?php echo e($campaigns->previousPageUrl()); ?>" class="px-4 py-2 text-sm text-gray-600 bg-white rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                Previous
              </a>
            <?php endif; ?>

            <?php if($campaigns->hasMorePages()): ?>
              <a href="<?php echo e($campaigns->nextPageUrl()); ?>" class="px-4 py-2 text-sm text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] rounded-lg hover:from-[#3F37C9] hover:to-[#4895EF] transition-all duration-200 shadow-sm hover:shadow">
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

<script>
function updateSubmissionCountdown(element) {
    // Check if campaign is already expired
    if (element.dataset.status === 'expired') {
        element.querySelector('.submission-time').textContent = 'Campaign Expired';
        return;
    }

    const campaignId = element.dataset.campaignId;
    const createdAt = new Date(element.dataset.createdAt);
    const deadline = new Date(createdAt.getTime() + (24 * 60 * 60 * 1000)); // 24 hours from creation
    const now = new Date();
    const timeLeft = deadline - now;

    if (timeLeft <= 0) {
        element.querySelector('.submission-time').textContent = 'Submission deadline passed';
        
        // Call the expire endpoint
        fetch(`/api/campaigns/${campaignId}/expire`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '/login';
                    throw new Error('Please log in to continue');
                }
                if (response.status === 403) {
                    throw new Error('You are not authorized to expire this campaign');
                }
                return response.json().then(data => {
                    throw new Error(data.message || 'Failed to expire campaign');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (data.status === 'expired') {
                    element.dataset.status = 'expired';
                    element.querySelector('.submission-time').textContent = 'Campaign Expired';
                    
                    // Show refund success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'text-green-600 text-sm mt-2';
                    successDiv.textContent = `Campaign expired. $${data.refunded_amount} has been refunded to your wallet.`;
                    element.appendChild(successDiv);
                    
                    // Remove any error messages
                    const errorMsg = element.querySelector('.error-message');
                    if (errorMsg) errorMsg.remove();
                    
                    // Stop the countdown interval
                    if (element.dataset.countdownInterval) {
                        clearInterval(parseInt(element.dataset.countdownInterval));
                    }
                    
                    // Reload immediately
                    window.location.reload();
                }
            } else {
                console.error('Campaign expiration failed:', data.message);
                showError(element, data.message || 'Failed to expire campaign');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError(element, error.message);
            if (error.message.includes('not authorized')) {
                // If unauthorized, stop trying to expire
                element.dataset.status = 'unauthorized';
                // Stop the countdown interval
                if (element.dataset.countdownInterval) {
                    clearInterval(parseInt(element.dataset.countdownInterval));
                }
            }
        });
        
        return;
    }

    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.submission-time').textContent = 
        `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
}

// Helper function to show error messages
function showError(element, message) {
    // Remove any existing error message
    const existingError = element.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create and append new error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-600 text-sm mt-2';
    errorDiv.textContent = message;
    element.appendChild(errorDiv);
}

function initializeSubmissionCountdowns() {
    const submissionTimers = document.querySelectorAll('.submission-countdown-timer');
    submissionTimers.forEach(timer => {
        timer.dataset.status = timer.dataset.status || 'active';
        updateSubmissionCountdown(timer);
        const intervalId = setInterval(() => updateSubmissionCountdown(timer), 1000);
        timer.dataset.countdownInterval = intervalId;
    });
}

function updateCampaignTimer(element) {
    const campaignId = element.dataset.campaignId;
    const duration = parseInt(element.dataset.duration) * 24 * 60 * 60 * 1000; // Convert days to milliseconds
    const startDate = element.dataset.start ? new Date(element.dataset.start) : null;
    const submitted = element.dataset.submitted === 'true';
    
    if (!submitted || !startDate) {
        element.querySelector('.countdown-text').textContent = 'Waiting for link submission...';
        return;
    }

    const now = new Date();
    const timeLeft = duration - (now - startDate);

    if (timeLeft <= 0) {
        element.querySelector('.countdown-text').textContent = 'Campaign Ended';
        
        // Call the complete endpoint
        fetch(`/api/campaigns/${campaignId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to complete campaign');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update the status badge
                const statusBadge = element.closest('.bg-white').querySelector('[class*="bg-"][class*="text-"]');
                if (statusBadge) {
                    statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800';
                    statusBadge.textContent = 'Completed';
                }
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'text-green-600 text-sm mt-2';
                successDiv.textContent = `Campaign completed. Publisher has been paid $${data.amount_paid}.`;
                element.appendChild(successDiv);
                
                // Reload the page after a short delay
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error completing campaign:', error);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-600 text-sm mt-2';
            errorDiv.textContent = 'Failed to complete campaign. Please refresh the page.';
            element.appendChild(errorDiv);
        });
        
        return;
    }

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    element.querySelector('.countdown-text').textContent = 
        `${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
}

// Initialize campaign timers
function initializeCampaignTimers() {
    const campaignTimers = document.querySelectorAll('.countdown-timer');
    campaignTimers.forEach(timer => {
        updateCampaignTimer(timer);
        setInterval(() => updateCampaignTimer(timer), 1000);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initializeSubmissionCountdowns();
    initializeCampaignTimers();
});
</script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/advertiser/dashboard.blade.php ENDPATH**/ ?>