<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'is_admin_message',
        'is_read'
    ];

    protected $casts = [
        'is_admin_message' => 'boolean',
        'is_read' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 