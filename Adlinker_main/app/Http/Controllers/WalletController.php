<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Withdrawal;
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

        // Auto-sync: ensure every "payment done" withdrawal has a completed wallet transaction
        $this->syncWithdrawalTransactions($wallet, $user->id);

        $transactions = $wallet->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $completedPayments = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'payment done')
            ->sum('amount');

        $pendingPayments = \App\Models\Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');

        // Convert all amounts from INR to USD
        return view('wallet.index', [
            'availableBalance' => $wallet->balance,
            'pendingPayments'  => abs($pendingPayments),
            'completedPayments'=> abs($completedPayments),
            'transactions'     => $transactions
        ]);
    }

    /**
     * Auto-sync wallet transactions for "payment done" withdrawals.
     * Uses withdrawal ID as a unique marker to avoid false dedup matches.
     */
    private function syncWithdrawalTransactions(Wallet $wallet, int $userId): void
    {
        $doneWithdrawals = Withdrawal::where('user_id', $userId)
            ->where('status', 'payment done')
            ->get();

        foreach ($doneWithdrawals as $withdrawal) {
            $methodDetail = $this->buildMethodDetail($withdrawal);
            $user         = $withdrawal->user;
            $userName     = $user ? $user->name : 'user';
            $marker       = '[wd:' . $withdrawal->id . ']';

            $completedDesc = 'Withdrawal completed for ' . $userName . ' with ' . $methodDetail;

            // Check if already synced using the unique marker in description
            $alreadySynced = $wallet->transactions()
                ->where('type', 'withdrawal')
                ->where('status', 'completed')
                ->where('description', 'like', '%' . $marker)
                ->exists();

            if ($alreadySynced) {
                continue;
            }

            // Look for a pending transaction tagged with this withdrawal's marker
            $pendingTx = $wallet->transactions()
                ->where('type', 'withdrawal')
                ->where('status', 'pending')
                ->where('description', 'like', '%' . $marker)
                ->latest()
                ->first();

            if ($pendingTx) {
                // Upgrade the pending transaction to completed
                $pendingTx->description = $completedDesc . ' ' . $marker;
                $pendingTx->status      = 'completed';
                $pendingTx->save();
            } else {
                // No tagged transaction found — create a fresh completed one
                $wallet->transactions()->create([
                    'type'        => 'withdrawal',
                    'amount'      => -$withdrawal->amount,
                    'status'      => 'completed',
                    'description' => $completedDesc . ' ' . $marker,
                ]);
            }

            // Reduce pending_balance if it's still holding this amount
            if ($wallet->pending_balance >= $withdrawal->amount) {
                $wallet->pending_balance -= $withdrawal->amount;
                $wallet->save();
            }
        }
    }

    private function buildMethodDetail(Withdrawal $withdrawal): string
    {
        if ($withdrawal->payment_method === 'upi') {
            return 'UPI (' . ($withdrawal->upi_id ?? 'N/A') . ')';
        }
        return 'Bank (' . ($withdrawal->bank_name ?? $withdrawal->payment_method) . ')';
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1' // Minimum 1 INR
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

    public function showAddFundsForm()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        return view('wallet.add-funds', [
            'availableBalance' => $wallet->balance
        ]);
    }

    public function showWithdrawForm()
    {
        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        return view('wallet.withdraw', [
            'availableBalance' => $wallet->balance
        ]);
    }

    public function addFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'fullName' => 'required|string|max:255',
            'mobileNumber' => 'required|string|max:20'
        ]);

        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();
        
        try {
            // Amount is in INR, will be converted to USD in deposit method
            if ($wallet->deposit($request->amount)) {
                // Create transaction record with INR amount (will be converted to USD in createTransaction)
                $wallet->transactions()->create([
                    'amount' => $request->amount,
                    'type' => 'credit',
                    'description' => 'Funds added by ' . $request->fullName . ' (INR ' . number_format($request->amount, 2) . ')',
                    'full_name' => $request->fullName,
                    'mobile_number' => $request->mobileNumber
                ]);
                
                return redirect()->back()->with('success', 'Funds added successfully');
            }
            return redirect()->back()->with('error', 'Failed to add funds');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your payment');
        }
    }

    public function processWithdrawal(Request $request)
    {
        $rules = [
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:upi,bank_transfer'
        ];

        if ($request->payment_method === 'upi') {
            $rules = array_merge($rules, [
                'first_name_upi' => 'required|string|max:255',
                'upi_id' => 'required|string|max:255',
                'mobile_number_upi' => 'required|string|max:20'
            ]);
        } else {
            $rules = array_merge($rules, [
                'account_holder_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:50',
                'ifsc_code' => 'required|string|max:20',
                'bank_name' => 'required|string|max:255',
                'mobile_number_bank' => 'required|string|max:20'
            ]);
        }

        $request->validate($rules);

        $user = auth()->user();
        $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

        try {
            // Build a descriptive string including payment details
            if ($request->payment_method === 'upi') {
                $methodDetail = 'UPI (' . $request->upi_id . ')';
            } else {
                $methodDetail = 'Bank (' . $request->bank_name . ')';
            }
            $initiatedDesc = 'Withdrawal initiated for ' . $user->name . ' with ' . $methodDetail;

            if ($wallet->withdraw($request->amount, $request->payment_method, $initiatedDesc)) {
                // Create withdrawal record
                $withdrawal = new \App\Models\Withdrawal([
                    'user_id'        => $user->id,
                    'amount'         => $request->amount,
                    'status'         => 'pending',
                    'payment_method' => $request->payment_method,
                ]);

                // Set payment details based on payment method
                if ($request->payment_method === 'upi') {
                    $withdrawal->first_name    = $request->first_name_upi;
                    $withdrawal->upi_id        = $request->upi_id;
                    $withdrawal->mobile_number = $request->mobile_number_upi;
                } else {
                    $withdrawal->account_holder_name = $request->account_holder_name;
                    $withdrawal->account_number      = $request->account_number;
                    $withdrawal->ifsc_code           = $request->ifsc_code;
                    $withdrawal->bank_name           = $request->bank_name;
                    $withdrawal->mobile_number       = $request->mobile_number_bank;
                }

                $withdrawal->save();

                // Backpatch the wallet transaction with the unique [wd:ID] marker
                $marker = '[wd:' . $withdrawal->id . ']';
                $wallet->transactions()
                    ->where('type', 'withdrawal')
                    ->where('status', 'pending')
                    ->whereRaw('ABS(amount) = ?', [$withdrawal->amount])
                    ->latest()
                    ->first()
                    ?->update(['description' => $initiatedDesc . ' ' . $marker]);

                return redirect()->route('publisher.wallet.index', ['id' => $user->id])->with('success', 'Your withdrawal request has been sent successfully. The amount will be credited to your account within 2 business days.');
            }
            return redirect()->back()->with('error', 'Insufficient funds');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing your withdrawal');
        }
    }

    /**
     * Mark a withdrawal as payment done (called after admin approves).
     * Updates the transaction description and moves balance from pending to completed.
     */
    public function markPaymentDone(Request $request, $withdrawalId)
    {
        $withdrawal = Withdrawal::findOrFail($withdrawalId);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This withdrawal is not in pending state.');
        }

        $user = $withdrawal->user;
        $wallet = Wallet::where('user_id', $user->id)->first();

        // Build the completed description
        if ($withdrawal->payment_method === 'upi') {
            $methodDetail = 'UPI (' . $withdrawal->upi_id . ')';
        } else {
            $methodDetail = 'Bank (' . $withdrawal->bank_name . ')';
        }
        $completedDesc = 'Withdrawal completed for ' . $user->name . ' with ' . $methodDetail;

        // Update the wallet transaction description
        if ($wallet) {
            $wallet->completeWithdrawal($withdrawal->amount, $completedDesc);
            // Move from pending_balance
            $wallet->pending_balance = max(0, $wallet->pending_balance - $withdrawal->amount);
            $wallet->save();
        }

        // Mark withdrawal as done
        $withdrawal->status = 'payment done';
        $withdrawal->processed_at = now();
        $withdrawal->save();

        return redirect()->back()->with('success', 'Withdrawal marked as payment done.');
    }
}