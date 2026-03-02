<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20  flex justify-between items-center">
            <div class="flex items-center">
                <a href="/<?php echo e(Auth::user()->id); ?>/campaigns/create" class="btn-back mr-4 text-sm flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-black">Channel Details</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-4 py-4">
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <div class="flex-shrink-0 mb-4 md:mb-0">
                            <?php if($channel->logo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $channel->logo_path)); ?>" alt="<?php echo e($channel->name); ?>" class="w-24 h-24 rounded-full object-cover shadow-md">
                            <?php else: ?>
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-user-circle text-4xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo e($channel->name); ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo e($channel->description); ?></p>
                            <!-- Channel Metrics Section -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                                <div class="bg-gradient-to-br from-[#4361EE]/10 to-[#3A0CA3]/10 border border-[#4361EE]/20 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-300">
                                    <div class="text-center">
                                        <h3 class="text-xs font-medium text-gray-600 opacity-90">Subscribers</h3>
                                        <p class="text-base font-bold mt-1 text-[#3A0CA3]"><?php echo e(number_format($channel->subscribers_count)); ?></p>
                                    </div>
                                </div>
                                <?php if($channel->link): ?>
                                    <div class="bg-gradient-to-br from-[#4CC9F0]/10 to-[#4895EF]/10 border border-[#4895EF]/20 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div class="text-center">
                                            <a href="<?php echo e($channel->link); ?>" target="_blank" class="block transition-colors duration-200">
                                                <h3 class="text-xs font-medium text-gray-600 opacity-90">Channel Link</h3>
                                                <p class="text-sm font-bold mt-1 text-[#4895EF] hover:text-[#4361EE]"><i class="fas fa-external-link-alt mr-1"></i>Visit Channel</p>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if(request('duration') && request('price')): ?>
                                <div class="mt-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Selected Advertising Plan</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                                        <div class="bg-gradient-to-br from-[#560BAD]/10 to-[#7209B7]/10 border border-[#7209B7]/20 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-300">
                                            <div class="text-center">
                                                <i class="fas fa-clock text-base text-[#7209B7] opacity-80"></i>
                                                <h5 class="text-xs font-medium mt-1 text-gray-600 opacity-90">Duration</h5>
                                                <p class="text-base font-bold mt-1 text-[#560BAD]"><?php echo e(request('duration')); ?> Days</p>
                                            </div>
                                        </div>
                                        <div class="bg-gradient-to-br from-[#B5179E]/10 to-[#F72585]/10 border border-[#F72585]/20 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-300">
                                            <div class="text-center">
                                                <i class="fas fa-tag text-base text-[#F72585] opacity-80"></i>
                                                <h5 class="text-xs font-medium mt-1 text-gray-600 opacity-90">Price</h5>
                                                <p class="text-base font-bold mt-1 text-[#B5179E]">₹<?php echo e(request('price')); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="<?php echo e(route('campaigns.store', ['user' => auth()->id()])); ?>" class="space-y-6" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="channel_id" value="<?php echo e($channel->id); ?>">
                                        <input type="hidden" name="duration" value="<?php echo e(request('duration')); ?>">
                                        <input type="hidden" name="price" value="<?php echo e(request('price')); ?>">

                                        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-[#4895EF]/30 hover:border-[#4361EE]/50">
                                            <div class="p-6">
                                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Advertisement Details</h4>

                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="advertisement_image" class="block text-sm font-medium text-gray-700 mb-1">Advertisement Image</label>
                                                        <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 focus:outline-none" id="advertisement_image" name="advertisement_image" accept="image/*" required>
                                                        <p class="mt-1 text-sm text-gray-500">Upload your advertisement image (Max: 2MB)</p>
                                                        <?php $__errorArgs = ['advertisement_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>

                                                    <div>
                                                        <label for="advertisement_content" class="block text-sm font-medium text-gray-700 mb-1">Advertisement Content</label>
                                                        <textarea rows="4" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md" id="advertisement_content" name="advertisement_content" required placeholder="Enter your advertisement content here..."><?php echo e(old('advertisement_content')); ?></textarea>
                                                        <p class="mt-1 text-sm text-gray-500">Write compelling content for your advertisement</p>
                                                        <?php $__errorArgs = ['advertisement_content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $wallet = \App\Models\Wallet::where('user_id', auth()->id())->first();
                                        $campaignPrice = floatval(request('price'));
                                        $walletBalance = $wallet ? number_format($wallet->balance, 2, '.', '') : 0;
                                        $campaignPrice = number_format($campaignPrice, 2, '.', '');
                                    ?>

                                    <?php if($wallet && $walletBalance >= $campaignPrice): ?>
                                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-gradient-to-r from-[#3A0CA3] to-[#4361EE] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                                            Create Campaign
                                        </button>
                                    <?php else: ?>
                                        <div class="space-y-4">
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-exclamation-circle text-red-400"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-red-700">Insufficient wallet balance. Please add funds to continue.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="/<?php echo e(auth()->id()); ?>/advertiser/wallet/add-funds" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-sm font-medium text-white bg-gradient-to-r from-[#F72585] to-[#7209B7] hover:from-[#B5179E] hover:to-[#560BAD] transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7209B7]">
                                                <i class="fas fa-wallet mr-2"></i>
                                                Add Funds to Wallet
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="mt-4 p-4 rounded-md bg-yellow-50 border border-yellow-200">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">Please select a duration and price on the previous page before proceeding.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div> <!-- End Scrollable -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const imageInput = document.getElementById('advertisement_image');
    const form = document.querySelector('form');

    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const existingPreview = document.querySelector('.image-preview');
                if (existingPreview) existingPreview.remove();

                const preview = document.createElement('div');
                preview.className = 'image-preview mt-2';
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                    <button type="button" class="mt-2 text-sm text-red-600 hover:text-red-700" onclick="removeImage()">
                        <i class="fas fa-times mr-1"></i>Remove
                    </button>
                `;
                imageInput.parentNode.appendChild(preview);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage() {
        const preview = document.querySelector('.image-preview');
        if (preview) preview.remove();
        if (imageInput) imageInput.value = '';
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            const content = document.getElementById('advertisement_content');
            const image = document.getElementById('advertisement_image');

            if (!content.value.trim()) {
                e.preventDefault();
                alert('Please enter advertisement content');
                content.focus();
                return;
            }

            if (!image.files.length) {
                e.preventDefault();
                alert('Please select an image for the advertisement');
                return;
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/campaigns/channel-details.blade.php ENDPATH**/ ?>