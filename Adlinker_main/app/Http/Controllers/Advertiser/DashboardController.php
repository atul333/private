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
        $activeAds = $campaigns->sum(function($campaign) {
            return $campaign->ads()->where('status', 'active')->count();
        });
        $totalSpent = $campaigns->sum(function($campaign) {
            return $campaign->ads()->sum('budget');
        });

        return view('advertiser.dashboard', compact('campaigns', 'activeAds', 'totalSpent'));
    }
}