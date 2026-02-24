<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_method',
        'payment_details',
        'notes',
        'processed_at',
        'upi_id',
        'first_name',
        'mobile_number',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}