<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request, $user)
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

        // Start building the query
        $query = Campaign::where('advertiser_id', $currentUser->id);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by channel name
        if ($request->filled('channel_name')) {
            $query->where('channel_name', 'like', '%' . $request->channel_name . '%');
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->start_date));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->end_date));
        }

        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price-high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'price-low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'duration-high':
                    $query->orderBy('duration', 'desc');
                    break;
                case 'duration-low':
                    $query->orderBy('duration', 'asc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            // Default sorting if no sort parameter
            $query->orderByRaw("CASE 
                WHEN status = 'active' AND post_link IS NULL THEN 1
                WHEN status = 'active' AND post_link IS NOT NULL THEN 2
                WHEN status = 'completed' THEN 3
                WHEN status = 'pending' THEN 4
                ELSE 5
            END");
        }

        // Get paginated results
        $campaigns = $query->paginate(6)->withQueryString();

        // Get unique statuses for filter dropdown
        $statuses = Campaign::where('advertiser_id', $currentUser->id)
            ->distinct()
            ->pluck('status');

        return view('advertiser.dashboard', compact(
            'campaigns', 
            'activeCampaigns', 
            'completedCampaigns', 
            'totalSpent', 
            'totalImpressions',
            'statuses'
        ));
    }
}