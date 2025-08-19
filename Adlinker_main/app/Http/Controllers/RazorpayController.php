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
            $input = $request->only(['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature', 'fullName', 'mobileNumber']);

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

            try {
                $this->razorpay->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                Log::error('Signature verification failed: ' . $e->getMessage());
                return response()->json(['error' => 'Invalid payment signature'], 400);
            }

            // Payment verified successfully
            Log::info('Payment verification successful for Payment ID: ' . $input['razorpay_payment_id']);

            try {
                // Get payment details from Razorpay
                $payment = $this->razorpay->payment->fetch($input['razorpay_payment_id']);
                if ($payment->status !== 'captured') {
                    Log::error('Payment not captured. Status: ' . $payment->status);
                    return response()->json(['error' => 'Payment not captured'], 400);
                }
            } catch (\Exception $e) {
                Log::error('Failed to fetch payment details: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to verify payment status'], 500);
            }

            $amount = $payment->amount / 100; // Convert from paise to rupees

            // Get user's wallet
            $user = auth()->user();
            try {
                $wallet = \App\Models\Wallet::where('user_id', $user->id)->firstOrFail();
            } catch (\Exception $e) {
                Log::error('Wallet not found for user: ' . $user->id);
                return response()->json(['error' => 'Wallet not found'], 404);
            }

            DB::beginTransaction();
            try {
                // Update wallet balance directly
                // Remove the currency conversion to keep the same amount
                // $usdAmount = $amount/85;
                $oldBalance = $wallet->balance;
                $wallet->balance += $amount; // Use the original amount without conversion
                
                if (!$wallet->save()) {
                    throw new \Exception('Failed to update wallet balance');
                }

                // Create transaction record
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $amount, // Use the original amount
                    'type' => 'credit',
                    'status' => 'completed',
                    'payment_id' => $input['razorpay_payment_id'],
                    'order_id' => $input['razorpay_order_id'],
                    'full_name' => $input['fullName'],
                    'mobile_number' => $input['mobileNumber']
                ]);

                if (!$transaction) {
                    throw new \Exception('Failed to create transaction record');
                }

                // Create wallet transaction record for tracking
                $walletTransaction = WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $amount, // Use the original amount
                    'type' => 'credit',
                    'status' => 'completed',
                    'description' => 'Payment via Razorpay (ID: ' . $input['razorpay_payment_id'] . ') - INR ' . $amount,
                    
                ]);

                if (!$walletTransaction) {
                    throw new \Exception('Failed to create wallet transaction record');
                }

                DB::commit();
                Log::info('Payment processed successfully. User ID: ' . $user->id . ', Amount: INR ' . $amount . ', New Balance: ' . $wallet->balance);
                return response()->json([
                    'success' => true,
                    'message' => 'Payment verified and funds added successfully',
                    'amount_added' => $amount,
                    'new_balance' => $wallet->balance
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction Creation Error: ' . $e->getMessage() . '\nStack trace: ' . $e->getTraceAsString());
                return response()->json(['error' => 'Failed to process transaction: ' . $e->getMessage()], 500);
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
