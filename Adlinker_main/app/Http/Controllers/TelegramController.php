<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramNotificationService;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function handleWebhook(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('Telegram webhook received:', ['data' => $data]);

            if (isset($data['message'])) {
                $chatId = $data['message']['chat']['id'];
                $messageText = $data['message']['text'] ?? '';

                // Handle commands
                if (strpos($messageText, '/') === 0) {
                    switch ($messageText) {
                        case '/start':
                            $response = "Welcome to SocialAdLinker! 🚀\n\nI'm here to help you manage your advertising campaigns and channel monetization.";
                            break;
                        case '/help':
                            $response = "Available commands:\n/start - Start the bot\n/help - Show this help message";
                            break;
                        default:
                            $response = "Sorry, I don't understand that command. Type /help for available commands.";
                    }
                } else {
                    $response = "Please use a valid command. Type /help to see available commands.";
                }

                $this->telegramService->sendMessage($chatId, $response);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Telegram webhook error:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}