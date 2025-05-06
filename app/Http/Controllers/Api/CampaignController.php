<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Events\CampaignCompleted;

class CampaignController extends Controller
{
    public function complete(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $campaign = Campaign::findOrFail($id);
            
            // Check if campaign is already completed
            if ($campaign->status === 'completed') {
                return response()->json(['message' => 'Campaign is already completed'], Response::HTTP_BAD_REQUEST);
            }
            
            // Only complete if campaign is active or ended
            if ($campaign->status !== 'active' && $campaign->status !== 'ended') {
                return response()->json(['message' => 'Campaign is not eligible for completion'], Response::HTTP_BAD_REQUEST);
            }

            $publisher = User::findOrFail($campaign->publisher_id);
            $wallet = Wallet::firstOrCreate(['user_id' => $publisher->id], ['balance' => 0]);
            
            // Deposit the campaign price to the publisher's wallet
            if (!$wallet->deposit($campaign->price, "Payout for Campaign #{$campaign->id} on {$campaign->channel_name} for {$campaign->duration} days")) {
                throw new \Exception('Failed to process wallet transaction');
            }

            $campaign->status = 'completed';
            $campaign->save();
            
            // Dispatch campaign completed event
            event(new CampaignCompleted($campaign));
            
            return response()->json([
                'success' => true,
                'message' => 'Campaign completed and payout processed successfully',
                'amount_paid' => $campaign->price
            ]);
        });
    }
} 