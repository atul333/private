<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;
use App\Models\Channel;

class NewCampaignAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $campaign;
    public $channel;

    /**
     * Create a new event instance.
     */
    public function __construct(Campaign $campaign, Channel $channel)
    {
        $this->campaign = $campaign;
        $this->channel = $channel;
    }
} 