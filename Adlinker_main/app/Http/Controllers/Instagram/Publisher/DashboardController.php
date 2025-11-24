<?php

namespace App\Http\Controllers\Instagram\Publisher;

use App\Http\Controllers\Controller;
use App\Models\InstagramProfile;
use App\Models\InstagramCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:publisher']);
    }

    /**
     * Display the Instagram publisher dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get publisher's Instagram profiles
        $profiles = InstagramProfile::where('user_id', $user->id)
            ->withCount('campaigns')
            ->get();

        // Get campaigns for publisher's profiles
        $campaigns = InstagramCampaign::where('publisher_id', $user->id)
            ->with(['instagramProfile', 'advertiser'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalEarnings = InstagramCampaign::where('publisher_id', $user->id)
            ->where('status', 'completed')
            ->where('paid', true)
            ->sum('price');

        $pendingCampaigns = InstagramCampaign::where('publisher_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $activeCampaigns = InstagramCampaign::where('publisher_id', $user->id)
            ->where('status', 'approved')
            ->count();

        return view('instagram.publisher.dashboard', compact(
            'profiles',
            'campaigns',
            'totalEarnings',
            'pendingCampaigns',
            'activeCampaigns'
        ));
    }
}
