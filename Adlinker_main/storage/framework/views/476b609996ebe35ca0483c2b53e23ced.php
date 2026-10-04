<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-2 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center min-h-[52px]">
            <div class="flex items-center">
                <a href="/<?php echo e(Auth::user()->id); ?>/publisher/dashboard" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-sm sm:text-lg font-bold text-black whitespace-nowrap">Edit Channel</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-3 sm:px-4 py-4 pb-28 sm:pb-12">
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-[#0088cc]/20">
                <form method="POST" action="<?php echo e(route('channels.update', ['user' => Auth::id(), 'channel' => $channel])); ?>" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Channel Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-900">Channel Name</label>
                        <input type="text" class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $channel->name)); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Channel Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-semibold text-gray-900">Channel Description</label>
                        <textarea class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="3" required><?php echo e(old('description', $channel->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Channel Logo -->
                    <div class="space-y-2">
                        <label for="logo" class="block text-sm font-semibold text-gray-900">Channel Logo</label>
                        <div class="flex items-center space-x-4">
                            <?php if($channel->logo_path): ?>
                                <img src="<?php echo e(asset('storage/' . $channel->logo_path)); ?>" alt="Current Logo" class="h-12 w-12 rounded-full object-cover border border-gray-300">
                            <?php endif; ?>
                            <input type="file" class="mt-1 block w-full px-4 py-3 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200" id="logo" name="logo" accept="image/*">
                        </div>
                        <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <script>
                        function validatePrice(input) {
                            const errorElement = document.getElementById(input.id + '_error');
                            if (parseFloat(input.value) < 0.1) {
                                input.classList.add('border-red-400', 'text-red-600');
                                errorElement.classList.remove('hidden');
                            } else {
                                input.classList.remove('border-red-400', 'text-red-600');
                                errorElement.classList.add('hidden');
                            }
                        }
                    </script>

                    <!-- Pricing Options -->
                    <div class="pt-4">
                        <div class="bg-white/90 backdrop-blur-sm p-4 sm:p-6 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Pricing Options</h3>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                                <!-- 1 Day -->
                                <div class="space-y-2">
                                    <label for="price_1_day" class="block text-sm font-semibold text-gray-900">Price for 1 Day (₹)</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_1_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_1_day" name="price_1_day" value="<?php echo e(old('price_1_day', $channel->price_1_day)); ?>" required min="0.1" oninput="validatePrice(this)" placeholder="Enter Minimum ₹0.1">
                                        <p class="mt-2 text-xs text-red-600 hidden" id="price_1_day_error">Price must be at least ₹0.1</p>
                                    </div>
                                    <?php $__errorArgs = ['price_1_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- 2 Days -->
                                <div class="space-y-2">
                                    <label for="price_2_days" class="block text-sm font-semibold text-gray-900">Price for 2 Days (₹)</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_2_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_2_days" name="price_2_days" value="<?php echo e(old('price_2_days', $channel->price_2_days)); ?>" required min="0.1" oninput="validatePrice(this)" placeholder="Enter Minimum ₹0.1">
                                        <p class="mt-2 text-xs text-red-600 hidden" id="price_2_days_error">Price must be at least ₹0.1</p>
                                    </div>
                                    <?php $__errorArgs = ['price_2_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- 3 Days -->
                                <div class="space-y-2">
                                    <label for="price_3_days" class="block text-sm font-semibold text-gray-900">Price for 3 Days (₹)</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_3_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_3_days" name="price_3_days" value="<?php echo e(old('price_3_days', $channel->price_3_days)); ?>" required min="0.1" oninput="validatePrice(this)" placeholder="Enter Minimum ₹0.1">
                                        <p class="mt-2 text-xs text-red-600 hidden" id="price_3_days_error">Price must be at least ₹0.1</p>
                                    </div>
                                    <?php $__errorArgs = ['price_3_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- 7 Days -->
                                <div class="space-y-2">
                                    <label for="price_7_days" class="block text-sm font-semibold text-gray-900">Price for 7 Days (₹)</label>
                                    <div class="relative rounded-lg shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₹</span>
                                        </div>
                                        <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_7_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 text-red-600 focus:border-red-400 focus:ring-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_7_days" name="price_7_days" value="<?php echo e(old('price_7_days', $channel->price_7_days)); ?>" required min="0.1" oninput="validatePrice(this)" placeholder="Enter Minimum ₹0.1">
                                        <p class="mt-2 text-xs text-red-600 hidden" id="price_7_days_error">Price must be at least ₹0.1</p>
                                    </div>
                                    <?php $__errorArgs = ['price_7_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full flex justify-center items-center px-6 py-3.5 sm:py-4 border border-transparent rounded-xl text-sm sm:text-base font-semibold text-white bg-gradient-to-r from-[#0088cc] to-[#4361EE] hover:opacity-95 shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                            Update Channel
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/channels/edit.blade.php ENDPATH**/ ?>