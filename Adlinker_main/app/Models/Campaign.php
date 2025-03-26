<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'publisher_id',
        'advertiser_id',
        'channel_id',
        'channel_name',
        'subscribers',
        'channel_link',
        'duration',
        'price',
        'advertisement_image',
        'advertisement_content',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subscribers' => 'integer',
        'duration' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}