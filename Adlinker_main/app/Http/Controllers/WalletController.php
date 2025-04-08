<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'pending_balance' => 0]
        );

        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $completedPayments = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'payment done')
            ->sum('amount');

        $pendingPayments = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        return view('wallet.index', [
            'availableBalance' => $wallet->balance,
            'pendingPayments' => abs($pendingPayments),
            'completedPayments' => abs($completedPayments),
            'transactions' => $transactions
        ]);
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        try {
            if ($wallet->deposit($request->amount)) {
                return redirect()->back()->with('success', 'Funds added successfully');
            }
            return redirect()->back()->with('error', 'Failed to add funds');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your deposit');
        }
    }

    public function showWithdrawForm()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        return view('wallet.withdraw', [
            'availableBalance' => $wallet->balance
        ]);
    }

    public function processWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:upi,bank_transfer'
        ]);

        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        try {
            if ($wallet->withdraw($request->amount)) {
                // Create withdrawal record
                $withdrawal = new \App\Models\Withdrawal([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                // Set payment details based on payment method
                if ($request->payment_method === 'upi') {
                    $withdrawal->first_name = $request->first_name_upi;
                    $withdrawal->upi_id = $request->upi_id;
                    $withdrawal->mobile_number = $request->mobile_number_upi;
                } else {
                    $withdrawal->account_holder_name = $request->account_holder_name;
                    $withdrawal->account_number = $request->account_number;
                    $withdrawal->ifsc_code = $request->ifsc_code;
                    $withdrawal->bank_name = $request->bank_name;
                    $withdrawal->mobile_number = $request->mobile_number_bank;
                }

                $withdrawal->save();

                return redirect()->route('publisher.wallet.index', ['id' => $user->id])->with('success', 'Your withdrawal request has been sent successfully. The amount will be credited to your account within 2 business days.');
            }
            return redirect()->back()->with('error', 'Insufficient funds');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your withdrawal');
        }
    }
}