<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'pending_balance'];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function deposit(float $amount, ?string $description = null): bool
    {
        return $this->createTransaction([
            'type' => 'deposit',
            'amount' => $amount,
            'status' => 'completed',
            'description' => $description ?? 'Wallet deposit',
        ]);
    }

    public function withdraw(float $amount, ?string $payment_method = null, ?string $description = null): bool
    {
        // Convert INR to USD for comparison
        $usdAmount = $amount;
        
        if ($this->balance < $usdAmount) {
            return false;
        }

        $this->balance -= $usdAmount;
        $this->pending_balance += $usdAmount;
        
        if ($this->save()) {
            return $this->transactions()->create([
                'type' => 'withdrawal',
                'amount' => -$amount,
                'status' => 'pending',
                'description' => $description ?? $payment_method,
            ]) ? true : false;
        }

        return false;
    }

    protected function createTransaction(array $attributes): bool
    {
        try {
            DB::beginTransaction();
            
            // Create the transaction
            $transaction = $this->transactions()->create([
                'type' => $attributes['type'],
                'amount' => $attributes['amount'],
                'status' => $attributes['status'],
                'description' => $attributes['description']
            ]);

            if ($transaction) {
                // Update wallet balance
                $this->balance += $attributes['amount'];
                $saved = $this->save();
                
                if ($saved) {
                    DB::commit();
                    return true;
                }
            }
            
            DB::rollBack();
            return false;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Wallet transaction failed', [
                'error' => $e->getMessage(),
                'wallet_id' => $this->id,
                'attributes' => $attributes
            ]);
            return false;
        }
    }

    /**
     * Mark a pending withdrawal transaction as completed with an updated description.
     * Call this when admin marks a withdrawal as 'payment done'.
     */
    public function completeWithdrawal(float $amount, string $completedDesc): bool
    {
        $transaction = $this->transactions()
            ->where('type', 'withdrawal')
            ->where('status', 'pending')
            ->where('amount', -$amount)
            ->latest()
            ->first();

        if ($transaction) {
            $transaction->description = $completedDesc;
            $transaction->status = 'completed';
            return $transaction->save();
        }

        return false;
    }
}