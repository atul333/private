<?php

namespace App\Listeners;

use App\Events\CampaignCompleted;
use App\Services\TelegramNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('Sending campaign completion notifications', [
                'campaign_id' => $event->campaign->id,
                'advertiser_id' => $event->campaign->advertiser_id,
                'publisher_id' => $event->campaign->publisher_id
            ]);

            // Send notification to advertiser
            $this->telegramService->sendAdvertiserCampaignCompletionNotification($event->campaign);

            // Send notification to publisher
            $this->telegramService->sendPublisherCampaignCompletionNotification($event->campaign);
        } catch (\Exception $e) {
            Log::error('Error sending campaign completion notifications:', [
                'error' => $e->getMessage(),
                'campaign_id' => $event->campaign->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
} 