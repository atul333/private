<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'message',
        'admin_reply',
        'is_read',
        'is_replied',
        'read_at',
        'replied_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_replied' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 