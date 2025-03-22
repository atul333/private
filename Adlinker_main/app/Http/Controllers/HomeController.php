<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->role === 'advertiser') {
            // Get basic campaign metrics
            $campaigns = $user->campaigns;
            $activeAds = 0;
            $totalSpent = 0;

            foreach ($campaigns as $campaign) {
                $activeAds += $campaign->ads()->where('status', 'active')->count();
                $totalSpent += $campaign->ads()->sum('budget');
            }

            $data = compact('campaigns', 'activeAds', 'totalSpent');
        } else if ($user->role === 'publisher') {
            $activeChannels = 0;
            $totalEarnings = 0;
            $data = compact('activeChannels', 'totalEarnings');
        }

        return view('home', $data);
    }
}
