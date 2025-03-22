<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($user)
    {
        $currentUser = Auth::user();
        if ($currentUser->id != $user) {
            return redirect('/' . $currentUser->id . '/publisher/dashboard');
        }
        
        $channels = Channel::where('publisher_id', $currentUser->publisher->id)->get();
        $activeChannels = $channels->where('status', 'active')->count();
        $totalEarnings = $channels->sum('earnings');

        return view('publisher.dashboard', compact('channels', 'activeChannels', 'totalEarnings'));
    }
}