<?php

namespace App\Listeners;

use App\Events\CampaignCompleted;
use App\Services\TelegramNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampaignCompletionNotifications implements ShouldQueue
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
    public function handle(CampaignCompleted $event): void
    {
        // Send notification to advertiser
        $this->telegramService->sendAdvertiserCampaignCompletionNotification($event->campaign);

        // Send notification to publisher
        $this->telegramService->sendPublisherCampaignCompletionNotification($event->campaign);
    }
} 