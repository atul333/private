<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2 bg-gradient-to-r from-[#FFEEF8] to-[#FFF4E6] border-b border-[#E1306C]/10 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="<?php echo e(route('instagram.advertiser.profiles.index', ['user' => auth()->id()])); ?>" class="flex items-center text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-sm sm:text-lg font-bold text-gray-800 whitespace-nowrap">Create Campaign</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Summary Card -->
                <div class="bg-white border border-gray-200/80 rounded-xl p-3.5 sm:p-5 mb-5 shadow-sm">
                    <div class="flex items-center min-w-0 gap-3 sm:gap-4">
                        <div class="p-0.5 bg-gradient-to-tr from-[#FD1D1D] via-[#E1306C] to-[#833AB4] rounded-full shrink-0">
                            <?php if($profile->profile_photo): ?>
                                <img src="<?php echo e(asset('storage/' . $profile->profile_photo)); ?>" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover bg-white">
                            <?php else: ?>
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-pink-50 flex items-center justify-center text-[#E1306C] bg-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="text-sm sm:text-lg font-bold text-gray-900 truncate">Advertising on <?php echo e('@' . $profile->instagram_id); ?></h2>
                            <p class="text-gray-500 text-xs sm:text-sm truncate">
                                <?php echo e(number_format($profile->followers)); ?> followers • <span class="font-semibold text-emerald-600">₹<?php echo e(number_format($profile->price_per_story, 2)); ?></span> / story
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md border border-[#E1306C]/15 overflow-hidden">
                    <form action="<?php echo e(route('instagram.advertiser.campaigns.store', ['user' => auth()->id()])); ?>" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-5">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="instagram_profile_id" value="<?php echo e($profile->id); ?>">

                        <!-- Error Messages -->
                        <?php if($errors->any()): ?>
                            <div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="ml-3">
                                        <ul class="text-xs sm:text-sm text-red-700 list-disc list-inside">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Media Type Selection -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-2">Media Type *</label>
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <input class="peer hidden" type="radio" name="media_type" id="typeImage" value="image" checked>
                                    <label for="typeImage" class="flex flex-col items-center justify-center p-3 sm:p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#E1306C]/40 hover:bg-pink-50/30 transition-all duration-200 peer-checked:border-[#E1306C] peer-checked:bg-pink-50/50 peer-checked:ring-2 peer-checked:ring-[#E1306C]/30">
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#E1306C] mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs sm:text-sm font-semibold text-gray-800">Image Story</span>
                                    </label>
                                </div>
                                <div>
                                    <input class="peer hidden" type="radio" name="media_type" id="typeVideo" value="video">
                                    <label for="typeVideo" class="flex flex-col items-center justify-center p-3 sm:p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#E1306C]/40 hover:bg-pink-50/30 transition-all duration-200 peer-checked:border-[#E1306C] peer-checked:bg-pink-50/50 peer-checked:ring-2 peer-checked:ring-[#E1306C]/30">
                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#833AB4] mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs sm:text-sm font-semibold text-gray-800">Video Story</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5">Upload Media *</label>
                            <input type="file" name="media_file" id="mediaFile" class="block w-full text-xs sm:text-sm text-gray-500 file:mr-3 file:py-2 file:px-3 sm:file:px-4 file:rounded-lg file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-pink-50 file:text-[#E1306C] hover:file:bg-pink-100 transition duration-200 border border-gray-200 rounded-lg p-1.5 bg-gray-50/50" accept="image/*,video/*" required onchange="previewMedia(this)">
                            <p class="text-[11px] text-gray-500 mt-1">Supported: JPG, PNG, MP4. Max: 10MB. Recommended: 1080x1920 (9:16 vertical)</p>
                            
                            <div id="mediaPreview" class="mt-3 hidden">
                                <div class="bg-gray-100 rounded-xl p-3 text-center">
                                    <img id="imagePreview" class="max-h-72 sm:max-h-80 w-auto max-w-full mx-auto rounded-lg shadow-sm object-contain hidden">
                                    <video id="videoPreview" class="max-h-72 sm:max-h-80 w-auto max-w-full mx-auto rounded-lg shadow-sm hidden" controls></video>
                                </div>
                            </div>
                        </div>

                        <!-- Advertisement Link Text -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5">Advertisement Link Text *</label>
                            <input type="text" name="link_text" class="block w-full px-3.5 py-2.5 sm:py-3 text-sm rounded-lg border-gray-300 shadow-sm focus:border-[#E1306C] focus:ring-2 focus:ring-[#E1306C]/30 transition duration-200" placeholder="e.g. Shop Now, Learn More, Order Online" value="<?php echo e(old('link_text')); ?>" required>
                            <p class="text-[11px] text-gray-500 mt-1">Text shown on the Instagram story link sticker</p>
                        </div>

                        <!-- Advertisement Link -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-800 mb-1.5">Advertisement Link *</label>
                            <input type="url" name="link_url" class="block w-full px-3.5 py-2.5 sm:py-3 text-sm rounded-lg border-gray-300 shadow-sm focus:border-[#E1306C] focus:ring-2 focus:ring-[#E1306C]/30 transition duration-200" placeholder="https://example.com" value="<?php echo e(old('link_url')); ?>" required>
                            <p class="text-[11px] text-gray-500 mt-1">Destination URL when users tap the sticker</p>
                        </div>

                        <!-- Price Info -->
                        <div class="bg-emerald-50/70 rounded-xl p-3.5 sm:p-4 border border-emerald-200">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 text-sm sm:text-base">Campaign Price: ₹<?php echo e(number_format($profile->price_per_story, 2)); ?></p>
                                    <p class="text-xs text-gray-600">Story will be posted for 24 hours on <?php echo e('@' . $profile->instagram_id); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 sm:py-4 border border-transparent rounded-xl text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-[#E1306C] via-[#FD1D1D] to-[#833AB4] hover:opacity-95 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Campaign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewMedia(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        const mediaType = document.querySelector('input[name="media_type"]:checked').value;
        
        reader.onload = function(e) {
            document.getElementById('mediaPreview').classList.remove('hidden');
            
            if (mediaType === 'image' || file.type.startsWith('image/')) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('videoPreview').classList.add('hidden');
            } else {
                document.getElementById('videoPreview').src = e.target.result;
                document.getElementById('videoPreview').classList.remove('hidden');
                document.getElementById('imagePreview').classList.add('hidden');
            }
        }
        
        reader.readAsDataURL(file);
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/instagram/advertiser/campaigns/create.blade.php ENDPATH**/ ?>