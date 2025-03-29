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

    public function deposit(float $amount, string $description = null): bool
    {
        return $this->createTransaction([
            'type' => 'deposit',
            'amount' => $amount,
            'status' => 'completed',
            'description' => $description ?? 'Wallet deposit',
        ]);
    }

    public function withdraw(float $amount, string $description = null): bool
    {
        if ($this->balance < $amount) {
            return false;
        }

        return $this->createTransaction([
            'type' => 'withdrawal',
            'amount' => -$amount,
            'status' => 'completed',
            'description' => $description ?? 'Wallet withdrawal',
        ]);
    }

    protected function createTransaction(array $attributes): bool
    {
        $transaction = $this->transactions()->create($attributes);

        if ($transaction) {
            $this->balance += $attributes['amount'];
            return $this->save();
        }

        return false;
    }
}