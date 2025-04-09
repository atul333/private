<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\WalletTransaction;
use App\Models\Transaction;

class RazorpayController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(config('razorpay.key_id'), config('razorpay.key_secret'));
    }

    public function createOrder(Request $request)
    {
        try {
            $amount = $request->input('amount');
            if (empty($amount) || !is_numeric($amount)) {
                return response()->json(['error' => 'Invalid amount'], 400);
            }

            $order = $this->razorpay->order->create([
                'amount' => $amount * 100, // Convert to smallest currency unit (paise)
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            return response()->json([
                'order_id' => $order->id,
                'amount' => $amount,
                'currency' => 'INR',
                'key' => config('razorpay.key_id')
            ]);

        } catch (\Exception $e) {
            Log::error('Order Creation Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            // Fetch payment input from frontend
            $input = $request->only(['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature']);

            // Log input data for debugging
            Log::info('Razorpay Payment Verification Input:', $input);

            // Validate input fields
            if (empty($input['razorpay_payment_id']) || empty($input['razorpay_order_id']) || empty($input['razorpay_signature'])) {
                Log::error('Missing payment details in request');
                return response()->json(['error' => 'Missing payment details'], 400);
            }

            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature' => $input['razorpay_signature'],
            ];

            $this->razorpay->utility->verifyPaymentSignature($attributes);

            // Payment verified successfully
            Log::info('Payment verification successful for Payment ID: ' . $input['razorpay_payment_id']);

            // Get payment details from Razorpay
            $payment = $this->razorpay->payment->fetch($input['razorpay_payment_id']);
            $amount = $payment->amount / 100; // Convert from paise to rupees

            // Get user's wallet
            $user = auth()->user();
            $wallet = \App\Models\Wallet::where('user_id', $user->id)->firstOrFail();

            DB::beginTransaction();
            try {
                // Update wallet balance directly
                $usdAmount = $amount/85 ;
                $wallet->balance += $usdAmount;
                if ($wallet->save()) {
                        // Create transaction record
                    // Convert INR to USD (1 USD = 85 INR)
                   
                    
                    Transaction::create([
                        'user_id' => $user->id,
                        'amount' => $usdAmount,
                        'type' => 'credit',
                        'status' => 'completed',
                        'payment_id' => $input['razorpay_payment_id'],
                        'order_id' => $input['razorpay_order_id']
                    ]);

                    // Create wallet transaction record for tracking
                    WalletTransaction::create([
                        'wallet_id' => $wallet->id,
                        'amount' => $usdAmount,
                        'type' => 'credit',
                        'status' => 'completed',
                        'description' => 'Payment via Razorpay (ID: ' . $input['razorpay_payment_id'] . ') - Converted from INR ' . $amount,
                        'full_name' => $request->input('full_name', $user->name),
                        'mobile_number' => $request->input('mobile_number', $user->mobile_number ?? '')
                    ]);

                    DB::commit();
                    return response()->json(['success' => 'Payment verified and funds added successfully'], 200);
                }

                DB::rollBack();
                return response()->json(['error' => 'Failed to add funds to wallet'], 400);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction Creation Error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to process transaction'], 500);
            }

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            // Razorpay Signature verification failed
            Log::error('Signature Verification Error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment verification failed'], 400);

        } catch (\Exception $e) {
            // Other errors
            Log::error('Payment Verification Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Payment verification failed'], 400);
        }
    }
}
