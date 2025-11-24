<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformSelectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the platform selection page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('platform-selection', compact('user'));
    }

    /**
     * Redirect to the selected platform dashboard.
     */
    public function selectPlatform(Request $request)
    {
        $platform = $request->input('platform');
        $user = Auth::user();

        \Log::info('Platform Selection', [
            'platform' => $platform,
            'user_id' => $user->id,
            'user_role' => $user->role
        ]);

        switch ($platform) {
            case 'telegram':
                if ($user->role === 'advertiser') {
                    return redirect()->route('advertiser.dashboard', ['user' => $user->id]);
                } else {
                    return redirect()->route('publisher.dashboard', ['user' => $user->id]);
                }

            case 'instagram':
                \Log::info('Instagram selected, redirecting to dashboard');
                if ($user->role === 'advertiser') {
                    \Log::info('Redirecting to instagram.advertiser.dashboard');
                    return redirect()->route('instagram.advertiser.dashboard');
                } else {
                    \Log::info('Redirecting to instagram.publisher.dashboard');
                    return redirect()->route('instagram.publisher.dashboard');
                }

            case 'snapchat':
            case 'facebook':
            case 'youtube':
                return redirect()->route('platform.coming-soon', ['platform' => $platform]);

            default:
                return redirect()->back()->with('error', 'Invalid platform selected');
        }
    }

    /**
     * Display coming soon page for platforms.
     */
    public function comingSoon($platform)
    {
        return view('coming-soon', compact('platform'));
    }
}
