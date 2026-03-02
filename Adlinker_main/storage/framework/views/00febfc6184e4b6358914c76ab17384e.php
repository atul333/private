<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex-1">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/<?php echo e(Auth::user()->id); ?>/publisher/dashboard" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-lg font-bold text-black">Add New Channel</h1>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-4 py-4">
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-sm rounded-xl shadow-lg border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <form method="POST" action="<?php echo e(route('channels.store', ['user' => Auth::id()])); ?>" enctype="multipart/form-data" class="p-6 space-y-6">
                        <?php echo csrf_field(); ?>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r  rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-900">Channel Name</label>
                                <input type="text" class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="link" class="block text-sm font-semibold text-gray-900">Channel Link</label>
                                <input type="url" class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="link" name="link" value="<?php echo e(old('link')); ?>" required placeholder="https://t.me/yourchannel">
                                <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="description" class="block text-sm font-semibold text-gray-900">Channel Description</label>
                                <textarea class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="3" required><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r  rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                            <div class="relative space-y-2">
                                <label for="logo" class="block text-sm font-semibold text-gray-900">Channel Logo</label>
                                <input type="file" class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#4CC9F0]/10 file:text-[#4361EE] hover:file:bg-[#4CC9F0]/20 transition duration-200 <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="logo" name="logo" accept="image/*" required>
                                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>


                        <script>
                    function validatePrice(input) {
                        const errorElement = document.getElementById(input.id + '_error');
                        if (parseFloat(input.value) < 0.1) {
                            input.classList.add('border-[#F72585]', 'text-[#F72585]');
                            errorElement.classList.remove('hidden');
                        } else {
                            input.classList.remove('border-[#F72585]', 'text-[#F72585]');
                            errorElement.classList.add('hidden');
                        }
                    }
                </script>
                <div class="pt-8">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-r  rounded-lg blur opacity-10"></div>
                                <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-lg shadow-lg border border-[#4895EF]/20">
                                    <h3 class="text-xl font-bold text-gray-900 mb-6">Pricing Options</h3>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div class="relative group">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r  rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                            <div class="relative space-y-2">
                                                <label for="price_1_day" class="block text-sm font-semibold text-gray-900">Price for 1 Day (₹)</label>
                                                <div class="relative rounded-lg shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                                    </div>
                                                    <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_1_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_1_day" name="price_1_day" value="<?php echo e(old('price_1_day')); ?>" placeholder="Enter Minimum ₹0.1" required min="0.1" oninput="validatePrice(this)">
                                                    <p class="mt-2 text-xs text-[#F72585] hidden" id="price_1_day_error">Price must be at least ₹0.1</p>
                                                </div>
                                                <?php $__errorArgs = ['price_1_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r  rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_2_days" class="block text-sm font-semibold text-gray-900">Price for 2 Days (₹)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">₹</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_2_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_2_days" name="price_2_days" value="<?php echo e(old('price_2_days')); ?>" placeholder="Enter Minimum ₹0.1" required min="0.1" oninput="validatePrice(this)">
                                            <p class="mt-2 text-xs text-[#F72585] hidden" id="price_2_days_error">Price must be at least ₹0.1</p>
                                        </div>
                                        <?php $__errorArgs = ['price_2_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_3_days" class="block text-sm font-semibold text-gray-900">Price for 3 Days (₹)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">₹</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_3_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_3_days" name="price_3_days" value="<?php echo e(old('price_3_days')); ?>" placeholder="Enter Minimum ₹0.1" required min="0.1" oninput="validatePrice(this)">
                                            <p class="mt-2 text-xs text-[#F72585] hidden" id="price_3_days_error">Price must be at least ₹0.1</p>
                                        </div>
                                        <?php $__errorArgs = ['price_3_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r  rounded-lg blur opacity-0 group-hover:opacity-25 transition duration-300"></div>
                                    <div class="relative space-y-2">
                                        <label for="price_7_days" class="block text-sm font-semibold text-gray-900">Price for 7 Days (₹)</label>
                                        <div class="relative rounded-lg shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">₹</span>
                                            </div>
                                            <input type="number" step="0.01" class="pl-7 block w-full px-4 py-3 rounded-lg border border-gray-300 bg-white shadow-sm focus:border-[#4361EE] focus:ring-2 focus:ring-[#4361EE] transition duration-200 <?php $__errorArgs = ['price_7_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-[#F72585] text-[#F72585] placeholder-[#F72585]/50 focus:border-[#F72585] focus:ring-[#F72585] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price_7_days" name="price_7_days" value="<?php echo e(old('price_7_days')); ?>" placeholder="Enter Minimum ₹0.1" required min="0.1" oninput="validatePrice(this)">
                                            <p class="mt-2 text-xs text-[#F72585] hidden" id="price_7_days_error">Price must be at least ₹0.1</p>
                                        </div>
                                        <?php $__errorArgs = ['price_7_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-xs text-[#F72585]"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="pt-8">
                    <button type="submit" class="w-full flex justify-center items-center px-8 py-4 border border-transparent rounded-lg text-base font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:scale-[1.02] transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE]">
                        Submit Channel
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/channels/create.blade.php ENDPATH**/ ?>