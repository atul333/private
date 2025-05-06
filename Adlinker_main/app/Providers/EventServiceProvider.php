<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewCampaignAssigned;
use App\Listeners\SendCampaignNotification;
use App\Events\CampaignLinkSubmitted;
use App\Listeners\SendCampaignSubmissionNotification;
use App\Events\CampaignCompleted;
use App\Listeners\SendCampaignCompletionNotifications;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewCampaignAssigned::class => [
            SendCampaignNotification::class,
        ],
        CampaignLinkSubmitted::class => [
            SendCampaignSubmissionNotification::class,
        ],
        CampaignCompleted::class => [
            SendCampaignCompletionNotifications::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
