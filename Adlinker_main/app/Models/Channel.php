<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'publisher_id',
        'subscribers',
        'views'
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}