<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

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

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

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

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $campaign->update(['status' => 'active']);

            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('status', 'Payment successful! Your campaign is now active.');

        } catch (\Exception $e) {
            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('error', 'Payment verification failed. Please try again.');
        }
    }
}