<?php $__env->startSection('content'); ?>
<div class="w-full max-w-md mx-auto">
    <div class="px-4">
        <div class="w-full">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-[#4895EF]/20 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 ">
                    <h2 class="text-xl font-bold text-black text-center"><?php echo e(__('Welcome back')); ?></h2>
                    <p class="mt-1 text-center text-sm text-black/90"><?php echo e(__('Sign in to your account')); ?></p>
                </div>

                <div class="p-6 space-y-4">
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700"><?php echo e(__('Email Address')); ?></label>
                                <div class="mt-1">
                                    <input id="email" type="email" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                </div>
                                <?php $__errorArgs = ['email'];
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

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700"><?php echo e(__('Password')); ?></label>
                                <div class="mt-1">
                                    <input id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                                </div>
                                <?php $__errorArgs = ['password'];
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

                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700"><?php echo e(__('Login as')); ?></label>
                                <div class="mt-1">
                                    <select id="role" class="mt-1 block w-full px-3 py-2 border border-[#4895EF]/30 rounded-md shadow-sm focus:outline-none focus:ring-[#4361EE] focus:border-[#4361EE] sm:text-sm <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="publisher" <?php echo e(old('role') == 'publisher' ? 'selected' : ''); ?>>Publisher</option>
                                        <option value="advertiser" <?php echo e(old('role') == 'advertiser' ? 'selected' : ''); ?>>Advertiser</option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['role'];
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

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-[#4361EE] focus:ring-[#4361EE] border-[#4895EF]/30 rounded" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label for="remember" class="ml-2 block text-sm text-gray-700"><?php echo e(__('Remember Me')); ?></label>
                                </div>
                                <?php if(Route::has('password.request')): ?>
                                    <div class="text-sm">
                                        <a href="<?php echo e(route('password.request')); ?>" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200"><?php echo e(__('Forgot Your Password?')); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] hover:from-[#3F37C9] hover:to-[#4895EF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] transform hover:-translate-y-0.5 transition-all duration-300">
                                    <?php echo e(__('Sign in')); ?>

                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-sm text-gray-600">Don't have an account? 
                                    <a href="<?php echo e(route('register')); ?>" class="font-medium text-[#4361EE] hover:text-[#3A0CA3] transition-colors duration-200">Register here</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/auth/login.blade.php ENDPATH**/ ?>