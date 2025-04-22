<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignRefundController extends Controller
{
    public function refund(Request $request, Campaign $campaign)
    {
        try {
            DB::beginTransaction();

            // Get advertiser's wallet
            $advertiserWallet = Wallet::where('user_id', $campaign->advertiser_id)->firstOrFail();

            // Process refund
            $refundAmount = $campaign->price;
            $refundDescription = sprintf(
                'Refund received for Campaign #%d - %s (Amount: $%.2f)',
                $campaign->id,
                $campaign->title,
                $refundAmount
            );
            $advertiserWallet->deposit($refundAmount, $refundDescription);

            // Update campaign status
            $campaign->update([
                'status' => 'refunded'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process refund'
            ], 500);
        }
    }
}