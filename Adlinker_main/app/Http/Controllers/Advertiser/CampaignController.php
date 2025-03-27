<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class CampaignController extends Controller
{
    public function completePayment(Request $request, $user, Campaign $campaign)
    {
        try {
            // Update campaign payment status
            $campaign->update([
                'payment_status' => 'completed',
                'action' => 'Payment successful'
            ]);
            
            return redirect()->route('advertiser.dashboard')
                ->with('success', 'Payment successful! Your campaign has been activated.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}