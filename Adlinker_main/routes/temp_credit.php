<?php

use Illuminate\Support\Facades\Route;
use App\Models\InstagramCampaign;
use App\Models\Withdrawal;
use App\Models\Wallet;
use App\Models\User;

Route::get('/credit-completed-campaigns', function () {
    $completedCampaigns = InstagramCampaign::where('status', 'completed')
        ->where('paid', true)
        ->get();

    $credited = 0;
    $errors = [];

    foreach ($completedCampaigns as $campaign) {
        if ($campaign->publisher_id) {
            $publisherUser = User::find($campaign->publisher_id);
            if ($publisherUser && $publisherUser->wallet) {
                $publisherUser->wallet->deposit(
                    $campaign->price,
                    "Instagram Campaign #{$campaign->id} completed"
                );
                $credited++;
            } else {
                $errors[] = "Wallet not found for user {$campaign->publisher_id}";
            }
        } else {
            $errors[] = "No publisher_id for campaign {$campaign->id}";
        }
    }

    return response()->json([
        'success' => true,
        'total_campaigns' => $completedCampaigns->count(),
        'credited' => $credited,
        'errors' => $errors
    ]);
})->name('credit.completed.campaigns');

// One-time fix: update wallet transaction descriptions for already-completed withdrawals
Route::get('/fix-completed-withdrawals', function () {
    $doneWithdrawals = Withdrawal::where('status', 'payment done')->get();

    $fixed = 0;
    $skipped = 0;

    foreach ($doneWithdrawals as $withdrawal) {
        $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();
        if (!$wallet) { $skipped++; continue; }

        if ($withdrawal->payment_method === 'upi') {
            $methodDetail = 'UPI (' . ($withdrawal->upi_id ?? 'N/A') . ')';
        } else {
            $methodDetail = 'Bank (' . ($withdrawal->bank_name ?? $withdrawal->payment_method) . ')';
        }

        $user = $withdrawal->user;
        $completedDesc = 'Withdrawal completed for ' . ($user ? $user->name : 'user') . ' with ' . $methodDetail;

        $updated = $wallet->completeWithdrawal($withdrawal->amount, $completedDesc);
        $updated ? $fixed++ : $skipped++;
    }

    return response()->json([
        'message' => 'Done',
        'total' => $doneWithdrawals->count(),
        'fixed' => $fixed,
        'skipped' => $skipped,
    ]);
});
