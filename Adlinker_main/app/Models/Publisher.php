<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'user_id',
        'website_url',
        'website_category',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}