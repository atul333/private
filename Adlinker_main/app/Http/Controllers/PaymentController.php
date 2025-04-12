<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:advertiser']);
    }

    public function initiate($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));

        $order = $api->order->create([
            'amount' => $campaign->price * 100,
            'currency' => 'USD',
            'payment_capture' => 1
        ]);

        return view('campaigns.payment', [
            'campaign' => $campaign,
            'orderId' => $order->id
        ]);
    }

    public function complete(Request $request, $user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        if (!$request->razorpay_order_id || !$request->razorpay_payment_id || !$request->razorpay_signature) {
            Log::error('Missing required payment parameters for campaign: ' . $campaign->id);
            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('error', 'Invalid payment request. Please try again.');
        }

        // Validate Razorpay configuration
        if (!config('razorpay.key_id') || !config('razorpay.key_secret')) {
            Log::error('Razorpay configuration missing');
            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('error', 'Payment system configuration error. Please contact support.');
        }

        $api = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
        
        Log::info('Payment verification initiated', [
            'campaign_id' => $campaign->id,
            'order_id' => $request->razorpay_order_id,
            'payment_id' => $request->razorpay_payment_id
        ]);

        try {
            // Log payment request details
            Log::info('Payment verification attempt for campaign: ' . $campaign->id, [
                'order_id' => $request->razorpay_order_id,
                'payment_id' => $request->razorpay_payment_id,
                'campaign_price' => $campaign->price
            ]);

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            // Verify payment signature
            try {
                $api->utility->verifyPaymentSignature($attributes);
                Log::info('Payment signature verified successfully', [
                    'campaign_id' => $campaign->id,
                    'payment_id' => $request->razorpay_payment_id
                ]);
            } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
                Log::error('Payment signature verification failed for campaign: ' . $campaign->id, [
                    'error' => $e->getMessage(),
                    'attributes' => $attributes,
                    'key_id_exists' => !empty(config('razorpay.key_id')),
                    'key_secret_exists' => !empty(config('razorpay.key_secret'))
                ]);
                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('error', 'Payment signature verification failed. Please try again.');
            }

            // Get payment details from Razorpay
            try {
                $payment = $api->payment->fetch($request->razorpay_payment_id);
                Log::info('Payment details fetched successfully', [
                    'campaign_id' => $campaign->id,
                    'payment_id' => $request->razorpay_payment_id,
                    'payment_status' => $payment->status,
                    'amount' => $payment->amount
                ]);
            } catch (\Razorpay\Api\Errors\Error $e) {
                Log::error('Failed to fetch payment details for campaign: ' . $campaign->id, [
                    'error' => $e->getMessage(),
                    'payment_id' => $request->razorpay_payment_id,
                    'code' => $e->getCode()
                ]);
                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('error', 'Unable to verify payment status. Please contact support.');
            }

            // Verify payment amount matches campaign price
            if ($payment->amount != $campaign->price * 100) {
                Log::error('Payment amount mismatch for campaign: ' . $campaign->id, [
                    'expected_amount' => $campaign->price * 100,
                    'actual_amount' => $payment->amount
                ]);
                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('error', 'Payment amount verification failed.');
            }

            // Verify payment status
            if ($payment->status !== 'captured') {
                Log::error('Payment not captured for campaign: ' . $campaign->id, [
                    'payment_status' => $payment->status,
                    'payment_id' => $request->razorpay_payment_id,
                    'order_id' => $request->razorpay_order_id
                ]);
                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('error', 'Payment not completed. Please try again.');
            }

            // Start database transaction
            DB::beginTransaction();
            try {
                // Update campaign payment status
                $campaign->update([
                    'payment_status' => 'completed',
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_order_id' => $request->razorpay_order_id
                ]);

                DB::commit();
                Log::info('Payment completed successfully for campaign: ' . $campaign->id);

                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('success', 'Payment successful! Your campaign has been activated.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to update campaign after payment: ' . $campaign->id, [
                    'error' => $e->getMessage()
                ]);
                return redirect()->route('campaigns.index', ['user' => auth()->id()])
                    ->with('error', 'Payment processed but failed to update campaign. Please contact support.');
            }

            // Update campaign status after successful payment verification
            try {
                \Illuminate\Support\Facades\DB::beginTransaction();
                $campaign->update([
                    'status' => 'active',
                    'payment_status' => 'completed',
                    'payment_id' => $payment->id,
                    'paid_amount' => $payment->amount / 100,
                    'payment_currency' => $payment->currency,
                    'payment_completed_at' => now()
                ]);
                \Illuminate\Support\Facades\DB::commit();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\DB::rollBack();
                Log::error('Failed to update campaign status after payment: ' . $campaign->id, [
                    'error' => $e->getMessage(),
                    'payment_id' => $payment->id,
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Attempt to refund the payment if campaign update fails
                try {
                    $refund = $api->refund->create([
                        'payment_id' => $payment->id,
                        'amount' => $payment->amount,
                        'speed' => 'normal'
                    ]);
                    
                    Log::info('Payment refunded due to campaign update failure', [
                        'campaign_id' => $campaign->id,
                        'payment_id' => $payment->id,
                        'refund_id' => $refund->id
                    ]);
                    
                    return redirect()->route('campaigns.index', ['user' => auth()->id()])
                        ->with('error', 'Payment was processed but campaign activation failed. A refund has been initiated.');
                } catch (\Exception $refundError) {
                    Log::error('Refund failed after campaign update error', [
                        'campaign_id' => $campaign->id,
                        'payment_id' => $payment->id,
                        'error' => $refundError->getMessage()
                    ]);
                    return redirect()->route('campaigns.index', ['user' => auth()->id()])
                        ->with('error', 'Payment processed but campaign activation failed. Our team will process your refund manually.');
                }
            }

            // Log successful payment
            Log::info('Payment successful for campaign: ' . $campaign->id, [
                'payment_id' => $payment->id,
                'amount' => $payment->amount / 100,
                'currency' => $payment->currency
            ]);

            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('status', 'Payment successful! Your campaign is now active.');

        } catch (\Exception $e) {
            Log::error('Unexpected error during payment processing for campaign: ' . $campaign->id, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('error', 'An unexpected error occurred. Please try again or contact support.');
        }
    }
}