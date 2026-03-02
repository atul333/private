<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-[#4CC9F0]/5 to-[#F72585]/5 flex flex-col">
    <div class="flex flex-col h-full">
        <!-- Header Section -->
        <div class="px-4 py-1.5 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20 flex justify-between items-center">
            <?php if(auth()->user()->role === 'publisher'): ?>
            <div class="flex items-center">
                <a href="javascript:history.back()" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="text-lg font-bold text-black">Wallet Balance</h1>
            </div>    
            <a href="<?php echo e(route('publisher.wallet.withdraw', ['id' => Auth::user()->id])); ?>" class="inline-flex items-center gap-1 px-2 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] whitespace-nowrap">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Withdraw Funds
            </a>
            <?php else: ?>
            <div class="flex items-center">
                <a href="javascript:history.back()" class="flex items-center text-black/90 hover:text-black transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span></span>
                </a>
                <h1 class="ml-4 text-xl font-bold text-black">Wallet Balance</h1>
            </div>
            <a href="<?php echo e(route('advertiser.wallet.add-funds-form', ['id' => Auth::user()->id])); ?>" class="inline-flex items-center gap-1 px-2 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-[#4361EE] to-[#3A0CA3] border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white hover:from-[#3F37C9] hover:to-[#4895EF] transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4361EE] whitespace-nowrap">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Funds
            </a>
            <?php endif; ?>
        </div>

        <!-- Fixed Metrics Section -->
        <div class="bg-white/5 backdrop-blur-sm px-4 py-3 border-b border-[#7209B7]/10">
            <div class="grid grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-[#6CC1F0]/20 to-[#4895EF]/20 rounded-xl p-4 text-[#4895EF] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#4CC9F0]/30 hover:border-[#4CC9F0]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-semibold opacity-90 text-gray-900">Available Balance</h3>
                        <p class="text-lg font-semibold mt-2 text-gray-900">₹<?php echo e(number_format($availableBalance ?? 0.00, 2)); ?></p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#7209B7]/20 to-[#560BAD]/20 rounded-xl p-4 text-[#560BAD] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#7209B7]/30 hover:border-[#7209B7]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-semibold opacity-90 text-gray-900">Pending Payments</h3>
                        <p class="text-lg font-semibold mt-2 text-gray-900">₹<?php echo e(number_format($pendingPayments ?? 0.00, 2)); ?></p>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-[#3A0CA3]/20 to-[#4361EE]/20 rounded-xl p-4 text-[#4361EE] shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-[#3A0CA3]/30 hover:border-[#3A0CA3]/50">
                    <div class="text-center">
                        <h3 class="text-sm font-semibold opacity-90 text-gray-900">Payment Done</h3>
                        <p class="text-lg font-semibold mt-2 text-gray-900">₹<?php echo e(number_format($completedPayments ?? 0.00, 2)); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scrollable Content Section -->
        <div class="flex-1 px-4 py-4 overflow-y-auto">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-md overflow-hidden border border-[#4895EF]/30 hover:border-[#4361EE]/50 transition-all duration-300">
                <div class="px-4 py-3 bg-gradient-to-r from-[#4CC9F0]/10 to-[#4895EF]/10 border-b border-[#4895EF]/20">
                    <h2 class="text-lg font-semibold text-gray-900">Transaction History</h2>
                </div>
                        <div class="p-6">
                            <?php if(isset($transactions) && count($transactions) > 0): ?>
                                <div class="w-full">
                                    <table class="min-w-full table-fixed divide-y divide-gray-200">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th class="w-1/4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="w-1/2 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                                <th class="w-1/4 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                <td class="px-4 py-4 text-sm text-gray-600"><?php echo e($transaction->created_at->format('Y-m-d H:i')); ?></td>
                                                <td class="px-4 py-4 text-sm text-gray-600 break-words"><?php echo e($transaction->description); ?></td>
                                                <td class="px-4 py-4 text-sm text-gray-600">₹<?php echo e(number_format($transaction->amount, 2)); ?></td>
                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                                    <div class="mt-6 px-6 py-4 bg-gray-50 rounded-b-xl border-t border-gray-200">
                                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <div class="w-full sm:w-auto">
                                                <p class="text-sm text-gray-600">
                                                    Showing
                                                    <span class="font-semibold text-gray-900"><?php echo e($transactions->firstItem()); ?></span>
                                                    to
                                                    <span class="font-semibold text-gray-900"><?php echo e($transactions->lastItem()); ?></span>
                                                    of
                                                    <span class="font-semibold text-gray-900"><?php echo e($transactions->total()); ?></span>
                                                    results
                                                </p>
                </div>
                                            <div class="w-full sm:w-auto flex justify-center">
                                                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                                    <?php echo e($transactions->onEachSide(1)->links()); ?>

                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                </div>
                            <?php else: ?>
                                <p class="text-center text-gray-500">No transactions found.</p>
                <?php endif; ?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

           
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\Adlinker\Adlinker_main\resources\views/wallet/index.blade.php ENDPATH**/ ?>