<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($user)
    {
        $currentUser = Auth::user();
        if ($currentUser->id != $user) {
            return redirect('/' . $currentUser->id . '/advertiser/dashboard');
        }
        
        $campaigns = Campaign::where('advertiser_id', $currentUser->id)
            ->orderByRaw("CASE 
                WHEN status = 'active' AND post_link IS NULL THEN 1
                WHEN status = 'active' AND post_link IS NOT NULL THEN 2
                WHEN status = 'completed' THEN 3
                WHEN status = 'pending' THEN 4
                ELSE 5
            END")
            ->paginate(6);
        $activeCampaigns = $campaigns->where('status', 'active')->count();
        $totalBudget = $campaigns->sum('budget');
        $totalImpressions = $campaigns->sum(function($campaign) {
            return $campaign->ads()->sum('impressions');
        });

        return view('advertiser.dashboard', compact('campaigns', 'activeCampaigns', 'totalBudget', 'totalImpressions'));
    }
}