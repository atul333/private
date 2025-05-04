<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    private $token;
    private $apiBaseUrl;
    private $client;
    private $currentUpdate;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
        if (!$this->token) {
            Log::error('Telegram bot token not configured');
            throw new \Exception('Telegram bot token not configured');
        }
        
        $this->apiBaseUrl = "https://api.telegram.org/bot{$this->token}";
        $this->client = new Client();
    }

    public function initializeWebhook()
    {
        // Set up webhook URL with secure HTTPS domain
        $webhookUrl = config('app.url') . '/api/telegram/webhook';
        $response = $this->setWebhook($webhookUrl);
        
        if (!$response || isset($response['error_code'])) {
            Log::error('Failed to set webhook:', ['response' => $response]);
            throw new \Exception('Failed to set Telegram webhook');
        }
        
        Log::info('Webhook setup successful:', ['webhook_url' => $webhookUrl]);
        return $response;
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
            $this->currentUpdate = $update;
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
        // Get user's first name from the message data
        $firstName = $this->currentUpdate['message']['from']['first_name'] ?? 'User';
        $welcomeMessage = "👋 Hello {$firstName}!\n🎉 Welcome to SocialAdLinker Notification Bot! 🎉\n\n";
        $welcomeMessage .= "I'm here to help you stay updated with your campaigns and wallet activities.\n\n";
        $welcomeMessage .= "🔗 To get started:\n";
        $welcomeMessage .= "1. Log in to your SocialAdLinker account\n";
        $welcomeMessage .= "2. Go to your profile settings\n";
        $welcomeMessage .= "3. Click on 'Link Telegram Account'\n\n";
        $welcomeMessage .= "Once linked, you'll receive instant notifications about:\n";
        $welcomeMessage .= "✅ Campaign updates\n";
        $welcomeMessage .= "💰 Wallet transactions\n";
        $welcomeMessage .= "📊 Performance metrics\n\n";
        $welcomeMessage .= "Need help? Contact our support team through the website.";
        
        return $this->sendMessage($chatId, $welcomeMessage);
    }
}