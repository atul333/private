<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'title',
        'description',
        'image_url',
        'target_url',
        'status',
        'budget',
        'impressions',
        'clicks'
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'impressions' => 'integer',
        'clicks' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}