<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'industry',
        'company_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}