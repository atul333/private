<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\Registered;
use App\Listeners\SendEmailVerificationNotification;
use App\Events\NewCampaignAssigned;
use App\Listeners\SendCampaignNotification;
use App\Events\CampaignLinkSubmitted;
use App\Listeners\SendCampaignSubmissionNotification;
use App\Events\CampaignCompleted;
use App\Listeners\SendCampaignCompletedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\NewCampaignAssigned::class => [
            \App\Listeners\SendCampaignNotification::class,
        ],
        \App\Events\CampaignLinkSubmitted::class => [
            \App\Listeners\SendCampaignSubmissionNotification::class,
        ],
        \App\Events\CampaignCompleted::class => [
            \App\Listeners\SendCampaignCompletedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
} 