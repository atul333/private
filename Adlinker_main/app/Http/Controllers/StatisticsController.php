<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        $totalChannels = Channel::count();
        $activeAdvertisers = User::where('role', 'advertiser')->count();
        $activePublishers = User::where('role', 'publisher')->count();

        return response()->json([
            'total_channels' => $totalChannels,
            'active_advertisers' => $activeAdvertisers,
            'active_publishers' => $activePublishers
        ]);
    }
}