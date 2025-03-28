<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'description',
        'logo_path',
        'subscribers_count',
        'price_1_day',
        'price_2_days',
        'price_3_days',
        'price_7_days',
        'status',
        'publisher_id'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}