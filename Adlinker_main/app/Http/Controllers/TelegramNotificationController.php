<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TelegramNotification;
use App\Services\TelegramNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TelegramNotificationController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function handleWebhook(Request $request)
    {
        try {
            $update = $request->all();
            $this->telegramService->handleUpdate($update);
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Webhook handling error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function linkTelegramAccount(Request $request)
    {
        try {
            $chatId = $request->input('chat_id');
            $userId = Auth::id();

            $notification = TelegramNotification::updateOrCreate(
                ['user_id' => $userId],
                ['chat_id' => $chatId, 'is_active' => true]
            );

            $welcomeMessage = "Your Telegram account has been successfully linked with SocialAdLinker!\n";
            $welcomeMessage .= "You will now receive notifications for your campaigns and wallet activities.";
            
            $this->telegramService->sendMessage($chatId, $welcomeMessage);

            return response()->json([
                'status' => 'success',
                'message' => 'Telegram account linked successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Account linking error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to link Telegram account'
            ], 500);
        }
    }

    public function sendCampaignNotification($userId, $message)
    {
        try {
            $notification = TelegramNotification::where('user_id', $userId)
                ->where('is_active', true)
                ->first();

            if ($notification) {
                $this->telegramService->sendMessage($notification->chat_id, $message);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Campaign notification error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendWalletNotification($userId, $message)
    {
        try {
            $notification = TelegramNotification::where('user_id', $userId)
                ->where('is_active', true)
                ->first();

            if ($notification) {
                $this->telegramService->sendMessage($notification->chat_id, $message);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Wallet notification error: ' . $e->getMessage());
            return false;
        }
    }
}