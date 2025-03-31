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
        'status',
        'post_link',
        'notes',
        'submission_timestamp',
        'post_submitted_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subscribers' => 'integer',
        'duration' => 'integer',
        'submission_timestamp' => 'datetime',
        'post_submitted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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