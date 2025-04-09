<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            $transactionDescription = sprintf(
                'Wallet withdrawal %s - $%.2f',
                $payment_method ,
                $amount
            );

            return $this->transactions()->create([
                'type' => 'withdrawal',
                'amount' => -$amount,
                'status' => 'pending',
                'description' => $description ?? $transactionDescription,
            ]) ? true : false;
        }

        return false;
    }

    protected function createTransaction(array $attributes): bool
    {
        // Convert INR to USD by dividing by 85
        $attributes['amount'] = $attributes['amount'] ;
        
        $transaction = $this->transactions()->create($attributes);

        if ($transaction) {
            $this->balance += $attributes['amount'];
            return $this->save();
        }

        return false;
    }
}