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
                            ->orderByRaw("CASE 
                                WHEN status = 'Active' THEN 1
                                WHEN status = 'submitted' THEN 2
                                WHEN status = 'completed' THEN 3
                                ELSE 4 END")
                            ->get();

        return view('publisher.campaigns.status', compact('channel', 'campaigns'));
    }
}