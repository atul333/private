<?php

namespace App\Observers;

use App\Models\Wallet;
use App\Models\Withdrawal;

class WithdrawalObserver
{
    /**
     * Handle the Withdrawal "updated" event.
     * When status changes to "payment done", update the wallet transaction description.
     */
    public function updated(Withdrawal $withdrawal): void
    {
        // Only act when status just changed to "payment done"
        if ($withdrawal->wasChanged('status') && $withdrawal->status === 'payment done') {
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();

            if (!$wallet) {
                return;
            }

            // Build a rich completed description
            if ($withdrawal->payment_method === 'upi') {
                $methodDetail = 'UPI (' . $withdrawal->upi_id . ')';
            } else {
                $methodDetail = 'Bank (' . ($withdrawal->bank_name ?? $withdrawal->payment_method) . ')';
            }

            $user = $withdrawal->user;
            $userName = $user ? $user->name : 'user';
            $completedDesc = 'Withdrawal completed for ' . $userName . ' with ' . $methodDetail;

            // Update the matching pending withdrawal transaction
            $wallet->completeWithdrawal($withdrawal->amount, $completedDesc);

            // Move amount from pending_balance
            $wallet->pending_balance = max(0, $wallet->pending_balance - $withdrawal->amount);
            $wallet->save();
        }
    }
}
