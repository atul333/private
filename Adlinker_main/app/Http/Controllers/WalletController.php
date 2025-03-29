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
            ->take(10)
            ->get();

        return view('wallet.index', [
            'availableBalance' => $wallet->balance,
            'pendingPayments' => $wallet->pending_balance,
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

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        try {
            if ($wallet->withdraw($request->amount)) {
                return redirect()->back()->with('success', 'Withdrawal successful');
            }
            return redirect()->back()->with('error', 'Insufficient funds');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your withdrawal');
        }
    }
}