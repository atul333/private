<?php

namespace App\Services;

use App\Models\TelegramNotification;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    /**
     * Send notification when campaign is completed
     */
    public function sendCampaignCompletedNotification($campaign)
    {
        try {
            // Send notification to advertiser
            $advertiserNotification = TelegramNotification::where('user_id', $campaign->advertiser_id)
                ->where('is_active', true)
                ->first();

            if ($advertiserNotification) {
                $advertiserMessage = "🎉 Campaign Completed!\n";
                $advertiserMessage .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
                $advertiserMessage .= "📺 Channel: {$campaign->channel_name}\n\n";
                $advertiserMessage .= "Campaign Details:\n";
                $advertiserMessage .= "• Duration: {$campaign->duration} days\n";
                $advertiserMessage .= "• Price: $" . number_format($campaign->price, 2) . "\n";
                $advertiserMessage .= "• Start Date: " . $campaign->post_submitted_at->format('Y-m-d') . "\n";
                $advertiserMessage .= "• End Date: " . $campaign->post_submitted_at->addDays($campaign->duration)->format('Y-m-d') . "\n\n";
                $advertiserMessage .= "🔗 Post Link:\n";
                $advertiserMessage .= $campaign->post_link . "\n\n";
                $advertiserMessage .= "🌐 View campaign details:\n";
                $advertiserMessage .= "https://www.socialadlinker.com/login\n\n";
                $advertiserMessage .= "❓ Need help? Contact support:\n";
                $advertiserMessage .= "@AdLinkerSupportBot";

                $this->sendMessage($advertiserNotification->chat_id, $advertiserMessage);
            }

            // Send notification to publisher
            $publisherNotification = TelegramNotification::where('user_id', $campaign->publisher_id)
                ->where('is_active', true)
                ->first();

            if ($publisherNotification) {
                $publisherMessage = "💰 Campaign Payment Received!\n";
                $publisherMessage .= "━━━━━━━━━━━━━━━━━━━━━\n\n";
                $publisherMessage .= "📺 Channel: {$campaign->channel_name}\n\n";
                $publisherMessage .= "Campaign Details:\n";
                $publisherMessage .= "• Duration: {$campaign->duration} days\n";
                $publisherMessage .= "• Earnings: $" . number_format($campaign->price, 2) . "\n";
                $publisherMessage .= "• Start Date: " . $campaign->post_submitted_at->format('Y-m-d') . "\n";
                $publisherMessage .= "• End Date: " . $campaign->post_submitted_at->addDays($campaign->duration)->format('Y-m-d') . "\n\n";
                $publisherMessage .= "💳 Payment has been added to your wallet\n\n";
                $publisherMessage .= "🌐 View your earnings:\n";
                $publisherMessage .= "https://www.socialadlinker.com/login\n\n";
                $publisherMessage .= "❓ Need help? Contact support:\n";
                $publisherMessage .= "@AdLinkerSupportBot";

                $this->sendMessage($publisherNotification->chat_id, $publisherMessage);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Error sending campaign completion notification:', [
                'error' => $e->getMessage(),
                'campaign_id' => $campaign->id
            ]);
            return false;
        }
    }
} 