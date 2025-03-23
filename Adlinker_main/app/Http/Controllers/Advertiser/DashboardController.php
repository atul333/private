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
        
        $campaigns = Campaign::where('advertiser_id', $currentUser->id)->get();
        $activeCampaigns = $campaigns->where('status', 'active')->count();
        $totalBudget = $campaigns->sum('budget');
        $totalImpressions = $campaigns->sum(function($campaign) {
            return $campaign->ads()->sum('impressions');
        });

        return view('advertiser.dashboard', compact('campaigns', 'activeCampaigns', 'totalBudget', 'totalImpressions'));
    }
}