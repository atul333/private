<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertiser_id',
        'publisher_id',
        'instagram_profile_id',
        'media_type',
        'media_file',
        'caption',
        'mention_required',
        'status',
        'price',
        'paid',
    ];

    protected $casts = [
        'mention_required' => 'boolean',
        'price' => 'decimal:2',
        'paid' => 'boolean',
    ];

    /**
     * Get the advertiser that created the campaign.
     */
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    /**
     * Get the publisher assigned to the campaign.
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    /**
     * Get the Instagram profile for this campaign.
     */
    public function instagramProfile()
    {
        return $this->belongsTo(InstagramProfile::class, 'instagram_profile_id');
    }

    /**
     * Scope a query to only include pending campaigns.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved campaigns.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include completed campaigns.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include paid campaigns.
     */
    public function scopePaid($query)
    {
        return $query->where('paid', true);
    }
}
