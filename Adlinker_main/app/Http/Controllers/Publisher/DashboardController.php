<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $channels = Channel::where('publisher_id', $user->id)->get();
        $activeChannels = $channels->where('status', 'active')->count();
        $totalEarnings = $channels->sum('earnings');

        return view('publisher.dashboard', compact('channels', 'activeChannels', 'totalEarnings'));
    }
}