<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function complete(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $campaign = Campaign::findOrFail($id);
            
            if ($campaign->status !== 'active') {
                return response()->json(['message' => 'Campaign is not active'], Response::HTTP_BAD_REQUEST);
            }

            $publisher = User::findOrFail($campaign->publisher_id);
            $wallet = Wallet::firstOrCreate(['user_id' => $publisher->id], ['balance' => 0]);
            
            if (!$wallet->withdraw($campaign->price, "Payment for Campaign on {$campaign->channel_name} for {$campaign->duration} days")) {
                throw new \Exception('Failed to process wallet transaction');
            }

            $campaign->status = 'completed';
            $campaign->save();
            
            return response()->json(['message' => 'Campaign completed and payment processed successfully']);
        });
    }

    public function expire(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $campaign = Campaign::findOrFail($id);
                
                // Check if the campaign belongs to the authenticated user
                if ($campaign->advertiser_id !== auth()->id()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized to expire this campaign'
                    ], 403);
                }

                // Check if campaign is already expired
                if ($campaign->status === 'expired') {
                    return response()->json([
                        'success' => true,
                        'message' => 'Campaign is already expired',
                        'status' => 'expired'
                    ]);
                }

                // Get advertiser's wallet
                $advertiserWallet = Wallet::firstOrCreate(
                    ['user_id' => $campaign->advertiser_id],
                    ['balance' => 0]
                );

                // Process refund
                if (!$advertiserWallet->deposit(
                    $campaign->price,
                    "Refund for expired campaign on {$campaign->channel_name} for {$campaign->duration} days"
                )) {
                    throw new \Exception('Failed to process refund');
                }

                // Update campaign status to expired
                $campaign->update([
                    'status' => 'expired'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Campaign expired and refund processed successfully',
                    'status' => 'expired',
                    'refunded_amount' => $campaign->price
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to expire campaign: ' . $e->getMessage()
            ], 500);
        }
    }
}