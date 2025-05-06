<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\TelegramNotification;

class TelegramNotificationService
{
    private $token;
    private $apiBaseUrl;
    private $client;
    private $currentUpdate;
    private $userStates = [];

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

            // Check if user is authenticated
            $isAuthenticated = $this->isUserAuthenticated($chatId);

            if ($text === '/start') {
                return $this->handleStartCommand($chatId);
            }

            // Handle authentication flow
            if (!$isAuthenticated) {
                return $this->handleAuthenticationFlow($chatId, $text);
            }

            // Handle other commands for authenticated users
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
        try {
            // Check if user is already authenticated
            $telegramNotification = TelegramNotification::where('chat_id', $chatId)
                ->where('is_active', true)
                ->with(['user', 'user.wallet', 'user.advertiser', 'user.publisher'])
                ->first();

            if ($telegramNotification && $telegramNotification->user) {
                $user = $telegramNotification->user;
                
                // Get user statistics
                $walletBalance = $user->wallet ? $user->wallet->balance : 0;
                
                $message = "👋 Hello {$user->name}!\n\n";
                $message .= "💰 Your Wallet Balance: $" . number_format($walletBalance, 2) . "\n\n";

                // Check if user is an advertiser
                if ($user->advertiser) {
                    $campaignCount = $user->advertiser->campaigns()->count();
                    $activeCampaigns = $user->advertiser->campaigns()->where('status', 'active')->count();
                    
                    $message .= "📊 Advertiser Statistics:\n";
                    $message .= "━━━━━━━━━━━━━━━━━━━━━\n";
                    $message .= "🎯 Total Campaigns: {$campaignCount}\n";
                    $message .= "✅ Active Campaigns: {$activeCampaigns}\n";
                }

                // Check if user is a publisher
                if ($user->publisher) {
                    $channels = $user->publisher->channels()
                        ->withCount(['campaigns' => function($query) {
                            $query->where('status', 'active');
                        }])
                        ->get();
                    
                    $message .= "\n📺 Your Channels:\n";
                    $message .= "━━━━━━━━━━━━━━━━━━━━━\n";
                    
                    foreach ($channels as $channel) {
                        $message .= "• {$channel->name}\n";
                        $message .= "  📢 Active Campaigns: {$channel->campaigns_count}\n";
                    }
                }

                $message .= "\n📋 Available Commands:\n";
                $message .= "/stats - View detailed statistics\n";
                $message .= "/balance - Check wallet balance\n";
                $message .= "/campaigns - List your campaigns\n";
                $message .= "/help - Get help\n\n";
                $message .= "Need assistance? Contact our support team through the website.";

                return $this->sendMessage($chatId, $message);
            }

            // For non-authenticated users, show authentication request
            $firstName = $this->currentUpdate['message']['from']['first_name'] ?? 'User';
            $welcomeMessage = "👋 Hello {$firstName}!\n\n";
            $welcomeMessage .= "🔐 To use the SocialAdLinker Notification Bot, please authenticate with your website credentials.\n\n";
            $welcomeMessage .= "Please enter your email address:";
            
            // Set user state to expecting email
            $this->setUserState($chatId, 'AWAITING_EMAIL');
            
            return $this->sendMessage($chatId, $welcomeMessage);
        } catch (\Exception $e) {
            Log::error('Error in handleStartCommand:', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId,
                'trace' => $e->getTraceAsString()
            ]);
            return $this->sendMessage($chatId, "An error occurred. Please try again later.");
        }
    }

    private function handleAuthenticationFlow($chatId, $text)
    {
        $state = $this->getUserState($chatId);
        
        switch ($state) {
            case 'AWAITING_EMAIL':
                if ($this->isValidEmail($text)) {
                    $this->setUserState($chatId, 'AWAITING_PASSWORD');
                    $this->storeTemporaryEmail($chatId, $text);
                    return $this->sendMessage($chatId, "Please enter your password:");
                } else {
                    return $this->sendMessage($chatId, "Invalid email format. Please enter a valid email address:");
                }
                break;

            case 'AWAITING_PASSWORD':
                return $this->authenticateUser($chatId, $text);
                break;

            default:
                return $this->handleStartCommand($chatId);
        }
    }

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function authenticateUser($chatId, $password)
    {
        try {
            $email = $this->getTemporaryEmail($chatId);
            
            // Attempt authentication using Laravel's Auth facade
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                
                // Link Telegram chat_id with user account
                TelegramNotification::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'chat_id' => $chatId,
                        'is_active' => true
                    ]
                );

                // Clear temporary data and state
                $this->clearUserState($chatId);
                $this->clearTemporaryEmail($chatId);

                $successMessage = "✅ Authentication successful!\n\n";
                $successMessage .= "Your Telegram account is now linked with SocialAdLinker.\n";
                $successMessage .= "You will receive notifications about:\n";
                $successMessage .= "✅ Campaign updates\n";
                $successMessage .= "💰 Wallet transactions\n";
                $successMessage .= "📊 Performance metrics\n\n";
                $successMessage .= "Need help? Contact our support team through the website.";

                return $this->sendMessage($chatId, $successMessage);
            } else {
                return $this->sendMessage($chatId, "❌ Invalid credentials. Please try again.\n\nEnter your email address:");
            }
        } catch (\Exception $e) {
            Log::error('Authentication error:', ['error' => $e->getMessage()]);
            return $this->sendMessage($chatId, "An error occurred during authentication. Please try again later.");
        }
    }

    private function isUserAuthenticated($chatId)
    {
        return TelegramNotification::where('chat_id', $chatId)
            ->where('is_active', true)
            ->exists();
    }

    private function setUserState($chatId, $state)
    {
        Cache::put("telegram_state_{$chatId}", $state, now()->addMinutes(30));
    }

    private function getUserState($chatId)
    {
        return Cache::get("telegram_state_{$chatId}");
    }

    private function clearUserState($chatId)
    {
        Cache::forget("telegram_state_{$chatId}");
    }

    private function storeTemporaryEmail($chatId, $email)
    {
        Cache::put("telegram_email_{$chatId}", $email, now()->addMinutes(30));
    }

    private function getTemporaryEmail($chatId)
    {
        return Cache::get("telegram_email_{$chatId}");
    }

    private function clearTemporaryEmail($chatId)
    {
        Cache::forget("telegram_email_{$chatId}");
    }
}