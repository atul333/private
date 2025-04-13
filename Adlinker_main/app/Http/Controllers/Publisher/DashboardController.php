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
        
        $channels = Channel::where('publisher_id', $currentUser->publisher->id)->paginate(6);
        $activeChannels = Channel::where('publisher_id', $currentUser->publisher->id)
            ->where('status', 'active')
            ->count();
        $totalEarnings = Channel::where('publisher_id', $currentUser->publisher->id)
            ->with('campaigns')
            ->get()
            ->sum(function($channel) {
                return $channel->campaigns->where('status', 'completed')->sum('price');
            });

        return view('publisher.dashboard', compact('channels', 'activeChannels', 'totalEarnings'));
    }
}