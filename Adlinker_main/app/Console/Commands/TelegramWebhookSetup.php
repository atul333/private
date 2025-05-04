<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramNotificationService;

class TelegramWebhookSetup extends Command
{
    protected $signature = 'telegram:setup-webhook';
    protected $description = 'Set up the Telegram bot webhook';

    public function handle(TelegramNotificationService $telegramService)
    {
        try {
            $response = $telegramService->initializeWebhook();
            $this->info('Webhook setup successful!');
            $this->info('Response: ' . json_encode($response, JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            $this->error('Failed to set up webhook: ' . $e->getMessage());
        }
    }
} 