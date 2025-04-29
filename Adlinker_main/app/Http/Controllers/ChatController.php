<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getMessages()
    {
        $messages = Message::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $user = Auth::user();
        $userType = $user->role ?? 'advertiser'; // fallback if role not set

        $message = Message::create([
            'user_id' => $user->id,
            'user_type' => $userType,
            'message' => $request->message,
            'admin_reply' => null,
            'is_read' => false,
            'is_replied' => false,
            'read_at' => null,
            'replied_at' => null
        ]);

        return response()->json($message);
    }

    public function markAsRead()
    {
        Message::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }
}