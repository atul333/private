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
        try {
            $this->token = config('services.telegram.bot_token');
            Log::info('Initializing TelegramNotificationService', [
                'has_token' => !empty($this->token),
                'config_loaded' => true
            ]);

            if (!$this->token) {
                Log::error('Telegram bot token not configured');
                throw new \Exception('Telegram bot token not configured');
            }
            
            $this->apiBaseUrl = "https://api.telegram.org/bot{$this->token}";
            $this->client = new Client();
            
            Log::info('TelegramNotificationService initialized successfully', [
                'api_base_url' => $this->apiBaseUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Error initializing TelegramNotificationService', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
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
            Log::info('Attempting to send Telegram message', [
                'chat_id' => $chatId,
                'message_length' => strlen($message)
            ]);

            $response = $this->client->post("{$this->apiBaseUrl}/sendMessage", [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info('Telegram message sent successfully', [
                'chat_id' => $chatId,
                'response' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Telegram message sending error', [
                'error' => $e->getMessage(),
                'chat_id' => $chatId,
                'trace' => $e->getTraceAsString()
            ]);
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
            Log::info('Processing Telegram update', [
                'update_id' => $update['update_id'] ?? null,
                'has_message' => isset($update['message']),
                'raw_update' => $update
            ]);
            
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
            Log::info('Processing message', [
                'chat_id' => $chatId,
                'text' => $text,
                'from' => $message['from'] ?? null
            ]);

            // Check if user is authenticated
            $isAuthenticated = $this->isUserAuthenticated($chatId);
            Log::info('Authentication status', [
                'chat_id' => $chatId,
                'is_authenticated' => $isAuthenticated
            ]);

            // Handle commands
            if (strtolower($text) === '/start') {
                Log::info('Handling /start command', ['chat_id' => $chatId]);
                return $this->handleStartCommand($chatId);
            } else if (!$isAuthenticated) {
                Log::info('Handling authentication flow', ['chat_id' => $chatId]);
                return $this->handleAuthenticationFlow($chatId, $text);
            } else {
                Log::info('Handling unknown command', ['chat_id' => $chatId, 'text' => $text]);
                return $this->sendMessage($chatId, "I don't understand that command. Use /start to restart.");
            }
        } catch (\Exception $e) {
            Log::error('Error in handleUpdate', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'update' => $update
            ]);
            if (isset($chatId)) {
                return $this->sendMessage($chatId, "An error occurred. Please try again later.");
            }
            return false;
        }
    }

    private function handleStartCommand($chatId)
    {
        try {
            // Check if user is already authenticated
            $telegramNotification = TelegramNotification::where('chat_id', $chatId)
                ->where('is_active', true)
                ->with(['user' => function($query) {
                    $query->with(['wallet', 'publisher.channels']);
                }])
                ->first();

            if ($telegramNotification && $telegramNotification->user) {
                $user = $telegramNotification->user;
                
                // Get wallet balance
                $walletBalance = 0;
                if ($wallet = $user->wallet) {
                    $walletBalance = $wallet->balance ?? 0;
                }
                
                $message = "👋 Hello {$user->name}!\n\n";
                $message .= "💰 Your Wallet Balance: $" . number_format($walletBalance, 2) . "\n\n";

                // Show channels if user is a publisher
                if ($user->publisher) {
                    $message .= "📺 Your Channels:\n";
                    $message .= "━━━━━━━━━━━━━━━━━━━━━\n";
                    
                    $channels = $user->publisher->channels;
                    foreach ($channels as $channel) {
                        $message .= "• {$channel->name}\n";
                    }
                    $message .= "\n";
                }

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

                // Show welcome message
                return $this->handleStartCommand($chatId);
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