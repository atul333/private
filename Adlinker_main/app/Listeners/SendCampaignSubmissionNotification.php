<?php

namespace App\Listeners;

use App\Events\CampaignLinkSubmitted;
use App\Services\TelegramNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampaignSubmissionNotification implements ShouldQueue
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
    public function handle(CampaignLinkSubmitted $event): void
    {
        $this->telegramService->sendCampaignSubmissionNotification(
            $event->campaign,
            $event->submittedLink
        );
    }
} 