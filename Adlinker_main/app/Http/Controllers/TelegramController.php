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

            if (!isset($data['message'])) {
                throw new \Exception('Message data not found in webhook');
            }

            return $this->telegramService->handleUpdate($data);
            
        } catch (\Exception $e) {
            Log::error('Telegram webhook error:', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}