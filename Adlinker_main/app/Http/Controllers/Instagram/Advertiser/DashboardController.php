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
    public function index(Request $request)
    {
        $user = Auth::user();

        // Auto-expire: pending OR approved campaigns not completed within 24h of creation → refund advertiser
        $expiredCampaigns = InstagramCampaign::whereIn('status', ['pending', 'approved'])
            ->where('paid', true)
            ->where('created_at', '<=', now()->subHours(24))
            ->get();

        foreach ($expiredCampaigns as $campaign) {
            $campaign->update(['status' => 'expired']);

            $advertiser = \App\Models\User::find($campaign->advertiser_id);
            if ($advertiser && $advertiser->wallet) {
                $campaign->load('instagramProfile');
                $instagramId = $campaign->instagramProfile ? '@' . $campaign->instagramProfile->instagram_id : '';
                $reason = $campaign->getOriginal('status') === 'approved'
                    ? 'publisher approved but did not submit story link within 24 hours'
                    : 'publisher did not respond within 24 hours';
                $refundDesc = "[Instagram] Refund for expired Campaign #{$campaign->id}" . ($instagramId ? " on {$instagramId}" : '') . " — {$reason}";
                $advertiser->wallet->deposit($campaign->price, $refundDesc);
            }
        }

        // Auto-complete campaigns that have exceeded 24 hours after publishing
        $completedCampaigns = InstagramCampaign::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now()->subHours(24))
            ->get();

        foreach ($completedCampaigns as $campaign) {
            $campaign->update(['status' => 'completed']);

            if ($campaign->paid && $campaign->publisher_id) {
                $publisherUser = \App\Models\User::find($campaign->publisher_id);
                if ($publisherUser && $publisherUser->wallet) {
                    $campaign->load('instagramProfile');
                    $instagramId = $campaign->instagramProfile ? '@' . $campaign->instagramProfile->instagram_id : '';
                    $depositDesc = "[Instagram] Campaign #{$campaign->id} completed" . ($instagramId ? " on {$instagramId}" : '');
                    $publisherUser->wallet->deposit($campaign->price, $depositDesc);
                }
            }
        }

        // Build query for campaigns
        $query = InstagramCampaign::where('advertiser_id', $user->id)
            ->with(['instagramProfile', 'publisher']);

        // Apply status filter
        $status = $request->get('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        
        // Custom status priority for sorting
        // 1. Unpaid (highest priority - needs payment)
        // 2. Published (currently live)
        // 3. Paid but pending (awaiting approval)
        // 4. Completed
        // 5. Rejected (lowest priority)
        if ($sort === 'newest' || $sort === 'oldest') {
            // Use raw SQL for custom status ordering
            $statusOrder = "CASE 
                WHEN paid = 0 THEN 1
                WHEN status = 'published' THEN 2
                WHEN paid = 1 AND status = 'pending' THEN 3
                WHEN paid = 1 AND status = 'approved' THEN 3
                WHEN status = 'completed' THEN 4
                WHEN status = 'rejected' THEN 5
                WHEN status = 'expired' THEN 6
                ELSE 7
            END";
            
            $query->orderByRaw($statusOrder);
            
            // Then sort by date within each status group
            if ($sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            // For price sorting, still apply status priority first
            $statusOrder = "CASE 
                WHEN paid = 0 THEN 1
                WHEN status = 'published' THEN 2
                WHEN paid = 1 AND status = 'pending' THEN 3
                WHEN paid = 1 AND status = 'approved' THEN 3
                WHEN status = 'completed' THEN 4
                WHEN status = 'rejected' THEN 5
                WHEN status = 'expired' THEN 6
                ELSE 7
            END";
            
            $query->orderByRaw($statusOrder);
            
            // Then sort by price
            if ($sort === 'price-high') {
                $query->orderBy('price', 'desc');
            } else {
                $query->orderBy('price', 'asc');
            }
        }

        $campaigns = $query->paginate(10);

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
