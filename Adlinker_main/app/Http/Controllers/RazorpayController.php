<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    private $razorpay;

    public function __construct()
    {
        $this->middleware(['auth', 'role:advertiser']);
        $this->razorpay = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    public function createOrder($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $order = $this->razorpay->order->create([
            'amount' => $campaign->price * 100,
            'currency' => 'USD',
            'payment_capture' => 1
        ]);

        return view('campaigns.payment', [
            'campaign' => $campaign,
            'orderId' => $order->id
        ]);
    }

    public function handlePayment(Request $request, $user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $input = $request->all();

        $signature = $request->razorpay_signature;
        $paymentId = $request->razorpay_payment_id;
        $orderId = $request->razorpay_order_id;

        $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, config('services.razorpay.secret'));

        if ($generatedSignature == $signature) {
            $campaign->update(['status' => 'active']);
            return redirect()->route('campaigns.index', ['user' => auth()->id()])
                ->with('status', 'Payment successful! Your campaign is now active.');
        }

        return redirect()->route('campaigns.index', ['user' => auth()->id()])
            ->with('error', 'Payment verification failed.');
    }
}