<?php

namespace App\Listeners;

use App\Events\NewCampaignAssigned;
use App\Services\TelegramNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampaignNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $telegramService;

    /**
     * Create the event listener.
     */
    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    /**
     * Handle the event.
     */
    public function handle(NewCampaignAssigned $event): void
    {
        // Get the publisher's user ID from the channel
        $userId = $event->channel->publisher->user_id;

        // Send notification through Telegram
        $this->telegramService->sendCampaignNotification(
            $userId,
            $event->campaign,
            $event->channel
        );
    }
} 