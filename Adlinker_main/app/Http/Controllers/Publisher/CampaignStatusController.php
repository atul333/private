<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignStatusController extends Controller
{
    public function show(Request $request, $user, Channel $channel)
    {
        $currentUser = Auth::user();
        if ($currentUser->id != $user) {
            return redirect('/' . $currentUser->id . '/publisher/dashboard');
        }

        $query = Campaign::where('channel_id', $channel->id);
        
        // Apply status filter
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
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
                WHEN status = 'active' THEN 1
                WHEN status = 'pending' THEN 2
                WHEN status = 'completed' THEN 3
                WHEN status = 'expired' THEN 4
                ELSE 5 END")
                ->orderBy('created_at', 'desc');
        }
        
        $campaigns = $query->paginate(6)->withQueryString();

        return view('publisher.campaigns.status', compact('channel', 'campaigns'));
    }
}