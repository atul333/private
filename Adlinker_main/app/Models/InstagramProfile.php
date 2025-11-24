<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instagram_id',
        'profile_photo',
        'followers',
        'price_per_story',
        'mention_available',
        'is_active',
    ];

    protected $casts = [
        'followers' => 'integer',
        'price_per_story' => 'decimal:2',
        'mention_available' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user (publisher) that owns the Instagram profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the publisher that owns this profile.
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'user_id', 'user_id');
    }

    /**
     * Get all campaigns for this Instagram profile.
     */
    public function campaigns()
    {
        return $this->hasMany(InstagramCampaign::class, 'instagram_profile_id');
    }

    /**
     * Scope a query to only include active profiles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
