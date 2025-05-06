<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;

class CampaignLinkSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $campaign;
    public $submittedLink;

    /**
     * Create a new event instance.
     */
    public function __construct(Campaign $campaign, string $submittedLink)
    {
        $this->campaign = $campaign;
        $this->submittedLink = $submittedLink;
    }
} 