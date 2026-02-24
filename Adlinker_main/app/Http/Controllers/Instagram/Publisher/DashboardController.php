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
        
        // Auto-complete campaigns that have exceeded 24 hours
        $completedCampaigns = InstagramCampaign::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now()->subHours(24))
            ->get();

        foreach ($completedCampaigns as $campaign) {
            // Update campaign status to completed
            $campaign->update(['status' => 'completed']);

            // Credit publisher's wallet if campaign is paid
            if ($campaign->paid && $campaign->publisher_id) {
                $publisherUser = \App\Models\User::find($campaign->publisher_id);
                if ($publisherUser && $publisherUser->wallet) {
                    $campaign->load('instagramProfile');
                    $instagramId = $campaign->instagramProfile ? '@' . $campaign->instagramProfile->instagram_id : '';
                    $depositDesc = "Instagram Campaign #{$campaign->id} completed" . ($instagramId ? " on {$instagramId}" : '');
                    $publisherUser->wallet->deposit(
                        $campaign->price,
                        $depositDesc
                    );
                }
            }
        }
        
        // Get publisher's Instagram profiles
        $profiles = InstagramProfile::where('user_id', $user->id)
            ->withCount('campaigns')
            ->paginate(12);

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
