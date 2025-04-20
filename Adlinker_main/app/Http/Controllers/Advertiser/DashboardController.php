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
        
        // Get all campaigns for total metrics
        $allCampaigns = Campaign::where('advertiser_id', $currentUser->id)->get();
        $activeCampaigns = $allCampaigns->where('status', 'active')->count();
        $completedCampaigns = $allCampaigns->where('status', 'completed')->count();
        $totalSpent = $allCampaigns->where('status', 'completed')->sum('price');
        $totalImpressions = $allCampaigns->sum(function($campaign) {
            return $campaign->ads()->sum('impressions');
        });

        // Get paginated campaigns for display
        $campaigns = Campaign::where('advertiser_id', $currentUser->id)
            ->orderByRaw("CASE 
                WHEN status = 'active' AND post_link IS NULL THEN 1
                WHEN status = 'active' AND post_link IS NOT NULL THEN 2
                WHEN status = 'completed' THEN 3
                WHEN status = 'pending' THEN 4
                ELSE 5
            END")
            ->paginate(6);

        return view('advertiser.dashboard', compact('campaigns', 'activeCampaigns', 'completedCampaigns', 'totalSpent', 'totalImpressions'));
    }
}