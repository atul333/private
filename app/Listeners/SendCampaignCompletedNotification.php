<?php

namespace App\Listeners;

use App\Events\CampaignCompleted;
use App\Services\TelegramNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampaignCompletedNotification implements ShouldQueue
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
        $this->telegramService->sendCampaignCompletedNotification($event->campaign);
    }
} 