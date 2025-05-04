<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    private $token;
    private $apiBaseUrl;
    private $client;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        if (!$this->token) {
            Log::error('Telegram bot token not configured');
            throw new \Exception('Telegram bot token not configured');
        }
        
        $this->apiBaseUrl = "https://api.telegram.org/bot{$this->token}";
        $this->client = new Client();
        
        // Set up webhook URL with secure HTTPS domain
        $webhookUrl = 'https://www.socialadlinker.com/api/telegram/webhook';
        $response = $this->setWebhook($webhookUrl);
        
        if (!$response || isset($response['error_code'])) {
            Log::error('Failed to set webhook:', ['response' => $response]);
            throw new \Exception('Failed to set Telegram webhook');
        }
        
        Log::info('Webhook setup successful:', ['webhook_url' => $webhookUrl]);
    }

    public function sendMessage($chatId, $message)
    {
        try {
            $response = $this->client->post("{$this->apiBaseUrl}/sendMessage", [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Telegram notification error: ' . $e->getMessage());
            return false;
        }
    }

    public function setWebhook($url)
    {
        try {
            $response = $this->client->post("{$this->apiBaseUrl}/setWebhook", [
                'json' => ['url' => $url]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Telegram webhook setup error: ' . $e->getMessage());
            return false;
        }
    }

    public function handleUpdate($update)
    {
        try {
            Log::info('Received Telegram update:', ['update' => $update]);
            
            if (!isset($update['message'])) {
                Log::warning('Update does not contain message data');
                return;
            }

            $message = $update['message'];
            if (!isset($message['chat']['id'])) {
                Log::warning('Message does not contain chat ID');
                return;
            }

            $chatId = $message['chat']['id'];
            $text = $message['text'] ?? '';
            Log::info('Processing message:', ['chat_id' => $chatId, 'text' => $text]);

            if ($text === '/start') {
                return $this->handleStartCommand($chatId);
            }

            // Log unhandled command
            Log::info('Unhandled command received:', ['text' => $text]);
            return $this->sendMessage($chatId, "I don't understand that command. Use /start to begin.");

        } catch (\Exception $e) {
            Log::error('Telegram update handling error: ' . $e->getMessage(), [
                'exception' => $e,
                'update' => $update
            ]);
            return false;
        }
    }

    private function handleStartCommand($chatId)
    {
        $welcomeMessage = "Welcome to SocialAdLinker Notification Bot!\n";
        $welcomeMessage .= "Please use your website credentials to link your account.";
        
        return $this->sendMessage($chatId, $welcomeMessage);
    }
}