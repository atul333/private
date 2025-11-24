<?php

namespace App\Http\Controllers\Instagram\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\InstagramProfile;
use App\Models\InstagramCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:advertiser']);
    }

    /**
     * Display the Instagram advertiser dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get advertiser's campaigns
        $campaigns = InstagramCampaign::where('advertiser_id', $user->id)
            ->with(['instagramProfile', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalSpent = InstagramCampaign::where('advertiser_id', $user->id)
            ->where('paid', true)
            ->sum('price');

        $activeCampaigns = InstagramCampaign::where('advertiser_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $pendingCampaigns = InstagramCampaign::where('advertiser_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $completedCampaigns = InstagramCampaign::where('advertiser_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return view('instagram.advertiser.dashboard', compact(
            'campaigns',
            'totalSpent',
            'activeCampaigns',
            'pendingCampaigns',
            'completedCampaigns'
        ));
    }
}
