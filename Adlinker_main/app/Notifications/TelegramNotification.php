<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\TelegramNotificationService;
use App\Models\TelegramNotification as TelegramNotificationModel;

class TelegramNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $telegramNotification = TelegramNotificationModel::where('user_id', $notifiable->id)
            ->where('is_active', true)
            ->first();

        if ($telegramNotification) {
            $telegramService = new TelegramNotificationService();
            $telegramService->sendMessage($telegramNotification->chat_id, $this->message);
        }
    }
}