<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;

class CampaignCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $campaign;

    /**
     * Create a new event instance.
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }
} 