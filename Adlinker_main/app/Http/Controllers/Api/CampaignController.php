<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function complete($id)
    {
        return DB::transaction(function () use ($id) {
            $campaign = Campaign::findOrFail($id);
            
            if ($campaign->status !== 'active') {
                return response()->json(['message' => 'Campaign is not active'], Response::HTTP_BAD_REQUEST);
            }

            $publisher = User::findOrFail($campaign->publisher_id);
            $wallet = Wallet::firstOrCreate(['user_id' => $publisher->id], ['balance' => 0]);
            
            if (!$wallet->deposit($campaign->price, "Payment for completed campaign #{$campaign->id}")) {
                return response()->json(['message' => 'Failed to process payment'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $campaign->status = 'completed';
            $campaign->save();
            
            return response()->json(['message' => 'Campaign completed and payment processed successfully']);
        });
    }
}