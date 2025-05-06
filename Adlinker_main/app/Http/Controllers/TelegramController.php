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
            Log::info('Telegram webhook received:', [
                'data' => $data,
                'headers' => $request->headers->all(),
                'method' => $request->method(),
                'url' => $request->fullUrl()
            ]);

            if (!isset($data['message'])) {
                Log::warning('Message data not found in webhook', ['data' => $data]);
                throw new \Exception('Message data not found in webhook');
            }

            $response = $this->telegramService->handleUpdate($data);
            Log::info('Telegram webhook response:', ['response' => $response]);
            return response()->json(['status' => 'success', 'response' => $response]);
            
        } catch (\Exception $e) {
            Log::error('Telegram webhook error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}