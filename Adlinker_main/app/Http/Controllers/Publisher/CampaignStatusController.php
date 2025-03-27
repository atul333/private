<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class CampaignStatusController extends Controller
{
    public function show($user, Channel $channel)
    {
        $currentUser = Auth::user();
        if ($currentUser->id != $user) {
            return redirect('/' . $currentUser->id . '/publisher/dashboard');
        }

        $campaigns = Campaign::where('channel_id', $channel->id)
                            ->where('status', 'active')
                            ->get();

        return view('publisher.campaigns.status', compact('channel', 'campaigns'));
    }
}